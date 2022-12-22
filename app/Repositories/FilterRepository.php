<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Currency;
use App\Models\Product;
use App\Models\ProductTranslation;
use Illuminate\Http\Request;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class FilterRepository
{

    public function filter(Request $request)
    {
//        dd($request->all());
        $convert_price_max = null;
        $convert_price_min = null;
        $currency  = Currency::query()->where('symbol','=','$')->first();
//       dd($request->all());
        $filter = Product::query()->with(['variants', 'translations']);
        if ($request->get('type') == 'category' or $request->get('type') == 'search') {
            if ($request->get('category') != null){
                if ($this->isParentCategory($request->get('category'))) {
                    $filter->whereHas('category', function ($q) use ($request) {
                        $q->where('parent_category', '=', $request->get('category'));
                    });
                } else {
                    $filter->where('category_id', '=', $request->get('category'));
                }
            }

        }else{
            if ($tag = $request->get('tag'))
                $filter->whereHas('tags', function ($q) use ($tag) {
                    $q->where('tag_id','=', $tag);
                });
        }


        if ($maxPrice = $request->get('max_price'))
            $convert_price_max = $maxPrice;
//            $convert_price_max = $maxPrice / $currency->rate;
//            dd($convert_price_max);
            $filter->when($convert_price_max,function ($q)use($convert_price_max){
                $q->where('price', '<=', $convert_price_max);
            });

        if ($minPrice = $request->get('min_price'))
            $convert_price_min = $minPrice;
//            $convert_price_min = $minPrice / $currency->rate;
            $filter->when($convert_price_min,function ($q)use($convert_price_min){
                $q->where('price', '>=', $convert_price_min);
            });

        if ($discount = $request->get('discount'))
            if ($discount == 50){
                $filter->where('discount_type', '=', Product::DISCOUNT_TYPE_PERCENTAGE)
                    ->where('discount_value', '>=', 40);
            }else{
                $filter->where('discount_type', '=', Product::DISCOUNT_TYPE_PERCENTAGE)
                    ->where('discount_value', '<=', $discount);
            }
            if ($tag = $request->get('tag'))
                $filter->whereHas('tags', function ($q) use ($tag) {
                    $q->where('tag_id','=', $tag);
                });

        if (!$request->get('type') == 'search') {
            if ($category = $request->get('category'))
                $filter->where('category_id', '=', $category);
        }

        if ($words = $request->get('search'))
            if ($words != "" and $words != null) {
                $tokens = convertToSeparatedTokens($words);
                $filter->whereHas('translations', function ($q) use ($tokens) {
                    $q->whereRaw("MATCH(name, description) AGAINST(? IN BOOLEAN MODE)", $tokens);
                });
            }
        return $this->sorted($filter, $request->get('sort'));
    }

    public function isParentCategory($id): bool
    {
        $category = Category::find($id);

        if ($category->parent_category == null) {
            return true;
        } else
            return false;
    }

    public function sorted($filter, $sort)
    {
        if ($sort == null)
            return $filter->sorted();
        if ($sort == 1)
            return $filter->orderBy('created_at');
        if ($sort == 0)
            return $filter->orderByDesc('created_at');
        if ($sort == 2) // TODO sort by name
            return $filter->whereHas('translations',function ($q){
                $q->orderBy('name');
            });
        if ($sort == 3)
            return $filter->whereHas('translations',function ($q){
                $q->orderByDesc('name');
            });
        if ($sort == 4) // TODO sort by price
            return $filter->orderBy('price');
        if ($sort == 5)
            return $filter->orderByDesc('price');
    }

    public function getParent($id)
    {
        $cateogry = Category::find($id);
        if ($this->isParentCategory($id))
            return $cateogry;
        else
            return Category::find($cateogry->parent_category);

    }

    public function search(Request $request)
    {
//        $tokens = '';
//        $search = Product::query()->with('translations');
//
//        if ($words = $request->get('search'))
//            if ($words != "" and $words != null) {
//                $tokens = convertToSeparatedTokens($words);
//                $search->whereHas('translations', function ($q) use ($tokens) {
//                    $q->whereRaw("MATCH(name, description) AGAINST(? IN BOOLEAN MODE)", $tokens);
//                });
//            }
        $results = Search::new()
            ->add(Product::class, ['translations.name', 'translations.description'])

            ->beginWithWildcard()
            ->endWithWildcard()
            ->orderByDesc()
            ->paginate(10)
            ->get($request->get('search'))
            ->all();
        return $results;
    }

}

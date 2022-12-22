<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Traits\ActionsTrait;
use App\Models\OptionValue;
use App\Models\Product;
use App\Models\User;
use App\Models\Variant;
use App\Models\VariantValue;
use App\Repositories\ProductRepository;
use App\Repositories\RequestRepository;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private $productRepository;
    public $resource = 'product';
    use ActionsTrait;

    public function __construct(ProductRepository $productRepository)
    {
        appendGeneralPermissions($this);
        $this->productRepository = $productRepository;
        view()->share('item', $this->resource);
        view()->share('class', Product::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.crud.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.crud.edit-new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return RedirectResponse
     */
    public function store(ProductRequest $request): RedirectResponse
    {
//        For Development Needs
//        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
//        DB::table('products')->truncate();
//        DB::table('product_translations')->truncate();
//        DB::table('options')->truncate();
//        DB::table('option_values')->truncate();
//        DB::table('variants')->truncate();
//        DB::table('variant_values')->truncate();
//        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        if ($request->variant_options == '1' && !isset($request->options))
        {
            $request->session()->flash('error', 'Need At Least one Option');
            return redirect()->back();
        }

        $this->productRepository->add($request);

        $request->session()->flash('success', __($this->resource . '.' . $this->resource . '_created_successfully'));

        if ($request->has('add-new'))
            return redirect()->route('admin.products.create');

        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return View
     */
    public function show(Product $product): View
    {
        $categories = $this->productRepository->getCategories();
        return view('admin.product.show', compact('product', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return View|Response
     */
    public function edit(Product $product)
    {
        return view('admin.crud.edit-new', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $this->productRepository->update($request, $product);
        $request->session()->flash('success', __($this->resource . '.' . $this->resource . '_updated_successfully'));

        if ($request->has('add-new'))
            return redirect()->back();

        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param ProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroy(ProductRequest $request, Product $product): RedirectResponse
    {
        $this->productRepository->delete($product);
        $request->session()->flash('success', __($this->resource . '.' . $this->resource . '_deleted_successfully'));
        return redirect()->route('admin.products.index');
    }

    public function productsAutoComplete(Request $request): JsonResponse
    {
        $search = $request->get('search');
        $models = $this->productRepository->productsAutoComplete($search);

        return response()->json([
            'results' => $models
        ]);
    }

    public function removeImage(Request $request): string
    {
        $item = Product::query()->find($request->get('id'));
        $images = [];
        foreach ($item->images as $image) {
            if ($image == $request->get('image')) {
                Storage::disk('public')->delete($image);
            } else {
                $images[] = $image;
            }
        }
        $item->images = $images;
        $item->save();

        return 'image removed successfully';
    }

    public function getProducts(Request $request, ProductRepository $productRepository): JsonResponse
    {
        $products = $productRepository->getProductsDataTable($request);
        $data = [];

        foreach ($products as $product) {
            $imageUrl = $product->featured_image ? storageImage($product->featured_image) : ($product->images ? storageImage($product->images[0]) : '#');

                $data[] = [
                    'RecordID' => $product->id,
                    'id' => $product->id,
                    'image' => $this->getImageUrl($imageUrl, $product->id),
                    'creator' => $product->creator->name ?? 'N/A',
                    'name' => $product->name,
                    'price' => $product->price,
                    'discount'=> $product->discount_value == null ? '' :($product->discount_type == Product::DISCOUNT_TYPE_PERCENTAGE ? $product->discount_value .' %'
                    :($product->currency_type == Product::CURRENCY_TYPE_LB ? $product->discount_value." LL": $product->discount_value.' $')),
                    'tag'=>getNameTag($product->tags),
                    'sku' => $product->sku,
                    'owner' => $product->owner->name,
                    'created_at' => Date::parse($product->created_at)->format('Y-m-d'),
                    'status' => $product->status,
                    'approval' => $product->approval,
                    'actions' => $this->getItemActions($product, $this->resource)
                ];



        }

        return response()->json(
            [
                "meta" => [
                    "page" => $products->currentPage(),
                    "pages" => $products->lastPage(),
                    "perpage" => $products->perPage(),
                    "total" => $products->total(),
                    "sort" => $request->get('sort')['sort'] ?? 0,
                    "field" => $request->get('sort')['field'] ?? ''
                ],
                "data" => $data,
            ]
        );
    }

    public function setStatus(Request $request, $id): string
    {
        $className = modelName($request->get('type') ?? 'product');
        $item = $className::find($id);
        $item->status = $request->get('status');
        $item->save();

        return "Edit Status Successfully";
    }

    public function deleteVariant(Variant $variant)
    {
        $variant->delete();

        return response()->json(['message' => 'Variant Deleted Successfully',]);
    }

    public function addVariant(Product $product, Request $request)
    {
        $optionIds = array_values($request->options);
        foreach ($product->variants as $variant) {
            $variant_value_equals_options = $variant->values()->whereIn('option_value_id', $optionIds)->get();
            if (count($variant_value_equals_options) == count($optionIds)) {
                $request->session()->flash('success', 'This Variant Is Already Exist, You Can Edit it From Variants Table.');
                return redirect()->back();
            }
        }

//     Create New Variant
        $variantModel = Variant::create([
            'product_id' => $product->id,
            'price' => trim($request->get('price')),
            'cost_price' => trim($request->get('cost_price')),
            'sku' => $request->get('sku'),
            'is_in_stock' => $request->get('stock') == 'on' ? 1 : 0,
            'image' => $request->hasFile('image') ? Storage::disk('public')->put('products/variants', $request->file('image')) : '',
        ]);
//     Create Values For The New Variant
        foreach ($request->get('options') as $name => $value_id) {
            // now create the variant options values
            $optionValue = OptionValue::find($value_id);
            VariantValue::create([
                'variant_id' => $variantModel->id,
                'option_id' => $optionValue->option->id,
                'option_value_id' => $optionValue->id,
            ]);
        }

        $request->session()->flash('success', 'New Variant Added Successfully');
        return redirect()->back();
    }


}

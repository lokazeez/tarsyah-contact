<?php

use App\Models\Admin;
use App\Models\Banner;
use App\Models\Cart;
use App\Models\Category;
use App\Models\City;
use App\Models\Product;
use App\Models\User;

function getMainProductCategories()
{
    return Category::query()->active()->sorted()->whereNull('parent_category')->paginate(9);
}

function checkArabicLang(): bool
{
    if (session()->get('lang') == 'ar' or app()->getLocale() == 'ar')
        return true;

    return false;
}

function checkCurrentLang()
{
    if (session()->get('lang') == 'ar' or app()->getLocale() == 'ar')
    return true;

return false;
}

function getCountCartItems(): int
{
    $cart = Cart::with('items')->notActive()
        ->where('user_id', auth('user')->id())
        ->orderByDesc('created_at')->first();
    if ($cart) {
        if ($cart->items)
            return count($cart->items);
    }
    return 0;
}
function getCountWishlistItems(): int
{
    $user = auth('user')->user();
    $items = $user->wishList()->count();
    if ($items) {
        return $items;
    }
    return 0;
}

function getTotalPrice($subTotalPrice , $shippingPrice): float
{
    $finalPrice = $subTotalPrice + $shippingPrice;
    return round($finalPrice , 2);
}

function getCountFavoriteItems(): int
{
    $user = auth('user')->user();
    $items = $user->wishList()->count();
    if ($items) {
        return $items;
    }
    return 0;
}


function getRandomVendor()
{
    return Admin::query()->active()->role('vendor')->take(8)->get();
}


function getBanners()
{
    return Banner::query()
        ->sorted()
//        ->where('model_type', '!=', 'App\Models\Category')
        ->orderByDesc('created_at')->take(5)->get();
}

function getBannerCategories()
{
    return Category::active()
        ->whereNull('parent_category')
        ->whereHas('subcategories', function ($query){
            $query->withCount('products')
                ->having('products_count', '>', 0);
        })
        ->take(3)->get();
}

function getRandomProducts(Category $category)
{
    $categories = Category::query()->active()
        ->where('parent_category', $category->id)->pluck('id');
    return Product::query()->active()
        ->whereIn('category_id', $categories)->
        inRandomOrder()->take(8)->get();
}

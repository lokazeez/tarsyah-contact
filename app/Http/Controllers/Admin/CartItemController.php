<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ActionsTrait;
use App\Models\CartItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    private $deliveryRepository;
    public $resource = 'cartItem';
    use ActionsTrait;
    public function __construct()
    {
        appendGeneralPermissions($this);
        view()->share('item', $this->resource);
        view()->share('class', CartItem::class);
    }
    public function edit(CartItem $cartItem)
    {
        return view('admin.crud.edit-new', compact('cartItem'));
    }

    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
//dd($request->all());
    if ($qty = $request->get('qty')){
        $cartItem->update([
            'qty' => $qty ,
            'price_ll' => $cartItem->variant ?
                calculatePriceDiscount($cartItem->variant->retail_price, $cartItem->product->discount_value, $cartItem->product->discount_type) * $qty
                :calculatePriceDiscount($cartItem->product->retail_price, $cartItem->product->discount_value, $cartItem->product->discount_type) * $qty,
            'price_before_discount_ll' => $cartItem->variant ? $cartItem->variant->retail_price * $qty : $cartItem->product->retail_price * $qty,
            'price_usd' => $cartItem->variant ?
                calculatePriceDiscount($cartItem->variant->price, $cartItem->product->discount_value, $cartItem->product->discount_type) * $qty
                : calculatePriceDiscount($cartItem->product->price, $cartItem->product->discount_value, $cartItem->product->discount_type) * $qty,
            'price_before_discount_usd' =>$cartItem->variant ? ($cartItem->variant->price * $qty) : ($cartItem->product->price * $qty),

        ]);
    }


        return redirect()->route('admin.deliveries.index');

    }
}

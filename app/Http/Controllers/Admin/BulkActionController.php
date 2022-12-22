<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class BulkActionController extends Controller
{


    public function deleteItems(Request $request): int
    {
        modelName($request->get('type'))::whereIn('id', $request->get('data'))->delete();
        return 0;
    }

    public function costPrice(Request $request): int
    {
        $className = modelName($request->get('type'));
        $items = $className::whereIn('id', $request->get('data'))->get();
        actionPrice($items,$request,'cost_price');

        return 0;
    }

    public function discount(Request $request): int
    {

        $className = modelName($request->get('type'));
        $items = $className::whereIn('id', $request->get('data'))->get();
        actionDiscount($items,$request,'discount_type','discount_value');
        return 0;
    }

    public function retailPrice(Request $request): int
    {

        $items = modelName($request->get('type'))::whereIn('id', $request->get('data'))->get();
        actionPrice($items,$request,'price');
        foreach ($items as $product){
            foreach ($product->variants as $variant){
                if ($request->get('operations') == Product::INCREMENT){
                    $variant->update(['price' => $variant->price + getPercentageValue($variant->price ,$request->get('value')) ]);
                }else{
                    $variant->update(['price' => $variant->price - getPercentageValue($variant->price ,$request->get('value')) ]);
                }
            }
        }
        return 0;
    }
    public function resetPrice(Request $request): int
    {
        $items = modelName($request->get('type'))::whereIn('id', $request->get('data'))->get();
        foreach ($items as $item){
            $item->price = $item->cost_price;
            $item->save();
        }
        foreach ($items as $product){
            foreach ($product->variants as $variant){
                    $variant->update(['price' => $variant->cost_price ]);
            }
        }
        return 0;
    }

    public function shippingTime(Request $request): int
    {
        $className = modelName($request->get('type'));
        $items = $className::whereIn('id', $request->get('data'))->get();
        foreach ($items as $item) {
            $item->delivery_time = $request->get('delivery_time');
            $item->save();
        }
        return 0;
    }

    public function assignTag(Request $request): int
    {
//        dd($request->all());
        $className = modelName($request->get('type'));
        $items = $className::whereIn('id', $request->get('data'))->get();
        foreach ($items as $item) {
            $item->tags()->sync($request->get('tags')) ;
        }
        return 0;
    }
    public function resetTag(Request $request): int
    {
        $className = modelName($request->get('type'));
        $items = $className::whereIn('id', $request->get('data'))->get();
        foreach ($items as $item) {
            $item->tags()->detach();
        }
        return 0;
    }

    public function approvalProduct(Request $request): int
    {
        if (auth()->user()->hasRole('Admin')) {
            $className = modelName($request->get('type'));
            $items = $className::whereIn('id', $request->get('data'))->get();
            foreach ($items as $item) {
                $item->approval = $request->get('value') == Product::APPROV ? Product::APPROV : Product::UNAPPROV;
                $item->save();
            }
        }
        return 0;
    }

    public function statusProduct(Request $request): int
    {
        $className = modelName($request->get('type'));
        $items = $className::whereIn('id', $request->get('data'))->get();
        foreach ($items as $item) {
            $item->status = $request->get('value') == 1 ? 1 : 0;
            $item->save();
        }
        return 0;
    }



    public function exportEXL(Request $request)
    {
        $className = modelName($request->get('type'));
    }
}

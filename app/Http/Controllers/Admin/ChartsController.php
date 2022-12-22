<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Cart;
use App\Models\City;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Repositories\OrderRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ChartsController extends Controller
{
    public function vendorsChartData(): JsonResponse
    {
        $vendors = Admin::query()->role('vendor')->get();
        $allData = [];
        foreach ($vendors as $vendor) {
            $orders = DB::table('orders')
                ->select(DB::raw('DATE_FORMAT(created_at, "%b") as month ,count(*) as orderCount, sum(total_price) as totalSales'))
                ->where('created_at', '>=', Carbon::now()->startOfYear())
                ->where('admin_id', $vendor->id)
                ->groupBy(DB::raw('DATE_FORMAT(created_at, "%b")'))->get();

            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $i = 0;
            $data = [];
            $item = [];

            if (count($orders) > 0)
                foreach ($months as $month) {
                    if ($orders[$i]->month == $month) {
                        $data[] = floatval($orders[$i]->totalSales);
                        if (sizeof($orders) - 1 > $i)
                            $i++;
                    } else {
                        $data[] = 0;
                    }
                }

            $item['data'] = $data;
            $item['name'] = $vendor->name;

            if (count($data) > 0)
                $allData[] = $item;
        }
        return response()->json($allData);
    }

    public function chartData(): JsonResponse
    {
        $orders = DB::table('orders')
            ->select(DB::raw('DATE_FORMAT(created_at, "%b") as month ,count(*) as orderCount'))
            ->where('created_at', '>=', Carbon::now()->startOfYear())
            ->where('admin_id', auth()->id())
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%b")'))->get();

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $i = 0;
        $data = [];

        foreach ($months as $month) {
            if (count($orders) > 0) {
                if ($orders[$i]->month == $month) {
                    $data[] = $orders[$i]->orderCount;
                    if (sizeof($orders) - 1 > $i)
                        $i++;
                }
            } else {
                $data[] = 0;
            }
        }

        return response()->json($data);
    }

    public function donutCustomersCartData(): JsonResponse
    {
        $activeUsers = User::query()->where('status', 1)->count();
        $inActiveUsers = User::query()->where('status', 0)->count();
        $vendors = Admin::query()->role('vendor')->count();

        $buyerUsers = User::query()
            ->withCount('orders')
            ->having('orders_count', '>', 1)->get()->count();

        return response()->json([
            $activeUsers,
            $inActiveUsers,
            $vendors,

            $buyerUsers
        ]);
    }

    public function topProductsSellingUSD()
    {
        $product_usd = Order::query()->join('carts', 'carts.order_id', '=', 'orders.id')
            ->join('cart_items', 'cart_items.cart_id', '=', 'carts.id')
            ->join('products', 'products.id', '=', 'cart_items.product_id')
            ->join('product_translations', 'products.id', '=', 'product_translations.product_id')
            ->select(DB::raw('product_translations.name as name , sum(cart_items.price_usd) as value'))
            ->where('products.currency_type', '=', Product::CURRENCY_TYPE_USD)
            ->where('carts.status', '=', 1)
            ->groupBy(['name'])->orderByDesc('value')->pluck('value','name')->take(5)->toArray();

        return response()->json(['value'=>array_values($product_usd),'name'=>array_keys($product_usd),'currency'=>'USD','title'=>'Top Five Selling Products by USD']);
    }

    public function topProductsSellingLL()
    {
        $product_ll = Order::query()->join('carts', 'carts.order_id', '=', 'orders.id')
            ->join('cart_items', 'cart_items.cart_id', '=', 'carts.id')
            ->join('products', 'products.id', '=', 'cart_items.product_id')
            ->join('product_translations', 'products.id', '=', 'product_translations.product_id')
            ->select(DB::raw('product_translations.name as name , sum(cart_items.price_ll) as value'))
            ->where('carts.status', '=', 1)
            ->groupBy(['name'])->orderByDesc('value')->pluck('value','name')->take(5)->toArray();

        return response()->json(['value'=>array_values($product_ll),'name'=>array_keys($product_ll),'currency'=>'LL','title'=>'Top Five Selling Products by LL']);
    }

    public function totalSalesByDateUSD()
    {
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $data = [];
        $orders = DB::table('orders')
            ->select(DB::raw('DATE_FORMAT(created_at, "%b") as month ,sum(orders.total_price_usd) as price_usd'))
            ->where('created_at', '>=', Carbon::now()->startOfYear())
            ->where('admin_id', auth()->id())
            ->groupBy(['month'])->pluck('price_usd','month')->all();
        foreach ($months as $month) {
                if (in_array($month,array_keys($orders),true)) {
                    $data[] = $orders[$month];
                } else {
                    $data[] = 0;
                }
        }
            return response()->json([['name'=>'products','data'=>$data,'currency'=>'USD','title'=>'Total Sales By USD Per Month']]);
        }
        public function totalSalesByDateLL()
        {
            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            $data = [];
            $orders = DB::table('orders')
                ->select(DB::raw('DATE_FORMAT(created_at, "%b") as month ,sum(orders.total_price_ll) as price_ll'))
                ->where('created_at', '>=', Carbon::now()->startOfYear())
                ->where('admin_id', auth()->id())
                ->groupBy(['month'])->pluck('price_ll','month')->all();
            foreach ($months as $month) {
                if (in_array($month,array_keys($orders),true)) {
                    $data[] = $orders[$month];
                } else {
                    $data[] = 0;
                }
            }
            return response()->json([['name'=>'products','data'=>$data,'currency'=>'LL','title'=>'Total Sales By LL Per Month']]);
        }
        public function totalSalesCategoryByUSD()
        {
            $total_sales_usd_by_category = Order::query()->join('carts', 'carts.order_id', '=', 'orders.id')
                ->join('cart_items', 'cart_items.cart_id', '=', 'carts.id')
                ->join('products', 'products.id', '=', 'cart_items.product_id')
                ->join('categories', 'categories.id', '=', 'products.category_id')
                ->join('category_translations', 'category_translations.category_id', '=', 'categories.id')
                ->select(DB::raw('category_translations.name as name , sum(cart_items.price_usd) as value'))
                ->where('products.currency_type', '=', Product::CURRENCY_TYPE_USD)
                ->groupBy(['name'])->orderByDesc('value')->pluck('value','name')->take(5)->toArray();

            return response()->json(['value'=>array_values($total_sales_usd_by_category),'labels'=>array_keys($total_sales_usd_by_category),'currency'=>'USD','title'=>'Total sales Products by USD per category ']);
        }


        public function totalSalesCategoryByLL()
        {
            $total_sales_ll_by_category = Order::query()->join('carts', 'carts.order_id', '=', 'orders.id')
                ->join('cart_items', 'cart_items.cart_id', '=', 'carts.id')
                ->join('products', 'products.id', '=', 'cart_items.product_id')
                ->join('categories', 'categories.id', '=', 'products.category_id')
                ->join('category_translations', 'category_translations.category_id', '=', 'categories.id')
                ->select(DB::raw('category_translations.name as name , sum(cart_items.price_ll) as value'))
                ->groupBy(['name'])->orderByDesc('value')->pluck('value','name')->take(5)->toArray();

            return response()->json(['value'=>array_map('intval', array_values($total_sales_ll_by_category)),'labels'=>array_keys($total_sales_ll_by_category),'currency'=>'LL','title'=>'Total sales Products by LL per category ']);
        }

        public function totalProductOrderedLL()
        {
            $product_ordered = Order::query()->join('carts', 'carts.order_id', '=', 'orders.id')
                ->join('cart_items', 'cart_items.cart_id', '=', 'carts.id')
                ->join('products', 'products.id', '=', 'cart_items.product_id')
                ->join('product_translations', 'products.id', '=', 'product_translations.product_id')
                ->select(DB::raw('product_translations.name as name , count(cart_items.qty) as countProduct'))
                ->groupBy(['name'])->orderByDesc('countProduct')->get();

            return response()->json(['value'=>array_values($product_ordered),'name'=>array_keys($product_ordered),'currency'=>'qty','title'=>'Total sales Products by LL per Quantity ']);
        }


    public function totalProductOrderedUSD()
    {
        $product_ordered = Order::query()->join('carts', 'carts.order_id', '=', 'orders.id')
            ->join('cart_items', 'cart_items.cart_id', '=', 'carts.id')
            ->join('products', 'products.id', '=', 'cart_items.product_id')
            ->join('product_translations', 'products.id', '=', 'product_translations.product_id')
            ->select(DB::raw('product_translations.name as name , sum(cart_items.qty) as countProduct'))
            ->where('products.currency_type', '=', Product::CURRENCY_TYPE_USD)
            ->groupBy(['name'])->orderByDesc('countProduct')->pluck('countProduct','name')->take(5)->toArray();;

        return response()->json(['value'=>array_values($product_ordered),'name'=>array_keys($product_ordered),'currency'=>'qty','title'=>'Total sales Products by USD per Quantity ']);
    }

        public function totalVendorSalesUSD()
        {
            $vendor_sales_usd = Admin::query()->join('orders', 'admins.id', '=', 'orders.admin_id')
                ->select(DB::raw('admins.name as vendorName , sum(orders.total_price_usd) as vendorSales'))
                ->groupBy(['vendorName'])->orderByDesc('vendorSales')->pluck('vendorSales','vendorName')->all();

            return  response()->json(['value'=>array_map('intval', array_values($vendor_sales_usd)),'labels'=>array_keys($vendor_sales_usd),'currency'=>'LL','title'=>'Total sales Products by USD per Vendor']);
        }

        public function totalVendorSalesLL()
        {
            $vendor_sales_ll = Admin::query()->join('orders', 'admins.id', '=', 'orders.admin_id')
                ->select(DB::raw('admins.name as vendorName , sum(orders.total_price_ll) as vendorSales'))
                ->groupBy(['vendorName'])->orderByDesc('vendorSales')->pluck('vendorSales','vendorName')->all();

            return  response()->json(['value'=>array_map('intval', array_values($vendor_sales_ll)),'labels'=>array_keys($vendor_sales_ll),'currency'=>'LL','title'=>'Total sales Products by LL per Vendor']);
        }
    }

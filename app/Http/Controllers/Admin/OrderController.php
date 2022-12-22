<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Repositories\OrderRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\View\View;

class OrderController extends Controller
{
    public $resource = 'order';

    public function __construct()
    {
        appendGeneralPermissions($this);
        view()->share('item', $this->resource);
        view()->share('class', Order::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('admin.crud.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Order $order): \Illuminate\Contracts\View\View
    {
        return view('admin.order.show', compact('order'));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Order $order
     * @return string
     */
    public function setOrderStatus(Request $request, Order $order): string
    {
        $order->status = $request->get('status');
        $order->save();

        return "Edit Status Order Successfully";
    }

    public function getOrders(Request $request,OrderRepository $orderRepository): JsonResponse
    {
        $orders = $orderRepository->getOrdersDataTable($request);

        $data = [];

        foreach ($orders as $order){
            $data[] = [
                'id' => $order->id,
                'code' => $order->code,
                'user_id' => $order->user->name,
                'admin_id' => $order->vendor->name,
                'created_at' => Date::parse($order->created_at)->format('Y-m-d'),
                'status' => $order->status,
            ];
        }

        return response()->json(
            [
                "meta"=> [
                    "page"=> $orders->currentPage(),
                    "pages"=> $orders->lastPage(),
                    "perpage"=> $orders->perPage(),
                    "total"=> $orders->total() ,
                    "sort"=> $request->get('sort')['sort'] ?? 0,
                    "field"=> $request->get('sort')['field'] ?? ''
                ],
                "data"=> $data,
            ]
        );
    }

    public function getOrdersWithProducts(Request $request,OrderRepository $orderRepository):JsonResponse
    {
        $orders = $orderRepository->getOrdersExcelReport($request);

    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ActionsTrait;
use App\Models\CartItem;
use App\Models\Delivery;
use App\Repositories\DeliveryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class DeliveryController extends Controller
{
    private $deliveryRepository;
    public $resource = 'delivery';
    use ActionsTrait;

    public function __construct(DeliveryRepository $deliveryRepository)
    {
        appendGeneralPermissions($this);
        $this->deliveryRepository = $deliveryRepository;
        view()->share('item', $this->resource);
        view()->share('class', Delivery::class);
    }
    public function index(Request $request)
    {
        return view('admin.crud.index');
    }


    public function create()
    {
        return view('admin.crud.edit-new');
    }


    public function store(Request $request): RedirectResponse
    {

        $this->deliveryRepository->add($request);

        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_created_successfully'));

        if ($request->has('add-new'))
            return redirect()->route('admin.categories.create');

        return redirect()->route('admin.categories.index');
    }

    public function show(Delivery $delivery)
    {
        return view('admin.delivery.show', compact('delivery'));
    }


    public function edit(CartItem $cartItem)
    {
        return view('admin.crud.edit-new', compact('cartItem'));
    }


    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
//        $this->deliveryRepository->update($request, $delivery);
//
//        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_updated_successfully'));
//
//        if ($request->has('add-new'))
//            return redirect()->back();

        $cartItem->update(['qty'=>$request->get('qty')]);

        return redirect()->route('admin.orderDetail.index');

    }


    public function destroy(Request $request, Delivery $delivery): RedirectResponse
    {
        $this->deliveryRepository->delete($delivery);
        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_deleted_successfully'));
        return redirect()->route('admin.orderDetail.index');
    }

    public function getDeliveries(Request $request):JsonResponse
    {
        $deliveries = $this->deliveryRepository->getDeliveriesDatatable($request);

        $data = [];

        foreach ($deliveries as $delivery){
            $data[] = [
                'RecordID'=>$delivery->id,
                'id'=>$delivery->id,
                'order_id'=>$delivery->orderDetail->serial_number,
                'coupon' => $delivery->orderDetail->code,
                'customer' =>$delivery->orderDetail->user->name,
                'phone' => $delivery->orderDetail->user->phone_number,
                'total_price'=>$delivery->total_price,
                'delivery_date' => $delivery->delivery_date,
                'delivery_fees'=> $delivery->orderDetail->shipping_fees,
                'status' => $delivery->status,
            //    'actions'=>$this->getItemActions($delivery, $this->resource)
            ];
        }

        return response()->json(
            [
                "meta"=> [
                    "page"=> $deliveries->currentPage(),
                    "pages"=> $deliveries->lastPage(),
                    "perpage"=> $deliveries->perPage(),
                    "total"=> $deliveries->total() ,
                    "sort"=> $request->get('sort')['sort'] ?? 0,
                    "field"=> $request->get('sort')['field'] ?? ''
                ],
                "data"=> $data,
            ]
        );
    }

//    public function updateItem(Request $request , $id){
//
//    }

    public function getDeliveryItems(Request $request ,$id):JsonResponse
    {
        $items = $this->deliveryRepository->getDeliveryItemsDatatable($request , $id);
        $data = [];

        foreach ($items as $item){
            $data[] = [
                'id'=>$item->id,
                'name' => $item->product_name,
                'variant' =>getOptionVariant($item->variant),
                'qty' => $item->qty,
                'price' => $item->price_ll,
                'item' => $item->status ?? 1,
                'actions'=>$this->getItemActions($item, 'cartItem')
            ];
        }

        return response()->json(
            [
                "meta"=> [
                    "page"=> $items->currentPage(),
                    "pages"=> $items->lastPage(),
                    "perpage"=> $items->perPage(),
                    "total"=> $items->total() ,
                    "sort"=> $request->get('sort')['sort'] ?? 0,
                    "field"=> $request->get('sort')['field'] ?? ''
                ],
                "data"=> $data,
            ]
        );
    }
    public function setDeliveryStatus(Request $request, $id): string
    {

        $item = Delivery::find($id);
        $item->status = $request->get('status');
        $item->save();

        return "Edit Status Successfully";
    }
    public function setItemStatus(Request $request, $id): string
    {

        $item = CartItem::find($id);
        $item->status = $request->get('status');
        $item->save();

        return "Edit Status Successfully";
    }
}

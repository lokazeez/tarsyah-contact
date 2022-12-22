<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Repositories\ShipmentRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class ShipmentController extends Controller
{

    private $shipmentRepository;
    public $resource = 'shipment';

    public function __construct(ShipmentRepository $shipmentRepository)
    {
        appendGeneralPermissions($this);
        $this->shipmentRepository = $shipmentRepository;
        view()->share('item', $this->resource);
        view()->share('class', Shipment::class);
    }
    public function index(){
        $shipments = Shipment::all();
        return view('admin.crud.index', compact('shipments'));
    }

    public function edit(Shipment $shipment){
        return view('admin.crud.edit-new', compact('shipment'));
    }
    public function update(Request $request ,Shipment $shipment):RedirectResponse
    {
//        dd($request->all());

        $this->shipmentRepository->update($request, $shipment);
        return redirect()->route('admin.shipments.index');
    }
}

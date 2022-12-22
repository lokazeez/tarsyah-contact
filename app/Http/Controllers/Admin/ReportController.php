<?php


namespace App\Http\Controllers\Admin;


use App\Exports\ProductsExport;
use App\Exports\ReportsExport;
use App\Http\Controllers\Controller;
use App\Repositories\ReportRepository;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    private $reportRepository;
    public $resource = 'report';

    public function __construct(ReportRepository $reportRepository)
    {
        $this->middleware(['permission:list ' . Str::plural($this->resource)]);
        $this->reportRepository = $reportRepository;
        view()->share('item', $this->resource);
    }


    /**
     *  Display a listing of the sales details.
     *
     * @param Request $request
     * @return View
     */
    public function salesDetailsIndex(Request $request): View
    {
        $reports = $this->reportRepository
            ->getSalesDetails($request)
            ->paginate(10);
        return view('admin.report.index', ['methodName' => 'salesDetails', 'reports' => $reports]);
    }

    public function salesPerVendorLL(Request $request): View
    {
        $reports = $this->reportRepository
            ->getSalesPerVendorLL($request)
            ->paginate(10);

        return view('admin.report.index', ['methodName' => 'salesPerVendorLL', 'reports' => $reports]);
    }

    public function salesPerVendorUSD(Request $request): View
    {
        $reports = $this->reportRepository
            ->getSalesPerVendorUSD($request)
            ->paginate(10);

        return view('admin.report.index', ['methodName' => 'salesPerVendorUSD', 'reports' => $reports]);
    }

    public function salesPerProduct(Request $request): View
    {
        $reports = $this->reportRepository
            ->getSalesPerProduct($request)
            ->paginate(10);

        return view('admin.report.index', ['methodName' => 'salesPerProduct', 'reports' => $reports]);
    }

    public function salesPerCategoryLL(Request $request): View
    {
        $reports = $this->reportRepository
            ->getSalesPerCategoryLL($request)
            ->paginate(10);

        return view('admin.report.index', ['methodName' => 'salesPerCategoryLL', 'reports' => $reports]);
    }

    public function salesPerCategoryUSD(Request $request): View
    {
        $reports = $this->reportRepository
            ->getSalesPerCategoryUSD($request)
            ->paginate(10);

        return view('admin.report.index', ['methodName' => 'salesPerCategoryUSD', 'reports' => $reports]);
    }

    public function salesPerMonthUSD(Request $request): View
    {
        $reports = $this->reportRepository
            ->getSalesPerMonthUSD($request)
            ->paginate(10);

        return view('admin.report.index', ['methodName' => 'salesPerMonthUSD', 'reports' => $reports]);
    }

    public function salesPerMonthLL(Request $request): View
    {
        $reports = $this->reportRepository
            ->getSalesPerMonthLL($request)
            ->paginate(10);

        return view('admin.report.index', ['methodName' => 'salesPerMonthLL', 'reports' => $reports]);
    }

    /**
     *  generate PDF Report.
     *
     * @param Request $request
     * @return Redirector
     */
    public function generatePDF(Request $request): Redirector
    {
        $result = $this->getExportData($request);

        if (!$result)
            return redirect(route('dashboard'));

        $pdf = PDF::loadView('admin.report.pdfComponent', ['headers' => $result['headers'], 'reports' => $result['reports']]);
        return $pdf->download('Report-' . Carbon::now() . '.pdf');
    }

    /**
     *  generate csv Report.
     *
     * @param Request $request
     * @return Redirector|BinaryFileResponse
     */
    public function exportCSV(Request $request)
    {
        $result = $this->getExportData($request);

        if (!$result)
            return redirect(route('dashboard'));

        return Excel::download(new ReportsExport($result['headers'], $result['reports']), 'Report-' . $request->query('methodName') . '-' . Carbon::now() . '.xlsx');
    }

    /**
     *  generate Excel Report.
     *
     * @param Request $request
     * @return Redirector|BinaryFileResponse
     */
    public function exportExcel(Request $request)
    {
//        return Excel::download(new ProductsExport, 'Product Report' . Carbon::now() . '.xlsx');
        $instance = new ProductsExport();
        return (new ProductsExport)->download('Product Report' . Carbon::now() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    private function getExportData(Request $request): ?array
    {
        $methodName = $request->query('methodName');

        switch ($methodName) {

            case 'salesDetails' :
                $headers = [
                    'Order Time',
                    'Order Id',
                    'Customer',
                    'Product Id',
                    'Product',
                    'Vendor',
                    'Category',
                    'SubCategory',
                    'Price',
                    'QTY',
                ];
                $reports = $this->reportRepository->getSalesDetails($request)->get();
                $data = [];
                foreach ($reports as $row) {
                    $data[] = (object)[
                        date('Y.m.d H:i:s', strtotime($row->created_at)),
                        $row->cart->order->orderDetail->code ?? 'deleted',
                        $row->cart->order->client->name ?? 'deleted',
                        $row->product->id ?? 'deleted',
                        $row->product->name ?? 'deleted',
                        $row->vendor->name ?? 'deleted',
                        $row->product->category->category->name ?? 'deleted',
                        $row->product->category->name ?? 'deleted',
                        round($row->price, 2),
                        $row->qty,
                    ];
                }
                $reports = collect($data);
                break;

            case 'salesPerVendorLL' :
                $headers = [
                    'Name',
                    'Phone Number',
                    'Email',
                    'total sales',

                ];
                $reports = $this->reportRepository->getSalesPerVendorLL($request)->get();
                $data = [];
                foreach ($reports as $row) {
                    $data[] = (object)[
                        $row->name ?? 'deleted',
                        $row->phone_number ?? 'deleted',
                        $row->email ?? 'deleted',
                        $row->cartItems->sum('price_ll') ?? 'deleted',

                    ];
                }
                $reports = collect($data);
                break;

            case 'salesPerVendorUSD' :
                $headers = [
                    'Name',
                    'Phone Number',
                    'Email',
                    'total sales',

                ];
                $reports = $this->reportRepository->getSalesPerVendorUSD($request)->get();
                $data = [];
                foreach ($reports as $row) {
                    $data[] = (object)[
                        $row->name ?? 'deleted',
                        $row->phone_number ?? 'deleted',
                        $row->email ?? 'deleted',
                        $row->cartItems->sum('price_usd') ?? 'deleted',

                    ];
                }
                $reports = collect($data);
                break;

            case 'salesPerCategoryUSD' :
                $headers = [
                    'Name',
                    'total sales',

                ];
                $reports = $this->reportRepository->getSalesPerCategoryUSD($request)->get();
                $data = [];
                foreach ($reports as $row) {
                    $data[] = (object)[
                        $row->name ?? 'deleted',
                        $row->cartItems->sum('price_usd') ?? 'deleted',

                    ];
                }
                $reports = collect($data);
                break;

            case 'salesPerMonthLL' :
                $headers = [
                    'Name',
                    'total sales',

                ];
                $reports = $this->reportRepository->getSalesPerMonthLL($request)->get();
                $data = [];
                foreach ($reports as $row) {
                    $data[] = (object)[
                        $row->months ?? 'deleted',
                        $row->sums ?? 'deleted',

                    ];
                }
                $reports = collect($data);
                break;

            case 'salesPerMonthUSD' :
                $headers = [
                    'Date',
                    'total sales',

                ];
                $reports = $this->reportRepository->getSalesPerMonthUSD($request)->get();
                $data = [];
                foreach ($reports as $row) {
                    $data[] = (object)[
                        $row->months ?? 'deleted',
                        $row->sums ?? 'deleted',

                    ];
                }
                $reports = collect($data);
                break;

            case 'salesPerCategoryLL' :
                $headers = [
                    'Name',
                    'total sales',

                ];
                $reports = $this->reportRepository->getSalesPerCategoryLL($request)->get();
                $data = [];
                foreach ($reports as $row) {
                    $data[] = (object)[
                        $row->name ?? 'deleted',
                        $row->cartItems->sum('price_ll') ?? 'deleted',

                    ];
                }
                $reports = collect($data);
                break;

            case 'salesPerProduct' :
                $headers = [
                    'Name',
                    'Total sales',
                    'currencyType',
                    'quantity',
                    'subCategory',
                    'category'

                ];
                $reports = $this->reportRepository->getSalesPerProduct($request)->get();
                $data = [];
                foreach ($reports as $row) {
                    $data[] = (object)[
                        $row->name ?? 'deleted',
                        $row->currency_type == \App\Models\Product::CURRENCY_TYPE_USD ? $row->cartItems->sum('price_usd') : $row->cartItems->sum('price_ll'),
                        $row->currency_type ?? 'deleted',
                        $row->cartItems->sum('qty'),
                        $row->category->name,
                        $row->category->category->name

                    ];
                }
                $reports = collect($data);
                break;


            default:
                return null;
        }
        return compact('headers', 'reports');
    }
}

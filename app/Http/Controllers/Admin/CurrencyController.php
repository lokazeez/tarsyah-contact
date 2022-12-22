<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyRequest;
use App\Models\Currency;
use App\Repositories\CurrencyRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CurrencyController extends Controller
{
    private $currencyRepository;
    public $resource = 'currency';

    public function __construct(CurrencyRepository $currencyRepository)
    {
        appendGeneralPermissions($this);
        $this->currencyRepository = $currencyRepository;
        view()->share('item', $this->resource);
        view()->share('class', Currency::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $currencies = $this->currencyRepository->getCurrencies($request, true);
        if ($request->has('request_rates'))
            $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_updated_successfully'));

        unset($request['request_rates']);

        return view('admin.crud.index', compact('currencies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.crud.edit-new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CurrencyRequest $request
     * @return RedirectResponse
     */
    public function store(CurrencyRequest $request): RedirectResponse
    {
        $this->currencyRepository->add($request);

        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_created_successfully'));

        if ($request->has('add-new'))
            return redirect()->route('admin.currencies.create');

        return redirect()->route('admin.currencies.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Currency $currency
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Currency $currency): \Illuminate\Contracts\View\View
    {
        return view('admin.crud.show', compact('currency'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Currency $currency
     * @return Application|Factory|View
     */
    public function edit(Currency $currency)
    {
        return view('admin.crud.edit-new', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CurrencyRequest $request
     * @param Currency $currency
     * @return RedirectResponse
     */
    public function update(CurrencyRequest $request, Currency $currency): RedirectResponse
    {
        $this->currencyRepository->update($request, $currency);

        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_updated_successfully'));

        if ($request->has('add-new'))
            return redirect()->back();

        return redirect()->route('admin.currencies.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Currency $currency
     * @return RedirectResponse
     */
    public function destroy(Request $request, Currency $currency): RedirectResponse
    {
        $this->currencyRepository->delete($currency);
        $request->session()->flash('success', __($this->resource.'.'.$this->resource.'_deleted_successfully'));
        return redirect()->route('admin.currencies.index');
    }
}

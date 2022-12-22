<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use App\Repositories\SettingRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    private $settingRepository;
    public $resource = 'setting';
    public function __construct(SettingRepository $settingRepository)
    {
        appendGeneralPermissions($this);
        $this->settingRepository = $settingRepository;
        view()->share('item', $this->resource);
        view()->share('class', Setting::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $settings = $this->settingRepository->getSettings();
        return view('admin.crud.index', compact('settings'));
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
     * @param SettingRequest $request
     * @return RedirectResponse
     */
    public function store(SettingRequest $request): RedirectResponse
    {

        $this->settingRepository->add($request);

        $request->session()->flash('success', 'setting created successfully');

        if ($request->has('site-settings'))
            return back();

        if ($request->has('add-new'))
            return redirect()->route('admin.settings.create');

        return redirect()->route('admin.settings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Setting $setting
     * @return Setting
     */
    public function show(Setting $setting): Setting
    {
        return $setting;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Setting $setting
     * @return Application|Factory|View
     */
    public function edit(Setting $setting)
    {
        return view('admin.crud.edit-new', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SettingRequest $request
     * @param Setting $setting
     * @return RedirectResponse
     */
    public function update(SettingRequest $request, Setting $setting): RedirectResponse
    {
        $this->settingRepository->update($request, $setting);

        $request->session()->flash('success', 'setting updated successfully');

        if ($request->has('site-settings'))
            return back();

        if ($request->has('add-new'))
            return redirect()->back();

        return redirect()->route('admin.settings.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Setting $setting
     * @return RedirectResponse
     */
    public function destroy(Request $request, Setting $setting): RedirectResponse
    {
        $this->settingRepository->delete($setting);
        $request->session()->flash('success', 'setting deleted successfully');
        return redirect()->route('admin.settings.index');
    }
}

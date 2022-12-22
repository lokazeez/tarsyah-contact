<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Repositories\RoleRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    private $roleRepository;
    public $resource = 'role';

    public function __construct(RoleRepository $roleRepository)
    {
        appendGeneralPermissions($this);
        $this->roleRepository = $roleRepository;
        view()->share('item', $this->resource);
        view()->share('class', Role::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $roles = $this->roleRepository->getRoles();
        return view('admin.crud.index', compact('roles'));
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
     * @param RoleRequest $request
     * @return RedirectResponse
     */
    public function store(RoleRequest $request): RedirectResponse
    {
        $this->roleRepository->add($request);

        $request->session()->flash('success', 'role created successfully');

        if ($request->has('add-new'))
            return redirect()->route('admin.roles.create');

        return redirect()->route('admin.roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return Role
     */
    public function show(Role $role): Role
    {
        return $role;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return Application|Factory|View
     */
    public function edit(Role $role)
    {
        return view('admin.crud.edit-new', compact('role',));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function update(RoleRequest $request, Role $role): RedirectResponse
    {
        $this->roleRepository->update($request, $role);

        $request->session()->flash('success', 'role updated successfully');

        if ($request->has('add-new'))
            return redirect()->back();

        return redirect()->route('admin.roles.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function destroy(Request $request, Role $role): RedirectResponse
    {
        $this->roleRepository->delete($role);
        $request->session()->flash('success', 'role deleted successfully');
        return redirect()->route('admin.roles.index');
    }
}

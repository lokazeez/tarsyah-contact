<?php

namespace App\Repositories;

use App\Http\Traits\ShiftTrait;
use App\Models\Admin;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminRepository {

    public function add(Request $request)
    {
        $admin = new Admin($request->all());

        if ($request->has('password'))
            $admin->password = bcrypt($request->get('password'));

        if ($request->hasFile('avatar'))
            $admin->avatar = Storage::disk('public')->put('admins', $request->file('avatar'));

        if ($request->hasFile('cover_image'))
            $admin->cover_image = Storage::disk('public')->put('admins', $request->file('cover_image'));

        $admin->syncRoles($request->get('role'));

        $admin->save();

    }

    public function update(Request $request, Admin $admin)
    {
        if ($request->has('password'))
            $admin->password = bcrypt($request->get('password'));

        foreach ($admin->roles()->get() as $role)
            $admin->removeRole($role);

        $admin->syncRoles($request->get('role'));

        $admin->update($request->except(['password']));

        if ($request->hasFile('avatar')){
            // if there is an old avatar delete it
            if ($admin->avatar != null){
                $admin->avatar = Storage::disk('public')->delete($admin->avatar);
            }

            // store the new image
            $admin->avatar = Storage::disk('public')->put('admins', $request->file('avatar'));
        }

        if ($request->hasFile('cover_image')){
            // if there is an old cover_image delete it
            if ($admin->cover_image != null){
                $admin->cover_image = Storage::disk('public')->delete($admin->cover_image);
            }

            // store the new image
            $admin->cover_image = Storage::disk('public')->put('admins', $request->file('cover_image'));
        }


        $admin->save();


    }

    public function delete(Admin $admin)
    {
        if ($admin->image != null)
            $admin->image = Storage::disk('public')->delete($admin->image);

        $admin->delete();
    }

    public function getAdmins(Request $request, $withProducts = false): Builder
    {
        if($withProducts)
            $admins = Admin::query()->with('products');
        else
            $admins = Admin::query();

        if ($role = $request->get('role'))
            $admins = $admins->role($role);

        if ($status = $request->get('status'))
            $admins = $admins->where('status', $status);

        if ($search = $request->get('search')){
            $tokens = convertToSeparatedTokens($search);
            $admins->whereRaw("MATCH(name, email, username) AGAINST(? IN BOOLEAN MODE)", $tokens);
        }

        return $admins->orderBy('created_at');
    }

    public function getAdminsDataTable(Request $request): LengthAwarePaginator
    {

        $admins = Admin::query();

        if ($request->has('query')){
            if (isset($request->get('query')['status']) != null)
                $admins->where('status' , $request->get('query')['status']);

            if (isset($request->get('query')['role']) != null){
                $admins = $admins->role($request->get('query')['role']);
            }

            if (isset($request->get('query')['from_date']) != null)
                $admins->where('created_at' ,'>=', $request->get('query')['from_date']);

            if (isset($request->get('query')['to_date']) != null)
                $admins->where('created_at' ,'<=', Carbon::parse($request->get('query')['to_date'])->endOfDay());


            if (isset($request->get('query')['search']) != null){
                $tokens = convertToSeparatedTokens($request->get('query')['search']);
                $admins->whereRaw("MATCH(name, email, username) AGAINST(? IN BOOLEAN MODE)", $tokens);
            }
        }
            
        if ($request->has('sort')) {
            $field = $request->get('sort')['field'];
            if (!in_array($field, app(Admin::class)->getFillable())) $field = 'id';
            $admins = $admins->orderBy($field, $request->get('sort')['sort'] ?? 'asc')
                ->paginate($request->get('pagination')['perpage'], ['*'], 'page', $request->get('pagination')['page']);
        } else
            $admins = $admins->orderBy('id', 'desc')
                ->paginate($request->get('pagination')['perpage'],['*'], 'page',$request->get('pagination')['page']);

        return $admins;
    }

    public function getVendors(Request $request): Builder
    {

        $admins = Admin::query();
        if ($search = $request->get('search')){
            $tokens = convertToSeparatedTokens($search);
            $admins->whereRaw("MATCH(name, email, username) AGAINST(? IN BOOLEAN MODE)", $tokens);
        }
        if ($role = $request->get('role')){
            $admins = $admins->role($role);
        }
        return $admins->orderByDesc('created_at');
    }

    function getVendorCategory($user)
    {
        $categories = Category::query()->whereNotNull('parent_category');
        return $categories;
    }

}

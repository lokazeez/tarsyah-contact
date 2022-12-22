<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Repositories\AdminRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminExtraController extends Controller
{
    public $resource = 'admin';

    public function __construct()
    {
    }

    public function VendorsAutoComplete(Request $request): JsonResponse
    {

        $vendors = Admin::role(['vendor', 'Admin']);

        if ($request->has('search')){
            $search = $request->get('search');
            $tokens = convertToSeparatedTokens($search);
            $vendors->whereRaw("MATCH(name, email, username) AGAINST(? IN BOOLEAN MODE)", $tokens);
        }

        $models =  $vendors
            ->take(5)
            ->get()->map(function ($result){
                return array(
                    'id' => $result->id,
                    'text' => $result->name ,
                );
            });

        return response()->json([
            'results' => $models
        ]);
    }


}

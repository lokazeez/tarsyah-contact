<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{


    public function changeLanguage($local): RedirectResponse
    {
        if (array_key_exists($local, Config::get('languages'))) {
            App::setLocale($local);
            Config::set('translatable.locale', $local);
            Session::put('lang', $local);
            app()->setLocale($local);
        }
        return redirect()->back();
    }


    function dashboard()
    {
        $data =(Object) [
            'totalContacts' => Contact::query()->count(),

        ];
        return view('admin.dashboard', compact('data'));
    }



}

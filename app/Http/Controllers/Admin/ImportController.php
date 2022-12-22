<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\NinaProductsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function importNinaProducts()
    {
        Excel::import(new NinaProductsImport(), storage_path('NinaProducts.xlsx'));
        return 'Success, All Good!';
    }
}

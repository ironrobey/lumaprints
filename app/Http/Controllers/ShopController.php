<?php

namespace App\Http\Controllers;

use App\Exports\ShopsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ShopController extends Controller
{
    public function export()
    {
        return Excel::download(new ShopsExport, 'shops.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}

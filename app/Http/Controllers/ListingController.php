<?php

namespace App\Http\Controllers;

use App\Exports\ListingsExport;
use App\Listings;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ListingController extends Controller
{

    public function export()
    {
        return Excel::download(new ListingsExport, 'listings.csv', \Maatwebsite\Excel\Excel::CSV);
    }

}

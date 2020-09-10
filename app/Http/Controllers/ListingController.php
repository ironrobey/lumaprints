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
        return Excel::download(new ListingsExport, 'listings.xlsx');
    }

    public function show(Listings $listing){
        dd($listing->shop);
    }

}

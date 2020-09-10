<?php

namespace App\Exports;

use App\Listings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ListingsExport implements FromQuery, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Listings::query();
    }

    public function map($listing): array
    {
        return [
            $listing->name,
            $listing->shop->name,
            $listing->currency,
            $listing->price,
            $listing->rating,
            $listing->reviews
        ];
    }

    public function headings(): array
    {
        return [
            'Title',
            'Shop Name',
            'Currency',
            'Price',
            'Ratings',
            'Number of Reviews'
        ];
    }
}

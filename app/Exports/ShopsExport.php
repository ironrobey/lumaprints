<?php

namespace App\Exports;

use App\Shops;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ShopsExport implements FromQuery, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Shops::query();
    }

    public function map($shop): array
    {
        return [
            $shop->name,
            $shop->owner_name,
            $shop->description,
            $shop->location,
            $shop->joined_date,
            $shop->sale
        ];
    }

    public function headings(): array
    {
        return [
            'Shop Name',
            'Owner Name',
            'Shop Description',
            'Location',
            'Etsy Member Since',
            'Sales'
        ];
    }
}

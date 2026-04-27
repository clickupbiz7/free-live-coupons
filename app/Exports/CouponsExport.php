<?php

namespace App\Exports;

use App\Models\Coupon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CouponsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Coupon::with('store','category')->get()->map(function ($row) {
            return [
                'id'            => $row->id,
                'title'         => $row->title,
                'code'          => $row->code,
                'discount'      => $row->discount,
                'type'          => $row->type,
                'store'         => $row->store->name ?? '',
                'category'      => $row->category->name ?? '',
                'expiry_date'   => $row->expiry_date,
                'description'   => $row->description,
                'status'        => $row->status,
                'featured'      => $row->featured ?? 0,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'id',
            'title',
            'code',
            'discount',
            'type',
            'store',
            'category',
            'expiry_date',
            'description',
            'status',
            'featured'
        ];
    }
}
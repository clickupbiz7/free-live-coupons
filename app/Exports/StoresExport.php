<?php

namespace App\Exports;

use App\Models\Store;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StoresExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Store::get()->map(function ($row) {
            return [
                'id' => $row->id,
                'name' => $row->name,
                'slug' => $row->slug,
                'description' => $row->description,
                'status' => $row->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'slug',
            'description',
            'status'
        ];
    }
}
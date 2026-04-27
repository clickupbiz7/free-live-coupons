<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CategoriesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Category::get()->map(function ($row) {
            return [
                'id'     => $row->id,
                'name'   => $row->name,
                'slug'   => $row->slug,
                'icon'   => $row->icon,
                'image'  => $row->image,
                'status' => $row->status ?? 1,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'slug',
            'icon',
            'image',
            'status'
        ];
    }
}
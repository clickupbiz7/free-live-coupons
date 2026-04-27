<?php

namespace App\Exports;

use App\Models\Blog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BlogsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Blog::with('category')->get()->map(function ($row) {
            return [
                'id'         => $row->id,
                'title'      => $row->title,
                'slug'       => $row->slug,
                'category'   => $row->category_name ?? '',
                'content'    => strip_tags($row->content),
                'image'      => $row->image,
                'status'     => $row->status,
                'created_at' => $row->created_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'id',
            'title',
            'slug',
            'category',
            'content',
            'image',
            'status',
            'created_at'
        ];
    }
}
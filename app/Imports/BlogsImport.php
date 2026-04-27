<?php

namespace App\Imports;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class BlogsImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $header = $rows->first()->map(fn($v) => strtolower(trim($v)))->toArray();

        unset($rows[0]);

        foreach ($rows as $row) {

            $data = [];

            foreach ($header as $index => $column) {
                $data[$column] = $row[$index] ?? null;
            }

            if(empty($data['title'])) {
                continue;
            }

            $catId = null;

            if(!empty($data['category'])) {

                $cat = DB::table('blog_categories')
                    ->where('name', $data['category'])
                    ->first();

                if(!$cat) {

                    $id = DB::table('blog_categories')
                        ->insertGetId([
                            'name' => $data['category'],
                            'slug' => Str::slug($data['category']),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                    $catId = $id;

                } else {
                    $catId = $cat->id;
                }
            }

            Blog::create([
                'title'       => $data['title'],
                'slug'        => !empty($data['slug'])
                                ? $data['slug']
                                : Str::slug($data['title']).'-'.time().rand(1,999),
                'content'     => $data['content'] ?? '',
                'image'       => $data['image'] ?? null,
                'status'      => $data['status'] ?? 1,
                'category_id' => $catId,
            ]);
        }
    }
}
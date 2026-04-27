<?php

namespace App\Imports;

use App\Models\Coupon;
use App\Models\Store;
use App\Models\Category;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class CouponsImport implements ToCollection
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

            $store = Store::firstOrCreate(
                ['name' => trim($data['store'] ?? 'General Store')],
                ['slug' => Str::slug($data['store'] ?? 'general-store')]
            );

            $category = Category::firstOrCreate(
                ['name' => trim($data['category'] ?? 'General')],
                ['slug' => Str::slug($data['category'] ?? 'general')]
            );

            Coupon::create([
                'title'       => $data['title'],
                'slug'        => Str::slug($data['title']).'-'.time().rand(1,999),
                'code'        => $data['code'] ?? null,
                'discount'    => $data['discount'] ?? null,
                'type'        => strtolower($data['type'] ?? 'coupon') == 'deal' ? 'deal' : 'coupon',
                'store_id'    => $store->id,
                'category_id' => $category->id,
                'expiry_date' => $data['expiry_date'] ?? null,
                'description' => $data['description'] ?? null,
                'status'      => $data['status'] ?? 1,
                'featured'    => $data['featured'] ?? 0,
            ]);
        }
    }
}
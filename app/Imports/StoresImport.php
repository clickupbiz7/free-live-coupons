<?php

namespace App\Imports;

use App\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class StoresImport implements ToCollection
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

            if(empty($data['name'])) {
                continue;
            }

            Store::create([
                'name'        => $data['name'],
                'slug'        => !empty($data['slug'])
                                ? $data['slug']
                                : Str::slug($data['name']).'-'.time().rand(1,999),
                'description' => $data['description'] ?? null,
                'status'      => $data['status'] ?? 1,
            ]);
        }
    }
}
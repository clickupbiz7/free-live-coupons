<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
['email' => 'clickup.biz.7@gmail.com'],
[
'name' => 'Admin',
'password' => bcrypt('12345678'),
]
);
    }
}
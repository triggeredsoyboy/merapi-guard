<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Berita',
                'slug' => 'berita',
                'description' => '',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mitigasi',
                'slug' => 'mitigasi',
                'description' => '',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kemanusiaan',
                'slug' => 'kemanusiaan',
                'description' => '',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

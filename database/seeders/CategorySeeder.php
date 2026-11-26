<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (['T-Shirt', 'Hoodie & Jacket', 'Polo & Shirt', 'Jersey', 'Uniform'] as $name) {
            Category::updateOrCreate(['slug' => Str::slug($name)], [
                'name' => $name,
                'description' => 'Pilihan produksi custom '.$name.' untuk kebutuhan komunitas dan organisasi.',
                'image' => 'images/categories/'.Str::slug($name).'.svg',
            ]);
        }
    }
}

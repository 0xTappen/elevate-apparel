<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['Oversized Premium Tee', 'T-Shirt', 85000, 12, 'Cotton combed 24s', 'Potongan oversized yang modern dengan kain lembut untuk koleksi komunitas.', true],
            ['Cotton Combed 24s Tee', 'T-Shirt', 65000, 24, 'Cotton combed 24s', 'Kaos harian yang nyaman untuk acara, merchandise, dan identitas tim.', false],
            ['Heavyweight Boxy Tee', 'T-Shirt', 95000, 12, 'Heavyweight cotton', 'Siluet boxy dengan karakter kain lebih tebal dan rapi.', true],
            ['Essential Pullover Hoodie', 'Hoodie & Jacket', 185000, 12, 'Fleece cotton', 'Hoodie pullover hangat untuk identitas kolektif Anda.', true],
            ['Custom Varsity Jacket', 'Hoodie & Jacket', 250000, 12, 'American drill dan fleece', 'Jaket varsity dengan kombinasi warna dan emblem sesuai desain.', false],
            ['Premium Polo Shirt', 'Polo & Shirt', 110000, 12, 'Lacoste cotton', 'Polo berkerah untuk tampilan tim yang profesional.', false],
            ['Custom Work Shirt', 'Polo & Shirt', 145000, 12, 'American drill', 'Kemeja kerja custom dengan detail identitas organisasi.', false],
            ['Performance Sport Jersey', 'Jersey', 125000, 12, 'Dry-fit polyester', 'Jersey olahraga ringan untuk bergerak bersama tim.', true],
            ['Full Print Esports Jersey', 'Jersey', 150000, 12, 'Dry-fit polyester', 'Jersey full print dengan visual kuat untuk tim esports.', false],
            ['Corporate Uniform', 'Uniform', 165000, 12, 'Tropical drill', 'Seragam perusahaan yang rapi dan dapat disesuaikan identitas brand.', false],
        ];

        foreach ($items as [$name, $category, $price, $minOrder, $material, $description, $featured]) {
            Product::updateOrCreate(['slug' => Str::slug($name)], [
                'category_id' => Category::where('name', $category)->firstOrFail()->id,
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'material' => $material,
                'min_order' => $minOrder,
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL'],
                'production_days' => 14,
                'image' => 'images/products/'.Str::slug($name).'.svg',
                'is_featured' => $featured,
                'is_active' => true,
            ]);
        }
    }
}

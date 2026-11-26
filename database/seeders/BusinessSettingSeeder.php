<?php

namespace Database\Seeders;

use App\Models\BusinessSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusinessSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BusinessSetting::firstOrCreate(['id' => 1], [
            'company_name' => 'PT Elevate Apparel Karya Mandiri',
            'brand_name' => 'ELEVATE APPAREL',
            'description' => 'Mitra produksi pakaian custom berkualitas untuk komunitas, organisasi, dan perusahaan.',
        ]);
    }
}

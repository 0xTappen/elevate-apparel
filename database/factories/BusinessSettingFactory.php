<?php

namespace Database\Factories;

use App\Models\BusinessSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BusinessSetting>
 */
class BusinessSettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_name' => 'PT Elevate Apparel Karya Mandiri',
            'brand_name' => 'ELEVATE APPAREL',
            'description' => 'Produksi pakaian custom.',
        ];
    }
}

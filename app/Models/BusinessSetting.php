<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessSetting extends Model
{
    /** @use HasFactory<\Database\Factories\BusinessSettingFactory> */
    use HasFactory;

    protected $fillable = ['company_name', 'brand_name', 'description', 'email', 'phone', 'whatsapp', 'address', 'instagram_url'];
}

<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'image'];

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn (): string => $this->image
            ? (str_starts_with($this->image, 'images/') ? asset($this->image) : Storage::disk('public')->url($this->image))
            : asset('images/products/oversized-premium-tee.svg'));
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}

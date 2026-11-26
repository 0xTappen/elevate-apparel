<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'string', 'max:255'],
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'min:0'],
            'sort' => ['nullable', 'in:newest,price_asc,price_desc'],
        ]);

        $products = Product::active()->with('category')
            ->when($filters['search'] ?? null, fn ($query, $search) => $query->where(fn ($q) => $q->where('name', 'like', '%'.$search.'%')->orWhere('description', 'like', '%'.$search.'%')))
            ->when($filters['category'] ?? null, fn ($query, $slug) => $query->whereHas('category', fn ($q) => $q->where('slug', $slug)))
            ->when(isset($filters['min_price']), fn ($query) => $query->where('price', '>=', $filters['min_price']))
            ->when(isset($filters['max_price']), fn ($query) => $query->where('price', '<=', $filters['max_price']));

        match ($filters['sort'] ?? 'newest') {
            'price_asc' => $products->orderBy('price'),
            'price_desc' => $products->orderByDesc('price'),
            default => $products->latest(),
        };

        $categories = Category::withCount(['products' => fn ($query) => $query->active()])->get();

        return view('products.index', [
            'products' => $products->paginate(9)->withQueryString(),
            'categoryOptions' => ['' => 'Semua kategori'] + $categories->mapWithKeys(fn (Category $category): array => [$category->slug => $category->name.' ('.$category->products_count.')'])->all(),
            'sortOptions' => ['newest' => 'Terbaru', 'price_asc' => 'Harga terendah', 'price_desc' => 'Harga tertinggi'],
            'filters' => $filters,
        ]);
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);
        $product->load('category');

        return view('products.show', [
            'product' => $product,
            'related' => Product::active()->with('category')->whereBelongsTo($product->category)->whereKeyNot($product->id)->take(3)->get(),
        ]);
    }
}

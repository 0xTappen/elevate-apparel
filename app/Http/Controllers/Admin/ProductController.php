<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate(['search' => ['nullable', 'string', 'max:100'], 'category' => ['nullable', 'integer'], 'status' => ['nullable', 'in:active,inactive'], 'sort' => ['nullable', 'in:newest,price_asc,price_desc']]);
        $query = Product::with('category')
            ->when($filters['search'] ?? null, fn ($q, $value) => $q->where('name', 'like', '%'.$value.'%'))
            ->when($filters['category'] ?? null, fn ($q, $value) => $q->where('category_id', $value))
            ->when($filters['status'] ?? null, fn ($q, $value) => $q->where('is_active', $value === 'active'));

        match ($filters['sort'] ?? 'newest') {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            default => $query->latest(),
        };

        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', [
            'products' => $query->paginate(10)->withQueryString(),
            'categoryOptions' => ['' => 'Semua kategori'] + $categories->mapWithKeys(fn (Category $category): array => [$category->id => $category->name])->all(),
            'statusOptions' => ['' => 'Semua status', 'active' => 'Aktif', 'inactive' => 'Nonaktif'],
            'sortOptions' => ['newest' => 'Terbaru', 'price_asc' => 'Harga terendah', 'price_desc' => 'Harga tertinggi'],
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('admin.products.form', ['product' => new Product, 'categories' => Category::orderBy('name')->get()]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('image');
        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['image'] = $request->file('image')->store('products', 'public');

        try {
            Product::create($data);
        } catch (Throwable $exception) {
            Storage::disk('public')->delete($data['image']);
            throw $exception;
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.form', ['product' => $product, 'categories' => Category::orderBy('name')->get()]);
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->safe()->except('image');
        $data['slug'] = $this->uniqueSlug($data['name'], $product->id);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $oldImage = $product->image;
        $newImage = $request->hasFile('image') ? $request->file('image')->store('products', 'public') : null;
        if ($newImage) {
            $data['image'] = $newImage;
        }

        try {
            $product->update($data);
        } catch (Throwable $exception) {
            if ($newImage) {
                Storage::disk('public')->delete($newImage);
            }
            throw $exception;
        }

        if ($newImage && ! str_starts_with($oldImage, 'images/')) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $image = $product->image;
        $product->delete();
        if (! str_starts_with($image, 'images/')) {
            Storage::disk('public')->delete($image);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    private function uniqueSlug(string $name, ?int $exceptId = null): string
    {
        $base = Str::slug($name) ?: 'produk';
        $slug = $base;
        $index = 2;
        while (Product::where('slug', $slug)->when($exceptId, fn ($q) => $q->whereKeyNot($exceptId))->exists()) {
            $slug = $base.'-'.$index++;
        }

        return $slug;
    }
}

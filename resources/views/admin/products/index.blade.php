@extends('layouts.admin')
@section('heading', 'Manajemen Produk')

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-4">
    <p class="text-sm font-bold">{{ $products->total() }} produk</p>
    <a class="button bg-lime" href="{{ route('admin.products.create') }}">+ Tambah Produk</a>
</div>

<form method="GET" class="mb-6 grid gap-4 border-2 border-ink bg-white p-4 sm:grid-cols-2 xl:grid-cols-5">
    <div><label class="label" for="admin-search">Cari produk</label><input class="field" id="admin-search" name="search" placeholder="Nama produk" value="{{ $filters['search'] ?? '' }}"></div>
    <x-ui.select name="category" id="admin-category-filter" label="Kategori" :options="$categoryOptions" :selected="$filters['category'] ?? ''" />
    <x-ui.select name="status" id="admin-status-filter" label="Status" :options="$statusOptions" :selected="$filters['status'] ?? ''" />
    <x-ui.select name="sort" id="admin-sort-filter" label="Urutkan" :options="$sortOptions" :selected="$filters['sort'] ?? 'newest'" />
    <div class="flex items-end"><button class="button w-full bg-lime">Filter ↗</button></div>
</form>

<div class="overflow-x-auto border-2 border-ink bg-white">
    <table class="w-full min-w-[950px] text-left text-sm">
        <thead class="bg-ink text-xs uppercase text-cream"><tr><th class="p-4">Produk</th><th class="p-4">Kategori</th><th class="p-4">Harga</th><th class="p-4">MOQ</th><th class="p-4">Status</th><th class="p-4">Dibuat</th><th class="p-4">Aksi</th></tr></thead>
        <tbody>
        @forelse ($products as $product)
            <tr class="border-t-2 border-ink">
                <td class="p-4"><div class="flex items-center gap-3"><img class="h-14 w-14 border border-ink object-cover" src="{{ $product->image_url }}" alt=""><span class="font-bold">{{ $product->name }} @if ($product->is_featured)<small class="block text-orange">FEATURED</small>@endif</span></div></td>
                <td class="p-4">{{ $product->category->name }}</td>
                <td class="p-4">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="p-4">{{ $product->min_order }}</td>
                <td class="p-4">{{ $product->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                <td class="p-4">{{ $product->created_at->format('d M Y') }}</td>
                <td class="p-4"><div class="flex items-center gap-3"><a class="font-bold underline" href="{{ route('admin.products.edit', $product) }}">Edit</a><form method="POST" action="{{ route('admin.products.destroy', $product) }}" data-confirm="Hapus produk ini? Konsultasi terkait tetap tersimpan.">@csrf @method('DELETE')<button class="font-bold text-red-700 underline">Hapus</button></form></div></td>
            </tr>
        @empty
            <tr><td colspan="7" class="p-10 text-center">Belum ada produk yang cocok.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-8">{{ $products->links() }}</div>
@endsection

@extends('layouts.public')
@section('title', 'Katalog Produk')

@section('content')
<section class="border-b-2 border-ink bg-lime py-14">
    <div class="section-wrap">
        <span class="text-xs font-black uppercase tracking-widest">OUR CATALOG / MADE TO ORDER</span>
        <h1 class="display mt-4 page-title">PICK YOUR<br>CANVAS.</h1>
        <p class="mt-5 max-w-xl text-base">Temukan bentuk yang pas untuk identitas tim Anda. Semua harga adalah contoh awal, penawaran final mengikuti spesifikasi.</p>
    </div>
</section>

<section class="section-wrap py-12">
    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div><span class="text-xs font-black uppercase tracking-widest">FILTER / EXPLORE</span><p class="mt-2 text-sm">{{ $products->total() }} produk ditemukan</p></div>
        <a class="text-xs font-black uppercase underline" href="{{ route('products.index') }}">Reset filter ↗</a>
    </div>

    <div class="mb-6 lg:hidden"><button type="button" class="button bg-white" data-toggle-target="#catalog-filters" aria-controls="catalog-filters" aria-expanded="false">Filter &amp; Urutkan ☰</button></div>
    <div class="grid gap-8 lg:grid-cols-[250px_1fr]">
        <form id="catalog-filters" method="GET" action="{{ route('products.index') }}" class="hidden h-fit border-2 border-ink bg-white p-5 shadow-[4px_4px_0_#141414] lg:block">
            <h2 class="font-display text-xl font-black">FILTER PRODUK</h2>
            <div class="mt-6"><label class="label" for="search">Cari Produk</label><input class="field" id="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Nama atau deskripsi"></div>
            <div class="mt-5"><x-ui.select name="category" id="catalog-category" label="Kategori" :options="$categoryOptions" :selected="$filters['category'] ?? ''" /></div>
            <div class="mt-5 grid grid-cols-2 gap-3">
                <div><label class="label" for="min_price">Harga min.</label><input class="field" id="min_price" name="min_price" type="number" min="0" value="{{ $filters['min_price'] ?? '' }}"></div>
                <div><label class="label" for="max_price">Harga max.</label><input class="field" id="max_price" name="max_price" type="number" min="0" value="{{ $filters['max_price'] ?? '' }}"></div>
            </div>
            <div class="mt-5"><x-ui.select name="sort" id="catalog-sort" label="Urutkan" :options="$sortOptions" :selected="$filters['sort'] ?? 'newest'" /></div>
            <button class="button mt-6 w-full bg-lime">Terapkan Filter ↗</button>
        </form>

        <div>
            @if ($products->isEmpty())
                <div class="border-2 border-ink bg-white p-12 text-center"><h2 class="display text-3xl">NO MATCH FOUND.</h2><p class="mt-4">Coba ubah kata kunci atau rentang harga.</p><a class="button mt-6 bg-lime" href="{{ route('products.index') }}">Lihat Semua Produk</a></div>
            @else
                <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">@foreach ($products as $product)<x-product-card :product="$product" />@endforeach</div>
                <div class="mt-10">{{ $products->links() }}</div>
            @endif
        </div>
    </div>
</section>
@endsection

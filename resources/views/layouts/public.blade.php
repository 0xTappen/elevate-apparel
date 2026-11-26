<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $business?->description ?? 'Produksi pakaian custom berkualitas.' }}">
    <title>@yield('title', 'Your Vision. Our Craft.') — {{ $business?->brand_name ?? 'ELEVATE APPAREL' }}</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-w-0 font-sans antialiased">
    <div class="bg-ink px-4 py-2 text-center text-[11px] font-extrabold tracking-[.2em] text-cream">CUSTOM APPAREL <span class="text-lime">✦</span> MADE TO ORDER <span class="text-lime">✦</span> BUILT FOR YOUR IDENTITY</div>
    <header class="sticky top-0 z-40 border-b-2 border-ink bg-cream/95 backdrop-blur-sm">
        <div class="section-wrap flex min-h-20 items-center justify-between gap-5">
            <a href="{{ route('home') }}" aria-label="Elevate Apparel — Beranda"><img src="{{ asset('images/branding/logo.svg') }}" alt="Elevate Apparel" class="w-40 sm:w-48"></a>
            <nav class="hidden items-center gap-7 text-xs font-extrabold uppercase tracking-wide lg:flex" aria-label="Navigasi utama">
                <a class="hover:underline" href="{{ route('home') }}">Home</a><a class="hover:underline" href="{{ route('products.index') }}">Produk</a><a class="hover:underline" href="{{ route('about') }}">Tentang Kami</a><a class="hover:underline" href="{{ route('process') }}">Proses Produksi</a><a class="hover:underline" href="{{ route('contact') }}">Kontak</a>
            </nav>
            <a href="{{ route('contact') }}" class="button hidden bg-lime text-xs lg:inline-flex">Konsultasi <span aria-hidden="true">↗</span></a>
            <details class="relative lg:hidden"><summary class="cursor-pointer list-none border-2 border-ink px-3 py-2 font-bold" aria-label="Buka menu">MENU ☰</summary><nav class="absolute right-0 top-12 grid w-60 gap-4 border-2 border-ink bg-cream p-5 text-sm font-bold shadow-[4px_4px_0_#141414]" aria-label="Navigasi mobile"><a href="{{ route('home') }}">Home</a><a href="{{ route('products.index') }}">Produk</a><a href="{{ route('about') }}">Tentang Kami</a><a href="{{ route('process') }}">Proses Produksi</a><a href="{{ route('contact') }}">Kontak / Konsultasi</a></nav></details>
        </div>
    </header>
    @if (session('success'))<div role="status" class="section-wrap mt-5 border-2 border-ink bg-lime p-4 font-bold shadow-[4px_4px_0_#141414]">{{ session('success') }}</div>@endif
    <main>@yield('content')</main>
    <footer class="border-t-2 border-ink bg-ink py-16 text-cream">
        <div class="section-wrap grid gap-12 md:grid-cols-2 lg:grid-cols-4">
            <div class="lg:col-span-2"><img src="{{ asset('images/branding/logo-white.svg') }}" alt="Elevate Apparel" class="w-56"><p class="mt-5 max-w-md text-sm leading-7 text-cream/70">{{ $business?->company_name ?? 'PT Elevate Apparel Karya Mandiri' }}. {{ $business?->description }}</p><p class="mt-8 text-xs text-cream/50">© {{ date('Y') }} Elevate Apparel. Made for your identity.</p></div>
            <div><h2 class="mb-5 text-xs font-black uppercase tracking-widest text-lime">Jelajahi</h2><div class="grid gap-3 text-sm"><a href="{{ route('products.index') }}">Semua Produk</a><a href="{{ route('about') }}">Tentang Kami</a><a href="{{ route('process') }}">Proses Produksi</a><a href="{{ route('contact') }}">Konsultasi</a></div></div>
            <div><h2 class="mb-5 text-xs font-black uppercase tracking-widest text-lime">Kategori</h2><div class="grid gap-3 text-sm">@foreach ($footerCategories as $category)<a href="{{ route('products.index', ['category' => $category->slug]) }}">{{ $category->name }}</a>@endforeach</div>@if ($business?->email)<p class="mt-6 text-sm">{{ $business->email }}</p>@endif @if ($business?->instagram_url)<a class="mt-3 block text-sm underline" href="{{ $business->instagram_url }}" rel="noopener noreferrer" target="_blank">Instagram ↗</a>@endif</div>
        </div>
    </footer>
</body>
</html>

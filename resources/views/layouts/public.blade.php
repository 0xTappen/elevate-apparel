<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $business?->description ?? 'Produksi pakaian custom berkualitas.' }}">
    <title>@yield('title', 'Your Vision. Our Craft.') — {{ $business?->brand_name ?? 'ELEVATE APPAREL' }}</title>
    <link rel="icon" href="{{ asset('images/favicon/favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('images/favicon/site.webmanifest') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-w-0 font-sans antialiased">
    <div class="bg-ink px-4 py-2 text-center text-[11px] font-extrabold tracking-[.2em] text-cream">CUSTOM APPAREL <span class="text-lime">✦</span> MADE TO ORDER <span class="text-lime">✦</span> BUILT FOR YOUR IDENTITY</div>
    <header class="sticky top-0 z-40 border-b-2 border-ink bg-cream/95 backdrop-blur-sm">
        <div class="section-wrap flex min-h-20 items-center justify-between gap-5">
            <a href="{{ route('home') }}" aria-label="Elevate Apparel — Beranda" class="flex items-center gap-2"><span class="flex h-9 w-9 shrink-0 items-center justify-center border border-ink bg-ink sm:h-10 sm:w-10"><img src="{{ asset('images/favicon/android-chrome-192x192.png') }}" alt="" class="h-8 w-8 object-contain sm:h-9 sm:w-9"></span><span class="flex flex-col leading-none"><strong class="font-display text-base font-black tracking-tight sm:text-lg">ELEVATE</strong><span class="mt-1 text-[8px] font-black tracking-[.26em] sm:text-[9px]">APPAREL</span></span></a>
            <nav class="hidden items-center gap-7 text-xs font-extrabold uppercase tracking-wide lg:flex" aria-label="Navigasi utama">
                <a class="hover:underline" href="{{ route('home') }}">Home</a><a class="hover:underline" href="{{ route('products.index') }}">Produk</a><a class="hover:underline" href="{{ route('about') }}">Tentang Kami</a><a class="hover:underline" href="{{ route('process') }}">Proses Produksi</a><a class="hover:underline" href="{{ route('contact') }}">Kontak</a>
            </nav>
            <div class="hidden lg:block"><a href="{{ route('contact') }}" class="button bg-lime text-xs">Konsultasi <span aria-hidden="true">↗</span></a></div>
            <details class="relative lg:hidden"><summary class="cursor-pointer list-none border-2 border-ink px-3 py-2 font-bold" aria-label="Buka menu">MENU ☰</summary><nav class="absolute right-0 top-12 grid w-60 gap-4 border-2 border-ink bg-cream p-5 text-sm font-bold shadow-[4px_4px_0_#141414]" aria-label="Navigasi mobile"><a href="{{ route('home') }}">Home</a><a href="{{ route('products.index') }}">Produk</a><a href="{{ route('about') }}">Tentang Kami</a><a href="{{ route('process') }}">Proses Produksi</a><a href="{{ route('contact') }}">Kontak / Konsultasi</a></nav></details>
        </div>
    </header>
    @if (session('success'))<div role="status" class="section-wrap mt-5 border-2 border-ink bg-lime p-4 font-bold shadow-[4px_4px_0_#141414]">{{ session('success') }}</div>@endif
    <main>@yield('content')</main>
    <footer class="border-t-2 border-ink bg-ink py-16 text-cream">
        <div class="section-wrap grid gap-12 md:grid-cols-2 lg:grid-cols-4">
            <div class="lg:col-span-2"><div class="flex items-center gap-3"><img src="{{ asset('images/favicon/android-chrome-192x192.png') }}" alt="" class="h-16 w-16 object-contain"><span class="font-display text-2xl font-black tracking-tight">ELEVATE<br><span class="text-lime">APPAREL</span></span></div><p class="mt-5 max-w-md text-sm leading-7 text-cream/70">{{ $business?->company_name ?? 'PT Elevate Apparel Karya Mandiri' }}. {{ $business?->description }}</p><p class="mt-8 text-xs text-cream/50">© {{ date('Y') }} Elevate Apparel. Made for your identity.</p></div>
            <div><h2 class="mb-5 text-xs font-black uppercase tracking-widest text-lime">Jelajahi</h2><div class="grid gap-3 text-sm"><a href="{{ route('products.index') }}">Semua Produk</a><a href="{{ route('about') }}">Tentang Kami</a><a href="{{ route('process') }}">Proses Produksi</a><a href="{{ route('contact') }}">Konsultasi</a></div></div>
            <div><h2 class="mb-5 text-xs font-black uppercase tracking-widest text-lime">Kategori</h2><div class="grid gap-3 text-sm">@foreach ($footerCategories as $category)<a href="{{ route('products.index', ['category' => $category->slug]) }}">{{ $category->name }}</a>@endforeach</div>@if ($business?->email)<p class="mt-6 text-sm">{{ $business->email }}</p>@endif @if ($business?->instagram_url)<a class="mt-3 block text-sm underline" href="{{ $business->instagram_url }}" rel="noopener noreferrer" target="_blank">Instagram ↗</a>@endif</div>
        </div>
    </footer>
</body>
</html>

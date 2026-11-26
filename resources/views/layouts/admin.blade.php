<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — Elevate Apparel</title>
    <link rel="icon" href="{{ asset('images/favicon/favicon.ico') }}" sizes="any">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream font-sans text-ink">
<div class="min-h-screen lg:grid lg:grid-cols-[250px_1fr]">
    <aside class="border-b-2 border-ink bg-ink p-5 text-cream lg:sticky lg:top-0 lg:h-dvh lg:self-start lg:overflow-y-auto lg:border-r-2 lg:border-b-0">
        <div class="flex items-center justify-between gap-3"><a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2"><img src="{{ asset('images/favicon/android-chrome-192x192.png') }}" alt="" class="h-9 w-9 object-contain"><span class="font-display text-base font-black leading-none">ELEVATE<br><span class="text-lime">APPAREL</span></span></a><span class="border border-lime px-2 py-1 text-[10px] font-black text-lime">ADMIN</span></div>
        <button type="button" class="mt-5 flex w-full items-center justify-between gap-3 border-2 border-lime bg-lime px-4 py-3 text-left text-sm font-black text-ink lg:hidden" data-toggle-target="#admin-menu" aria-controls="admin-menu" aria-expanded="false"><span>Menu · @yield('heading', 'Dashboard')</span><span aria-hidden="true">☰</span></button>
        <div id="admin-menu" class="hidden lg:block">
            <nav class="mt-8 grid grid-cols-1 gap-2 text-xs font-bold uppercase sm:grid-cols-2 lg:grid-cols-1" aria-label="Navigasi admin">
                @foreach ([
                    ['route' => 'admin.dashboard', 'pattern' => 'admin.dashboard', 'label' => 'Dashboard'],
                    ['route' => 'admin.products.index', 'pattern' => 'admin.products.*', 'label' => 'Produk'],
                    ['route' => 'admin.categories.index', 'pattern' => 'admin.categories.*', 'label' => 'Kategori'],
                    ['route' => 'admin.inquiries.index', 'pattern' => 'admin.inquiries.*', 'label' => 'Konsultasi'],
                    ['route' => 'admin.settings.edit', 'pattern' => 'admin.settings.*', 'label' => 'Pengaturan'],
                ] as $item)
                    @php($active = request()->routeIs($item['pattern']))
                    <a href="{{ route($item['route']) }}" @if ($active) aria-current="page" @endif class="flex min-h-11 items-center px-4 font-black transition-colors {{ $active ? 'bg-lime text-ink' : 'text-cream hover:bg-lime hover:text-ink' }}">{{ $item['label'] }}</a>
                @endforeach
                <a class="flex min-h-11 items-center px-4 text-cream hover:bg-lime hover:text-ink" href="{{ route('home') }}" target="_blank" rel="noopener noreferrer">Buka Website ↗</a>
            </nav>
            <form method="POST" action="{{ route('admin.logout') }}" class="mt-7">@csrf<button class="w-full border-2 border-lime px-4 py-3 text-left text-xs font-black uppercase text-lime">Keluar →</button></form>
        </div>
    </aside>
    <div class="min-w-0">
        <header class="flex flex-wrap items-center justify-between gap-3 border-b-2 border-ink bg-white px-5 py-5 md:px-8"><div><p class="text-[10px] font-black uppercase tracking-widest">ELEVATE / CONTROL PANEL</p><h1 class="font-display text-2xl font-black">@yield('heading', 'Dashboard')</h1></div><span class="text-xs font-bold">{{ auth()->user()->name }}</span></header>
        <main class="p-5 md:p-8">
            @if (session('success'))<div role="status" class="mb-6 border-2 border-ink bg-lime p-4 font-bold">{{ session('success') }}</div>@endif
            @if ($errors->any())<div role="alert" class="mb-6 border-2 border-red-700 bg-red-50 p-4 text-sm text-red-800"><strong>Periksa kembali formulir:</strong><ul class="mt-2 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>

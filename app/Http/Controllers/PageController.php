<?php

namespace App\Http\Controllers;

use App\Models\BusinessSetting;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about(): View
    {
        return view('pages.about');
    }

    public function process(): View
    {
        return view('pages.process');
    }

    public function contact(Request $request): View
    {
        return view('pages.contact', [
            'business' => BusinessSetting::first(),
            'products' => Product::active()->orderBy('name')->get(['id', 'name', 'min_order']),
            'selectedProduct' => Product::active()->find($request->integer('product')),
        ]);
    }
}

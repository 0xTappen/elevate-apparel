<?php

namespace App\Http\Controllers;

use App\Models\BusinessSetting;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('pages.home', [
            'categories' => Category::withCount(['products' => fn ($query) => $query->active()])->get(),
            'business' => BusinessSetting::first(),
            'featured' => Product::active()->featured()->with('category')->latest()->take(4)->get(),
        ]);
    }
}

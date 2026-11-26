<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Inquiry;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'counts' => [
                'products' => Product::count(),
                'active' => Product::active()->count(),
                'categories' => Category::count(),
                'new' => Inquiry::where('status', 'new')->count(),
                'inquiries' => Inquiry::count(),
            ],
            'categories' => Category::withCount('products')->get(),
            'products' => Product::with('category')->latest()->take(5)->get(),
            'inquiries' => Inquiry::with('product')->latest()->take(5)->get(),
        ]);
    }
}

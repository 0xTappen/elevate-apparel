<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInquiryRequest;
use App\Models\Inquiry;
use Illuminate\Http\RedirectResponse;

class InquiryController extends Controller
{
    public function store(StoreInquiryRequest $request): RedirectResponse
    {
        Inquiry::create($request->validated());

        return redirect()->route('contact')->with('success', 'Terima kasih. Konsultasi Anda sudah kami terima.');
    }
}

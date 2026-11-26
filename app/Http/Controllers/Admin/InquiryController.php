<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InquiryController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate(['search' => ['nullable', 'string', 'max:100'], 'status' => ['nullable', Rule::in(Inquiry::STATUSES)]]);
        $inquiries = Inquiry::with('product')
            ->when($filters['search'] ?? null, fn ($q, $value) => $q->where(fn ($sub) => $sub->where('name', 'like', '%'.$value.'%')->orWhere('email', 'like', '%'.$value.'%')))
            ->when($filters['status'] ?? null, fn ($q, $status) => $q->where('status', $status))
            ->latest()->paginate(10)->withQueryString();

        return view('admin.inquiries.index', compact('inquiries', 'filters'));
    }

    public function show(Inquiry $inquiry): View
    {
        return view('admin.inquiries.show', ['inquiry' => $inquiry->load('product')]);
    }

    public function update(Request $request, Inquiry $inquiry): RedirectResponse
    {
        $data = $request->validate(['status' => ['required', Rule::in(Inquiry::STATUSES)]]);
        $inquiry->update($data);

        return back()->with('success', 'Status konsultasi diperbarui.');
    }

    public function destroy(Inquiry $inquiry): RedirectResponse
    {
        $inquiry->delete();

        return redirect()->route('admin.inquiries.index')->with('success', 'Konsultasi dihapus.');
    }
}

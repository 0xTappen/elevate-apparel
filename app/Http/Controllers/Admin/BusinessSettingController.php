<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBusinessSettingRequest;
use App\Models\BusinessSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class BusinessSettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings', ['business' => BusinessSetting::firstOrFail()]);
    }

    public function update(UpdateBusinessSettingRequest $request): RedirectResponse
    {
        BusinessSetting::firstOrFail()->update($request->validated());

        return back()->with('success', 'Pengaturan bisnis diperbarui.');
    }
}

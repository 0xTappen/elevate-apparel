<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:25'],
            'organization' => ['nullable', 'string', 'max:255'],
            'product_id' => ['nullable', Rule::exists(Product::class, 'id')->where('is_active', true)],
            'quantity' => ['required', 'integer', 'min:1'],
            'message' => ['required', 'string', 'max:2000'],
        ];
    }
}

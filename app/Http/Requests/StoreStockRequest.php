<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id'   => ['required', 'integer', 'exists:products,id'],
            'warehouse_id' => ['required', 'integer', 'exists:warehouses,id'],
            'quantity'     => ['required', 'integer', 'min:0'],
            'expires_at'   => ['nullable', 'date', 'after:today'],
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.exists'   => 'The selected product does not exist.',
            'warehouse_id.exists' => 'The selected warehouse does not exist.',
            'expires_at.after'    => 'The expiry date must be in the future.',
        ];
    }
}

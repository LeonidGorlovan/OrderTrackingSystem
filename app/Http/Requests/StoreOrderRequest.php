<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_name' => ['required', 'string', 'max:255', Rule::unique('orders', 'product_name')],
            'amount' => ['required', 'numeric'],
            'status' => ['required'],
        ];
    }
}

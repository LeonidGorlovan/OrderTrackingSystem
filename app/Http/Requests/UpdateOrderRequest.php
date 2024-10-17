<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
{
    public function rules(): array
    {
        $id = $this->route('order');

        return [
            'product_name' => ['required', 'string', 'max:255', Rule::unique('orders', 'product_name')->ignore($id)],
            'amount' => ['required', 'numeric'],
            'status' => ['required'],
        ];
    }
}

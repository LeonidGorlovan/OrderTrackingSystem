<?php

namespace App\Http\Requests;

use App\Enums\OrderStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeStatusOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(OrderStatusEnum::names())],
        ];
    }
}

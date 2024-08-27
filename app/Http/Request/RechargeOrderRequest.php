<?php

namespace App\Http\Request;


use App\Enum\PaymentMethodType;
use Illuminate\Validation\Rule;

class RechargeOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'payment_method' => ['required', Rule::enum(PaymentMethodType::class)],
            'amount' => ['required', 'integer'],
            'payload' => ['required'],
        ];
    }
}

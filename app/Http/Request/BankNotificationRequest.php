<?php

namespace App\Http\Request;

class BankNotificationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'notification' => ['required', 'string'],
        ];
    }
}

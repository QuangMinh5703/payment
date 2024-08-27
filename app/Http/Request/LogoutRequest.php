<?php

namespace App\Http\Request;

use Illuminate\Support\Facades\Auth;

class LogoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::check();
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class SignUpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => 'required|alpha:ascii',
            'email' => 'required|email|unique:subscribers,email',
        ];
    }

    /**
     * Get the "after" validation callables for the request.
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                Log::info(
                    'Newsletter request',
                    [
                        'name'  => $this->name,
                        'email' => $this->email,
                        'ip'    => $this->ip(),
                    ]
                );
            }
        ];
    }
}

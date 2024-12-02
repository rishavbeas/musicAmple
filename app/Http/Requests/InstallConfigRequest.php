<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstallConfigRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'database_hostname' => ['required', 'string', 'max:50'],
            'database_port' => ['required', 'numeric'],
            'database_name' => ['required', 'string', 'max:50'],
            'database_username' => ['required', 'string', 'max:50'],
            'database_password' => ['nullable', 'string', 'max:50'],
        ];
    }
}

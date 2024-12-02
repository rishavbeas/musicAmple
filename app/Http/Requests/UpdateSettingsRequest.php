<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
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
            'title' => ['required', 'max:128'],
            'tos_url' => ['sometimes', 'nullable', 'url'],
            'privacy_url' => ['sometimes', 'nullable', 'url'],
            'cookie_url' => ['sometimes', 'nullable', 'url'],
            'twitter' => ['sometimes', 'nullable', 'url'],
            'youtube' => ['sometimes', 'nullable', 'url'],
            'facebook' => ['sometimes', 'nullable', 'url'],
            'instagram' => ['sometimes', 'nullable', 'url'],
            'telegram' => ['sometimes', 'nullable', 'url'],
            'ps_url' => ['sometimes', 'nullable', 'url'],
            'as_url' => ['sometimes', 'nullable', 'url'],
            'android_interstitial_status'  => ['required', 'integer', 'between:0,1'],
            'android_app_open_status'  => ['required', 'integer', 'between:0,1'],
            'ios_interstitial_status'  => ['required', 'integer', 'between:0,1'],
            'ios_app_open_status'  => ['required', 'integer', 'between:0,1'],
        ];
    }
}

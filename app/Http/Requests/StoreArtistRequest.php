<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArtistRequest extends FormRequest
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
            'name' => ['string', 'max:255'],
            'image' => ['sometimes', 'image', 'max:2000'],
            'website' => ['url','nullable'],
            'facebook' => ['url','nullable'],
            'twitter' => ['url','nullable'],
            'instagram' => ['url','nullable'],
            'telegram' => ['url','nullable'],
            'youtube' => ['url','nullable'],
        ];
    }
}

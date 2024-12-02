<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        if ($this->route('id') && $this->user()->role == 0) {
            return false;
        }

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
            'username' => ['string', 'max:255', 'unique:users,username,'.request()->id],
            'role'  => ['sometimes', 'integer', 'between:0,1'],
            'first_name' => ['nullable','sometimes', 'string', 'max:255'],
            'last_name' => ['nullable','sometimes', 'string', 'max:255'],
            'country' => ['sometimes', 'string','nullable', 'max:255'],
            'city' => ['sometimes','string','nullable', 'max:255'],
            'description' => ['sometimes','string','nullable','max:1000'],
            'private' =>  ['sometimes', 'integer'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.($this->route('id') ?? $this->user()->id)],
            'website' => ['string','nullable'],
            'facebook' => ['string','nullable'],
            'twitter' => ['string','nullable'],
            'instagram' => ['string','nullable'],
            'telegram' => ['string','nullable'],
            'youtube' => ['string','nullable'],
        ];
    }
}

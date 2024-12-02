<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrackRequest extends FormRequest
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
            'public' => ['required', 'integer', 'between:0,1'],
            'download' => ['required', 'integer', 'between:0,1'],
            'description' => 'nullable',
            'artistId' => ['required'],
            'art' => 'sometimes|file|mimes:jpeg,jpg,png,gif|max:5000',
            'lyric' => 'sometimes|file|mimes:lrc|max:1024',
            'track' =>'required|file|mimes:audio/mpeg,mpga,mp3,wav,aac',
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use URL;

class UsersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'country' => $this->country,
            'city' => $this->city,
            'image' => URL::to('/uploads/avatars/' . $this->image),
            'cover' => URL::to('/uploads/covers/' . $this->cover),
            'description' => $this->description,
            'website' => $this->website,
            'date' => Carbon::parse($this->created_at)->format('M d,Y'),
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'instagram' => $this->instagram,
            'youtube' => $this->youtube,
            'private' => (int) $this->private,
            'url' => route('profile.username',$this->username)
        ];
    }
}

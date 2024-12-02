<?php

namespace App\Http\Resources;

use App\Models\Artist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscribersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->type == 'artist') {
            $profile['artist'] = ArtistsResource::make(Artist::findOrFail($this->subscriber));
        } else {
            $profile['user'] = UsersResource::make(User::findOrFail($this->subscriber));
        }
        return $profile;
    }
}

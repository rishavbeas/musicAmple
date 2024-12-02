<?php

namespace App\Http\Resources;

use App\Models\Artist;
use App\Models\Relations;
use App\Models\Track;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class SubscriptionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->type == 'artist') {
            $profile['artist'] = ArtistsResource::make(Artist::findOrFail($this->leader));
        } else {
            $profile['user'] = UsersResource::make(User::findOrFail($this->leader));
        }
        return $profile;
    }
}

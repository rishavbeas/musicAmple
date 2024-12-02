<?php

namespace App\Http\Resources;

use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use URL;

class AlbumsResource extends JsonResource
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
            'name' => $this->name,
            'image' => URL::to('/uploads/covers/albums/' . $this->image),
            'track_total' => Track::select('id')->where('album_id',$this->id)->where('public',1)->count()
        ];
    }
}

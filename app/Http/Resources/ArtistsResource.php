<?php

namespace App\Http\Resources;

use App\Models\Album;
use App\Models\Track;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use URL;

class ArtistsResource extends JsonResource
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
            'country' => $this->country,
            'city' => $this->city,
            'image' => URL::to('/uploads/avatars/' . $this->image),
            'description' => $this->description,
            'website' => $this->website,
            'date' => $this->created_at,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'instagram' => $this->instagram,
            'youtube' => $this->youtube,
            'track_total' => Track::select('id')->whereRaw("FIND_IN_SET($this->id,artist_id)")->where('tracks.public', 1)->get()->count(),
            'album_total' => Track::select('album_id')->whereRaw("FIND_IN_SET($this->id,artist_id)")->where('tracks.public', 1)->groupBy('album_id')->get()->count(),
            'listener' => (int) Track::select(Track::raw('SUM(views) as total'))->whereRaw("FIND_IN_SET($this->id,artist_id)")->where('tracks.public', 1)->get()[0]->total,
            'subscribers' => DB::table('relations')->select('relations.id')->join('users', 'relations.subscriber', '=', 'users.id')->where('relations.leader', '=', $this->id)->where('relations.type', '=', 'artist')->get()->count()
        ];
    }
}

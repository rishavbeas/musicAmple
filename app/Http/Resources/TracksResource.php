<?php

namespace App\Http\Resources;

use App\Http\Controllers\TracksController;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Rolandstarke\Thumbnail\Facades\Thumbnail;
use URL;

class TracksResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string|null
     */
    public static $wrap = 'song_list';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'artist_id' => $this->artist_id,
            'artist' => implode(',', TracksController::getArtistDetail($this->artist_id)['name']),
            'artist_image' => URL::to('/uploads/avatars/' . TracksController::getArtistDetail($this->artist_id)['image'][0]),
            'album_id' => $this->album_id,
            'album' => $this->albums->name,
            'album_cover' => URL::to('/uploads/covers/albums/' . $this->albums->image),
            'year' => Carbon::parse($this->created_at)->format('Y'),
            'views' => $this->views,
            'download' => $this->download ? true : false,
            'genre' => config('app.name'),
            'lyrics' => ($this->lyric ? URL::to('/uploads/tracks/' . $this->lyric) : null),
            'image' => trackCover($this->art, $this->albums->image, TracksController::getArtistDetail($this->artist_id)['image'][0]),
            'link' => route('tracks.detail', $this->id),
            'url' => URL::to('/uploads/tracks/' . $this->name),
        ];
    }
    public function with($request)
    {
        return [
            'status' => 200
        ];
    }
}

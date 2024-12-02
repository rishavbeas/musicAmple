<?php

namespace App\Http\Resources;

use App\Http\Controllers\API\PlaylistsController;
use App\Models\Track;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use URL;

class PlaylistsResource extends JsonResource
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
            'ownerId' => $this->by,
            'ownerName' => realName($this->users->username ?? '', $this->users->first_name ?? '', $this->users->last_name ?? ''),
            'description' => $this->description,
            'time' => $this->time,
            'public' => $this->public,
            'active' => auth()->check() && request()->id ? $this->checkActive(request()->id, $this->id) : false,
            'url' => route('playlists.show',$this->id),
            'track_total' => DB::table('playlistentries')->select('id')->leftjoin('tracks','playlistentries.track','tracks.id')->where('tracks.public',1)->where('playlistentries.playlist',$this->id)->count(),
            'image' => $this->image ? URL::to('/uploads/playlists/'.$this->image) : playlistCover(Track::whereIn('id',DB::table('playlistentries')->where('playlist',$this->id)->pluck('track'))->where('public',1)->orderBy('id','desc')->pluck('art')->toArray())
        ];
    }

    //Return whether the track exists in playlist or not
    public function checkActive($trackId,$playlistId){
        $active = DB::table('playlistentries')
        ->select('playlistentries.id')
        ->leftjoin('playlists','playlistentries.playlist','playlists.id')
        ->where('playlistentries.playlist',$playlistId)
        ->where('playlistentries.track',$trackId)
        ->where('playlists.by',auth()->user()->id)
        ->where('playlists.id',$playlistId)->count();
        return $active ? true : false;
    }
}

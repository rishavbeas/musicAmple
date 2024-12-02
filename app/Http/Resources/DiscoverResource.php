<?php

namespace App\Http\Resources;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Playlist;
use App\Models\Production;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class DiscoverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $widget['id'] = $this->id;
        $widget['title'] = $this->title;
        $widget['type'] = $this->value ? 'custom' : 'all';
        if($this->type == 'slider'){
            $lastestTracks = Track::with('albums')->orderBy('tracks.id','desc')->limit(config('settings.e_per_page'))->get();
            $widget['track_list'] = TracksResource::collection($lastestTracks);
        }elseif($this->type == 'artists'){
            if($this->value){
                $artistList = explode(",", $this->value);
                $ids_ordered = implode(',', $artistList);
                $artists = Artist::whereIn('id',$artistList)->where('public',1)->orderByRaw("FIELD(id, $ids_ordered)")->limit(10)->get();
                $widget['artists'] = ArtistsResource::collection($artists);
            }else{
                $widget['artists'] = ArtistsResource::collection(Artist::where('public',1)->limit(10)->get());
            }
        }elseif($this->type == 'playlists'){
            if($this->value){
                $playlistList = explode(",", $this->value);
                $ids_ordered = implode(',', $playlistList);
                $playlists = Playlist::whereIn('id',$playlistList)->where('public',1)->orderByRaw("FIELD(id, $ids_ordered)")->limit(10)->get();
                $widget['playlists'] = PlaylistsResource::collection($playlists);
            }
        }elseif($this->type == 'albums'){
            if($this->value){
                $albumList = explode(",", $this->value);
                $ids_ordered = implode(',', $albumList);
                $albums = Album::whereIn('id',$albumList)->where('public',1)->orderByRaw("FIELD(id, $ids_ordered)")->limit(10)->get();
                $widget['albums'] = AlbumsResource::collection($albums);
            }else{
                $widget['albums'] = AlbumsResource::collection(Album::where('public',1)->orderBy('id','desc')->limit(10)->get());
            }
        }elseif($this->type == 'productions'){
            if($this->value){
                $productionsList = explode(",", $this->value);
                $ids_ordered = implode(',', $productionsList);
                $productions = Production::whereIn('id',$productionsList)->where('public',1)->orderByRaw("FIELD(id, $ids_ordered)")->limit(10)->get();
                $widget['productions'] = ProductionsResource::collection($productions);
            }else{
                $widget['productions'] = ProductionsResource::collection(Production::where('public',1)->orderBy('id','desc')->limit(10)->get());
            }
        }elseif($this->type == 'banner'){
            if($this->value){
            $banner = json_decode($this->value,true);
            $widget['banner'] = array(
                'image' => URL::to('/uploads/banners/' . $banner["image"]),
                'link' => $banner["link"],
            );
            }
        }elseif($this->type == 'ads'){
            if($this->value){
            $ads = json_decode($this->value,true);
            $widget['ads'] = array(
                'android' => $ads["android"],
                'ios' => $ads["ios"],
            );
            }
        }
        return $widget;
    }
}

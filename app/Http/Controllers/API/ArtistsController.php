<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AlbumsResource;
use App\Http\Resources\ArtistsResource;
use App\Http\Resources\TracksResource;
use App\Http\Resources\UsersResource;
use App\Models\Artist;
use App\Models\Relations;
use App\Models\Track;
use Illuminate\Http\Request;

class ArtistsController extends Controller
{
    public function index()
    {
        $artists = Artist::where('public', 1)->paginate(config('settings.e_per_page'));
        if ($artists) {
            return ArtistsResource::collection($artists)->resource;
        }
        return $this->notFound();
    }
    public function show($id)
    {
        $artist = Artist::where('id', $id)->firstOrFail();
        return ArtistsResource::make($artist);
    }
    public function tracks(Request $request, $id)
    {
        if ($request->type == 'all') {
            $tracks = Track::with('albums')
                ->whereRaw("FIND_IN_SET($id,tracks.artist_id)")
                ->where('tracks.public', 1)
                ->orderBy('tracks.id', 'desc')->get();
            if ($tracks) {
                return TracksResource::collection($tracks);
            }
        } else {
            $tracks = Track::with('albums')
                ->whereRaw("FIND_IN_SET($id,tracks.artist_id)")
                ->where('tracks.public', 1)
                ->orderBy('tracks.id', 'desc')->paginate(config('settings.e_per_page'));
            if ($tracks) {
                return TracksResource::collection($tracks)->resource;
            }
        }
        return $this->notFound();
    }
    public function albums($id)
    {
        $albums = Track::select('albums.id', 'albums.name', 'albums.image')
            ->leftJoin('albums', 'tracks.album_id', '=', 'albums.id')
            ->whereRaw("FIND_IN_SET($id,tracks.artist_id)")
            ->where('tracks.public', 1)
            ->where('albums.public', 1)
            ->groupBy('albums.id')
            ->orderBy('albums.id', 'desc')->paginate(config('settings.e_per_page'));
        if ($albums) {
            return AlbumsResource::collection($albums)->resource;
        }
        return $this->notFound();
    }
    public function subscribers($id)
    {
        $subscribers = Relations::join('users', 'relations.subscriber', '=', 'users.id')->where('relations.leader', '=', $id)->where('relations.type', '=', 'artist')->orderBy('relations.id', 'desc')->paginate(config('settings.e_per_page'));
        if ($subscribers) {
            return UsersResource::collection($subscribers)->resource;
        }
        return $this->notFound();
    }

    public function notFound()
    {
        return response()->json([
            'message' => __('Resource not found.'),
            'status' => 404
        ], 404);
    }
}

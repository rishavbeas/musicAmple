<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AlbumsResource;
use App\Http\Resources\ArtistsResource;
use App\Http\Resources\PlaylistsResource;
use App\Http\Resources\TracksResource;
use App\Http\Resources\UsersResource;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Playlist;
use App\Models\Track;
use App\Models\User;

class SearchController extends Controller
{
    public function tracks($name)
    {
        $tracks = Track::with('albums')->searchName($name)
            ->where('tracks.public', 1)
            ->orderBy('tracks.id', 'desc')
            ->paginate(config('settings.s_per_page'));
        if ($tracks) {
            return TracksResource::collection($tracks)->resource;
        }

        return response()->json([
            'message' => __('Resource not found.'),
            'status' => 404
        ], 404);
    }
    public function albums($name)
    {
        $albums = Album::searchName($name)
            ->where('public', 1)
            ->orderBy('id', 'desc')
            ->paginate(config('settings.s_per_page'));
        if ($albums) {
            return AlbumsResource::collection($albums)->resource;
        }

        return response()->json([
            'message' => __('Resource not found.'),
            'status' => 404
        ], 404);
    }
    public function playlists($name)
    {
        $playlists = Playlist::with('users')->searchName($name)
            ->where('public', 1)
            ->orderBy('id', 'desc')
            ->paginate(config('settings.s_per_page'));
        if ($playlists) {
            return PlaylistsResource::collection($playlists)->resource;
        }

        return response()->json([
            'message' => __('Resource not found.'),
            'status' => 404
        ], 404);
    }

    public function users($name)
    {
        $users = User::searchUserName($name)
            ->when($name, function ($query) use ($name) {
                if (auth('sanctum')->check()) {
                    return $query->where('id', '!=', auth('sanctum')->user()->id);
                }
            })
            ->where('suspended', 0)
            ->orderBy('id', 'desc')
            ->paginate(config('settings.s_per_page'));
        if ($users) {
            return UsersResource::collection($users)->resource;
        }

        return response()->json([
            'message' => __('Resource not found.'),
            'status' => 404
        ], 404);
    }
    public function artists($name)
    {
        $artists = Artist::searchName($name)
            ->where('public', 1)
            ->orderBy('id', 'desc')
            ->paginate(config('settings.s_per_page'));
        if ($artists) {
            return ArtistsResource::collection($artists)->resource;
        }

        return response()->json([
            'message' => __('Resource not found.'),
            'status' => 404
        ], 404);
    }
    public function suggestions($name)
    {
        $suggestions = Track::searchName($name)
            ->where('public', 1)
            ->orderBy('views', 'desc')
            ->limit(config('settings.s_per_page'))->pluck('title')->toArray();
        if ($suggestions) {
            return response()->json([
                'suggestions' => $suggestions
            ]);
        }

        return response()->json([
            'message' => __('Resource not found.'),
            'status' => 404
        ], 404);
    }
}

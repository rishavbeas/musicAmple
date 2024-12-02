<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlaylistsResource;
use App\Http\Resources\SubscribersResource;
use App\Http\Resources\SubscriptionsResource;
use App\Http\Resources\TracksResource;
use App\Models\Playlist;
use App\Models\Relations;
use App\Models\Track;

class ProfileController extends Controller
{
    public function playlists($id)
    {
        $playlists = Playlist::with('users')
            ->when($id, function ($query) use ($id) {
                if (auth('sanctum')->check()) {
                    if ($id != auth('sanctum')->user()->id)
                        return $query->where('public', 1);
                } else {
                    return $query->where('public', 1);
                }
            })
            ->where('by', $id)
            ->orderBy('playlists.id', 'desc')
            ->paginate(config('settings.m_per_playlist'));
        if ($playlists) {
            return PlaylistsResource::collection($playlists)->resource;
        }
    }
    public function likes($id)
    {
        $tracks = Track::select('tracks.*')->with('albums')
            ->leftJoin('likes', 'likes.track', '=', 'tracks.id')
            ->Where('tracks.public', 1)
            ->Where('likes.by', $id)
            ->paginate(config('settings.e_per_page'));
        if ($tracks) {
            return TracksResource::collection($tracks)->resource;
        }
    }
    public function subscriptions($id)
    {
        $subscriptions = Relations::orderBy('id','desc')->where('relations.subscriber', $id)->paginate(config('settings.e_per_page'));
        return SubscriptionsResource::collection($subscriptions)->resource;
    }
    public function subscribers($id)
    {
        $subscriptions = Relations::orderBy('id','desc')->where('relations.leader', $id)->where('relations.type', 'user')->paginate(config('settings.e_per_page'));
        return SubscribersResource::collection($subscriptions)->resource;
    }
}

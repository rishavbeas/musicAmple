<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TracksResource;
use App\Models\Relations;
use App\Models\Track;
use Illuminate\Http\Request;

class StreamController extends Controller
{
    public function stream(){
        $subscriptions = $this->getSubscriptionsList();
        $tracks = Track::with('albums')
            ->whereIn('tracks.artist_id', $subscriptions)
            ->where('tracks.public', 1)
            ->orderBy('tracks.id', 'desc')
            ->paginate(config('settings.m_per_page'));
        if ($tracks) {
            return TracksResource::collection($tracks)->resource;
        }

        return response()->json([
            'message' => __('Resource not found.'),
            'status' => 404
        ], 404);
    }
    public function getSubscriptionsList() {
        $leader = Relations::where('subscriber', auth()->user()->id)->get()->pluck('leader');
        return $leader;
	}
}

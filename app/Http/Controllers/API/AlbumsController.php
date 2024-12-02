<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AlbumsResource;
use App\Http\Resources\TracksResource;
use App\Models\Album;
use App\Models\Track;

class AlbumsController extends Controller
{
    public function index()
    {
        $albums = Album::where('public', 1)->orderBy('id','desc')->paginate(config('settings.e_per_page'));
        if ($albums) {
            return AlbumsResource::collection($albums)->resource;
        }
        return response()->json([
            'message' => __('Resource not found.'),
            'status' => 404
        ], 404);
    }
    public function show($id)
    {
        $tracks = Track::with('albums')->where('tracks.album_id',$id)->where('tracks.public', 1)->get();

        if ($tracks) {
            return TracksResource::collection($tracks);
        }
        return response()->json([
            'message' => __('Resource not found.'),
            'status' => 404
        ], 404);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\DiscoverResource;
use App\Http\Resources\TracksResource;
use App\Models\Track;
use App\Models\Widget;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function explorer(){
        $discover = Widget::all()->sortBy('sort_id')->where('public',1);
        return DiscoverResource::collection($discover);
    }
    public function index(Request $request)
    {
        $type = in_array($request->filter, ['latest', 'popular', 'random']);
        if ($type) {
            $filter = $request->filter;
            $tracks = Track::with('albums')->
                when($type, function ($custom) use ($filter) {
                    if ($filter == 'popular') {
                        return $custom->orderBy('views', 'desc');
                    } elseif ($filter == 'random') {
                        return $custom->inRandomOrder();
                    } else {
                        return $custom->orderBy('id', 'desc');
                    }
                })
                ->where('tracks.public', 1)
                ->paginate(config('settings.m_per_page'));
            return TracksResource::collection($tracks)->resource;
        }
        return response()->json([
            'message' => __('Resource not found.'),
            'status' => 404
        ], 404);
    }

}

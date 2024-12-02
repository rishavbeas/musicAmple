<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AlbumsResource;
use App\Http\Resources\ProductionsResource;
use App\Models\Album;
use App\Models\Production;
use Illuminate\Http\Request;

class ProductionsController extends Controller
{
    public function index()
    {
        $productions = Production::where('public', 1)->paginate(config('settings.e_per_page'));
        if ($productions) {
            return ProductionsResource::collection($productions)->resource;
        }
        return response()->json([
            'message' => __('Resource not found.'),
            'status' => 404
        ], 404);
    }
    public function show($id)
    {
        $albums = Album::where('pid',$id)->where('public', 1)->paginate(config('settings.e_per_page'));
        if ($albums) {
            return AlbumsResource::collection($albums)->resource;
        }
        return response()->json([
            'message' => __('Resource not found.'),
            'status' => 404
        ], 404);
    }
}

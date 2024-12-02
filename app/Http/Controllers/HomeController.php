<?php

namespace App\Http\Controllers;

use App\Models\Track;
use DB;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        if (!env('DB_DATABASE')) {
            return redirect()->route('install');
        }
        $latest = Track::with('albums')->where('tracks.public', 1)->orderBy('id', 'desc')->limit(56)->get();
        $popular = DB::table('views')
            ->select('views.track as id', 'tracks.title', 'tracks.art', 'tracks.artist_id', 'albums.image as album_cover', DB::raw('COUNT(`track`) as `count`'))
            ->where('time', '>=', Carbon::now()->subDays(7))
            ->where('tracks.public', 1)
            ->join('tracks', 'views.track', '=', 'tracks.id')
            ->join('albums', 'tracks.album_id', '=', 'albums.id')
            ->groupBy('views.track')
            ->orderBy('count', 'desc')
            ->limit(32)
            ->get();
        return view('home.index', compact('latest', 'popular'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Download;
use App\Models\Like;
use App\Models\Playlist;
use App\Models\Production;
use App\Models\statistics;
use App\Models\Track;
use App\Models\User;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StatisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Count Users
        $users_today = User::select('id')->whereDate('created_at', Carbon::now())->get()->count();
        $users_this_month = User::select('id')->whereMonth('created_at', Carbon::now()->month)->get()->count();
        $users_last_month = User::select('id')->whereMonth('created_at', Carbon::now()->subMonth()->month)->get()->count();
        $users_total = User::select('id')->get()->count();
        //Count Albums
        $albums_today = Album::select('id')->whereDate('created_at', Carbon::now())->get()->count();
        $albums_this_month = Album::select('id')->whereMonth('created_at', Carbon::now()->month)->get()->count();
        $albums_last_month = Album::select('id')->whereMonth('created_at', Carbon::now()->subMonth()->month)->get()->count();
        $albums_total = Album::select('id')->get()->count();
        //Count Artists
        $artists_today = Artist::select('id')->whereDate('created_at', Carbon::now())->get()->count();
        $artists_this_month = Artist::select('id')->whereMonth('created_at', Carbon::now()->month)->get()->count();
        $artists_last_month = Artist::select('id')->whereMonth('created_at', Carbon::now()->subMonth()->month)->get()->count();
        $artists_total = Artist::select('id')->get()->count();
        //Count Playlists
        $playlists_today = Playlist::select('id')->whereDate('created_at', Carbon::now())->get()->count();
        $playlists_this_month = Playlist::select('id')->whereMonth('created_at', Carbon::now()->month)->get()->count();
        $playlists_last_month = Playlist::select('id')->whereMonth('created_at', Carbon::now()->subMonth()->month)->get()->count();
        $playlists_total = Playlist::select('id')->get()->count();
        //Count Tracks
        $tracks_public = Track::select('id')->where('public', 1)->get()->count();
        $tracks_private = Track::select('id')->where('public', 2)->get()->count();
        $tracks_total = Track::select('id')->get()->count();
        //Count Productions
        $productions_public = Production::select('id')->where('public', 1)->get()->count();
        $productions_unpublic = Production::select('id')->where('public', 2)->get()->count();
        $productions_total = Production::select('id')->get()->count();
        //Count Likes
        $likes_today = Like::select('id')->whereDate('time', Carbon::now())->get()->count();
        $likes_this_month = Like::select('id')->whereMonth('time', Carbon::now()->month)->get()->count();
        $likes_last_month = Like::select('id')->whereMonth('time', Carbon::now()->subMonth()->month)->get()->count();
        $likes_total = Like::select('id')->get()->count();
        //Count Views
        $views_today = View::select('id')->whereDate('time', Carbon::now())->get()->count();
        $views_this_month = View::select('id')->whereMonth('time', Carbon::now()->month)->get()->count();
        $views_last_month = View::select('id')->whereMonth('time', Carbon::now()->subMonth()->month)->get()->count();
        $views_total = View::count();
        //Count Downloads
        $downloads_today = Download::select('id')->whereDate('time', Carbon::now())->get()->count();
        $downloads_this_month = Download::select('id')->whereMonth('time', Carbon::now()->month)->get()->count();
        $downloads_last_month = Download::select('id')->whereMonth('time', Carbon::now()->subMonth()->month)->get()->count();
        $downloads_total = Download::count();
        return view('admin.statistics.index', compact(
            'users_today',
            'users_this_month',
            'users_last_month',
            'users_total',
            'tracks_public',
            'tracks_private',
            'tracks_total',
            'playlists_today',
            'playlists_this_month',
            'playlists_last_month',
            'playlists_total',
            'artists_today',
            'artists_this_month',
            'artists_last_month',
            'artists_total',
            'albums_today',
            'albums_this_month',
            'albums_last_month',
            'albums_total',
            'productions_public',
            'productions_unpublic',
            'productions_total',
            'likes_today',
            'likes_this_month',
            'likes_last_month',
            'likes_total',
            'views_today',
            'views_this_month',
            'views_last_month',
            'views_total',
            'downloads_today',
            'downloads_this_month',
            'downloads_last_month',
            'downloads_total',
        )
        );
    }
}

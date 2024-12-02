<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Download;
use App\Models\Like;
use App\Models\Playlist;
use App\Models\Track;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(){
        //Count Users
        $users_today=User::select('id')->whereDate('created_at', Carbon::now())->get()->count();
        $users_yesterday=User::select('id')->whereDate('created_at', Carbon::yesterday())->get()->count();
        $users_two_days=User::select('id')->whereDate('created_at', Carbon::now()->subDays(2))->get()->count();
        $users_three_days=User::select('id')->whereDate('created_at', Carbon::now()->subDays(3))->get()->count();
        $users_four_days=User::select('id')->whereDate('created_at', Carbon::now()->subDays(4))->get()->count();
        $users_five_days=User::select('id')->whereDate('created_at', Carbon::now()->subDays(5))->get()->count();
        $users_six_days=User::select('id')->whereDate('created_at', Carbon::now()->subDays(6))->get()->count();
        //Count Playlists
        $playlists_today = Playlist::select('id')->whereDate('created_at', Carbon::now())->get()->count();
        $playlists_yesterday = Playlist::select('id')->whereDate('created_at', Carbon::yesterday())->get()->count();
        $playlists_two_days = Playlist::select('id')->whereDate('created_at', Carbon::now()->subDays(2))->get()->count();
        $playlists_three_days = Playlist::select('id')->whereDate('created_at', Carbon::now()->subDays(3))->get()->count();
        $playlists_four_days = Playlist::select('id')->whereDate('created_at', Carbon::now()->subDays(4))->get()->count();
        $playlists_five_days = Playlist::select('id')->whereDate('created_at', Carbon::now()->subDays(5))->get()->count();
        $playlists_six_days = Playlist::select('id')->whereDate('created_at', Carbon::now()->subDays(6))->get()->count();
        //Count Tracks
        $tracks_today = Track::select('id')->whereDate('created_at', Carbon::now())->get()->count();
        $tracks_yesterday = Track::select('id')->whereDate('created_at', Carbon::yesterday())->get()->count();
        $tracks_two_days = Track::select('id')->whereDate('created_at', Carbon::now()->subDays(2))->get()->count();
        $tracks_three_days = Track::select('id')->whereDate('created_at', Carbon::now()->subDays(3))->get()->count();
        $tracks_four_days = Track::select('id')->whereDate('created_at', Carbon::now()->subDays(4))->get()->count();
        $tracks_five_days = Track::select('id')->whereDate('created_at', Carbon::now()->subDays(5))->get()->count();
        $tracks_six_days = Track::select('id')->whereDate('created_at', Carbon::now()->subDays(6))->get()->count();
        //Count Comments
        $comments_today = Comment::select('id')->whereDate('created_at', Carbon::now())->get()->count();
        $comments_yesterday = Comment::select('id')->whereDate('created_at', Carbon::yesterday())->get()->count();
        $comments_two_days = Comment::select('id')->whereDate('created_at', Carbon::now()->subDays(2))->get()->count();
        $comments_three_days = Comment::select('id')->whereDate('created_at', Carbon::now()->subDays(3))->get()->count();
        $comments_four_days = Comment::select('id')->whereDate('created_at', Carbon::now()->subDays(4))->get()->count();
        $comments_five_days = Comment::select('id')->whereDate('created_at', Carbon::now()->subDays(5))->get()->count();
        $comments_six_days = Comment::select('id')->whereDate('created_at', Carbon::now()->subDays(6))->get()->count();
        //Count Likes
        $likes_today = Like::select('id')->whereDate('time', Carbon::now())->get()->count();
        $likes_yesterday = Like::select('id')->whereDate('time', Carbon::yesterday())->get()->count();
        $likes_two_days = Like::select('id')->whereDate('time', Carbon::now()->subDays(2))->get()->count();
        $likes_three_days = Like::select('id')->whereDate('time', Carbon::now()->subDays(3))->get()->count();
        $likes_four_days = Like::select('id')->whereDate('time', Carbon::now()->subDays(4))->get()->count();
        $likes_five_days = Like::select('id')->whereDate('time', Carbon::now()->subDays(5))->get()->count();
        $likes_six_days = Like::select('id')->whereDate('time', Carbon::now()->subDays(6))->get()->count();
        //Count Downloads
        $downloads_today = Download::select('id')->whereDate('time', Carbon::now())->get()->count();
        $downloads_yesterday = Download::select('id')->whereDate('time', Carbon::yesterday())->get()->count();
        $downloads_two_days = Download::select('id')->whereDate('time', Carbon::now()->subDays(2))->get()->count();
        $downloads_three_days = Download::select('id')->whereDate('time', Carbon::now()->subDays(3))->get()->count();
        $downloads_four_days = Download::select('id')->whereDate('time', Carbon::now()->subDays(4))->get()->count();
        $downloads_five_days = Download::select('id')->whereDate('time', Carbon::now()->subDays(5))->get()->count();
        $downloads_six_days = Download::select('id')->whereDate('time', Carbon::now()->subDays(6))->get()->count();

        return view('dashboard', compact('users_today','playlists_today','tracks_today','comments_today','likes_today','downloads_today'));
    }
}

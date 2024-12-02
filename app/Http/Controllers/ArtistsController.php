<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArtistRequest;
use App\Http\Requests\UpdateArtistProfileRequest;
use App\Models\Artist;
use App\Models\Comment;
use App\Models\Download;
use App\Models\Like;
use App\Models\Track;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ArtistsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortBy = in_array($request->input('sort_by'), ['id', 'name']) ? $request->input('sort_by') : 'id';
        $sort = in_array($request->input('sort'), ['asc', 'desc']) ? $request->input('sort') : 'desc';
        $perPage = in_array($request->input('per_page'), [10, 25, 50, 100]) ? $request->input('per_page') : config('settings.paginate');

        $users = Artist::when($search, function ($query) use ($search) {
            return $query->SearchName($search);
        })
            ->orderBy($sortBy, $sort)
            ->paginate($perPage)
            ->appends(['search' => $search, 'sort_by' => $sortBy, 'sort' => $sort, 'per_page' => $perPage]);
        return view('admin.artists.index', ['artists' => $users]);
    }
    public function show(Request $request, $id)
    {
        $days = intval(str_replace(array('last', 'today', 'total'), array('', '0', '9999'), $request->filter));
        if (!in_array($days, array(0, 7, 30, 356, 9999))) {
            $days = 0;
        }
        $artist = Artist::where('id', $id)
            ->firstOrFail();
        $trackList = Track::whereIn('artist_id', array($id))->get()->pluck('id');

        $play = View::select('id')->where('time', '>=', Carbon::now()->subDays($days))->whereIn('track', $trackList)->get()->count();
        $like = Like::select('id')->where('time', '>=', Carbon::now()->subDays($days))->whereIn('track', $trackList)->get()->count();
        $download = Download::select('id')->where('time', '>=', Carbon::now()->subDays($days))->whereIn('track', $trackList)->get()->count();
        $comment = Comment::select('id')->where('created_at', '>=', Carbon::now()->subDays($days))->whereIn('tid', $trackList)->get()->count();

        $plays = DB::table('views')
            ->select('views.track', DB::raw('COUNT(`by`) as `count`'), 'tracks.id', 'tracks.title', 'tracks.art')
            ->whereIn('views.track', $trackList)
            ->where('views.time', '>=', Carbon::now()->subDays($days))
            ->join('tracks', 'views.track', '=', 'tracks.id')
            ->groupBy('views.track', 'tracks.id', 'tracks.title', 'tracks.art')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();
        $likes = DB::table('likes')
            ->select('likes.track', DB::raw('COUNT(`by`) as `count`'), 'tracks.id', 'tracks.title', 'tracks.art')
            ->whereIn('likes.track', $trackList)
            ->where('likes.time', '>=', Carbon::now()->subDays($days))
            ->join('tracks', 'likes.track', '=', 'tracks.id')
            ->groupBy('likes.track', 'tracks.id', 'tracks.title', 'tracks.art')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();
        $comments = DB::table('comments')
            ->select('comments.tid', DB::raw('COUNT(comments.id) as `count`'), 'tracks.id', 'tracks.title', 'tracks.art')
            ->whereIn('comments.tid', $trackList)
            ->where('comments.created_at', '>=', Carbon::now()->subDays($days))
            ->join('tracks', 'comments.tid', '=', 'tracks.id')
            ->groupBy('comments.tid', 'tracks.id', 'tracks.title', 'tracks.art')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();

        $played_most = DB::table('views')
            ->select('views.by', DB::raw('COUNT(`by`) as `count`'), 'users.id', 'users.username', 'users.first_name', 'users.last_name', 'users.image')
            ->whereIn('track', $trackList)
            ->where('time', '>=', Carbon::now()->subDays($days))
            ->join('users', 'views.by', '=', 'users.id')
            ->groupBy('users.id', 'users.username', 'users.first_name', 'users.last_name', 'users.image')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();

        $downloaded_most = DB::table('downloads')
            ->select('downloads.by', DB::raw('COUNT(`by`) as `count`'), 'users.id', 'users.username', 'users.first_name', 'users.last_name', 'users.image')
            ->whereIn('track', $trackList)
            ->where('time', '>=', Carbon::now()->subDays($days))
            ->join('users', 'downloads.by', '=', 'users.id')
            ->groupBy('users.id', 'users.username', 'users.first_name', 'users.last_name', 'users.image')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();

        $countries = DB::table('views')
            ->select('users.country', DB::raw('COUNT(`country`) as `count`'))
            ->whereIn('track', $trackList)
            ->where('time', '>=', Carbon::now()->subDays($days))
            ->where('users.country', '!=', '')
            ->join('users', 'views.by', '=', 'users.id')
            ->groupBy('users.country')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();

        $cities = DB::table('views')
            ->select('users.city', DB::raw('COUNT(`city`) as `count`'))
            ->whereIn('track', $trackList)
            ->where('time', '>=', Carbon::now()->subDays($days))
            ->where('users.city', '!=', '')
            ->join('users', 'views.by', '=', 'users.id')
            ->groupBy('users.city')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();
        return view('admin.artists.show', compact('artist', 'plays', 'likes', 'comments', 'play', 'like', 'download', 'comment', 'played_most', 'downloaded_most', 'countries', 'cities'));
    }
    public function editUser($id)
    {
        $artist = Artist::where('id', $id)
            ->firstOrFail();

        return view('admin.artists.edit', compact('artist'));
    }

    public function createArtist()
    {
        return view('admin.artists.new');
    }

    public function storeUser(StoreArtistRequest $request)
    {
        $artist = new Artist;

        $artist->name = $request->input('name');
        $artist->country = $request->input('country');
        $artist->city = $request->input('city');
        $artist->website = $request->input('website');
        $artist->description = $request->input('description');
        $artist->facebook = $request->input('facebook');
        $artist->twitter = $request->input('twitter');
        $artist->instagram = $request->input('instagram');
        $artist->youtube = $request->input('youtube');
        $artist->telegram = $request->input('telegram');
        if ($request->hasFile('image')) {
            $value = $request->file('image')->hashName();
            // Save the file
            $request->file('image')->move(public_path('uploads/avatars'), $value);
        }
        $artist->image = $value ?? 'default.png';
        $artist->save();
        return Redirect::route('artists')->with('success', __(':name has been created.', ['name' => $request->input('name')]));
    }

    public function updateGeneral(UpdateArtistProfileRequest $request, $id)
    {
        $artist = Artist::findOrFail($id);

        $artist->name = $request->input('name');
        $artist->country = $request->input('country');
        $artist->city = $request->input('city');
        $artist->website = $request->input('website');
        $artist->description = $request->input('description');

        $artist->save();

        return Redirect::route('artists.edit', $id)->with('status', 'general-updated');
    }

    public function updateSocial(UpdateArtistProfileRequest $request, $id)
    {
        $artist = Artist::findOrFail($id);
        $artist->facebook = $request->input('facebook');
        $artist->twitter = $request->input('twitter');
        $artist->instagram = $request->input('instagram');
        $artist->youtube = $request->input('youtube');
        $artist->telegram = $request->input('telegram');

        $artist->save();

        return Redirect::route('artists.edit', $id)->with('status', 'social-updated');
    }

    public function updateProfile(UpdateArtistProfileRequest $request, $id)
    {
        $artist = Artist::findOrFail($id);
        if ($request->hasFile('image')) {
            $value = $request->file('image')->hashName();
            // Check if the file exists
            if (file_exists(public_path('uploads/avatars/' . $artist->image))) {
                if ($artist->image != 'default.png') {
                    unlink(public_path('uploads/avatars/' . $artist->image));
                }
            }
            // Save the file
            $request->file('image')->move(public_path('uploads/avatars'), $value);
        } else {
            return Redirect::route('artists.edit', $id)->with('error', __('You did not selected any files to be uploaded, or the selected file(s) are empty.'));
        }

        $artist->image = $value;
        $artist->save();
        return back()->with('success', __('Settings saved.'));
    }

    public function suspendUser(Request $request, $id)
    {
        $artist = Artist::findOrFail($id);
        $artist->public = 2;
        $artist->save();

        return Redirect::back()->with('success', __('Settings saved.'));
    }

    public function restoreUser(Request $request, $id)
    {
        $artist = Artist::findOrFail($id);
        $artist->public = 1;
        $artist->save();

        return Redirect::back()->with('success', __('Settings saved.'));
    }

    public function destroyUser(Request $request, $id)
    {
        $artist = Artist::findOrFail($id);
        if ($artist->image != 'default.png') {
            if (file_exists(public_path('uploads/avatars/' . $artist->image))) {
                unlink(public_path('uploads/avatars/' . $artist->image));
            }
        }
        $artist->forceDelete();
        return Redirect::back()->with('success', __(':name has been deleted.', ['name' => $artist->name]));
    }
}

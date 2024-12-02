<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePlaylistRequest;
use App\Models\Playlist;
use App\Models\Playlistentries;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PlaylistsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $searchBy = in_array($request->input('search_by'), ['name', 'description']) ? $request->input('search_by') : 'name';
        $sortBy = in_array($request->input('sort_by'), ['id', 'name', 'views', 'downloads']) ? $request->input('sort_by') : 'id';
        $sort = in_array($request->input('sort'), ['asc', 'desc']) ? $request->input('sort') : 'desc';
        $status = $request->input('status');
        $perPage = in_array($request->input('per_page'), [10, 25, 50, 100]) ? $request->input('per_page') : config('settings.paginate');

        $playlists = Playlist::with('users')->
            when($search, function ($query) use ($search, $searchBy) {
                if ($searchBy == 'description') {
                    return $query->searchDescription($search);
                }
                return $query->searchName($search);
            })
            ->when($status, function ($query) use ($status) {
                return $query->ofStatus($status);
            })
            ->orderBy($sortBy, $sort)
            ->paginate($perPage)
            ->appends(['search' => $search, 'search_by' => $searchBy, 'status' => $status, 'sort_by' => $sortBy, 'sort' => $sort, 'per_page' => $perPage]);

        return view('admin.playlists.index', compact('playlists'));
    }
    public function createPlaylist()
    {
        return view('admin.playlists.new');
    }
    public function editPlaylist($id)
    {
        $playlist = Playlist::findOrFail($id);
        $trackList = [];
        try {
            $tracks = Playlistentries::where('playlist', $playlist->id)->get()->pluck('track');
            $list = array();
            foreach ($tracks as $track) {
                $getTrack = Track::findOrFail($track);
                $list[] = array(
                    'id' => $getTrack->id,
                    'name' => $getTrack->title,
                );
            }
            $trackList = json_encode($list);
        } catch (\Throwable $th) {
            $trackList = [];
        }
        return view('admin.playlists.edit', compact('playlist', 'trackList'));
    }
    public function storePlaylist(Request $request)
    {
        $playlist = new Playlist;
        $playlist->name = $request->input('name');
        $playlist->description = $request->input('description');
        $playlist->public = $request->input('public');
        $playlist->by = Auth()->user()->id;
        if ($request->hasFile('image')) {
            $value = $request->file('image')->hashName();
            if ($playlist->image != null) {
                // Check if the file exists
                if (file_exists(public_path('uploads/playlists/' . $playlist->image))) {
                    unlink(public_path('uploads/playlists/' . $playlist->image));
                }
            }
            // Save the file
            $request->file('image')->move(public_path('uploads/playlists'), $value);
            $playlist->image = $value;
        }
        $playlist->save();
        //Add track to playlist
        if ($request->tracks != null) {
            $obj = json_decode($request->tracks, true);
            $tracks = explode(',', implode(',', array_column($obj, 'id')));
            foreach ($tracks as $track) {
                Playlistentries::create([
                    'playlist' => $playlist->id,
                    'track' => $track
                ]);
            }
        }
        return Redirect::route('playlists')->with('success', __('Settings saved.'));
    }
    public function updatePlaylist(UpdatePlaylistRequest $request, $id)
    {
        $playlist = Playlist::findOrFail($id);
        $playlist->name = $request->input('name');
        $playlist->description = $request->input('description');
        $playlist->public = $request->input('public');
        if ($request->hasFile('image')) {
            $value = $request->file('image')->hashName();
            if ($playlist->image != null) {
                // Check if the file exists
                if (file_exists(public_path('uploads/playlists/' . $playlist->image))) {
                    unlink(public_path('uploads/playlists/' . $playlist->image));
                }
            }
            // Save the file
            $request->file('image')->move(public_path('uploads/playlists'), $value);
            $playlist->image = $value;
        }
        $playlist->save();
        //update playlist track
        if ($request->tracks != null) {
            //Original tracklist
            $tracklist = Playlistentries::where('playlist', $playlist->id)->get()->pluck('track');

            $obj = json_decode($request->tracks, true);
            $tracks = explode(',', implode(',', array_column($obj, 'id')));
            $remove = array_diff($tracklist->toArray(), $tracks);
            if ($remove) {
                Playlistentries::whereIn('track', $remove)->delete();
            }
            foreach ($tracks as $track) {
                $check = Playlistentries::where('playlist', $playlist->id)->where('track', $track)->first();
                if (is_null($check)) {
                    Playlistentries::create([
                        'playlist' => $playlist->id,
                        'track' => $track
                    ]);
                }
            }
        }

        return Redirect::back()->with('success', __(':name has been created.', ['name' => $request->input('name')]));
    }
    public function privatePlaylist(Request $request, $id)
    {
        $playlist = Playlist::findOrFail($id);
        $playlist->public = 2;
        $playlist->save();

        return Redirect::back()->with('success', __('Settings saved.'));
    }

    public function publicPlaylist(Request $request, $id)
    {
        $playlist = Playlist::findOrFail($id);
        $playlist->public = 1;
        $playlist->save();

        return Redirect::back()->with('success', __('Settings saved.'));
    }

    public function destroyPlaylist(Request $request, $id)
    {
        $playlist = Playlist::findOrFail($id);
        //Playlistentries
        Playlistentries::where('playlist', $playlist->id)->delete();
        //Playlist
        if ($playlist->image != null) {
            if (file_exists(public_path('uploads/playlists/' . $playlist->image))) {
                unlink(public_path('uploads/playlists/' . $playlist->image));
            }
        }
        $playlist->forceDelete();
        return Redirect::back()->with('success', __(':name has been deleted.', ['name' => $playlist->title]));

    }

    public function showPlaylist($id)
    {
        $playlist = Playlist::findOrFail($id);
        try {
            $tracks = Playlistentries::where('playlist', $playlist->id)->get()->pluck('track');
            $trackList = array();
            foreach ($tracks as $track) {
                $trackList[] = Track::findOrFail($track);
            }
        } catch (\Throwable $th) {}
        //Other Playlist
        $other_playlist = Playlist::with('users')->where('id', '!=' , $playlist->id)->limit(5)->get();
        return view('playlists.index', compact('playlist','trackList','other_playlist'));
    }
    public function tracksAutoComplete(Request $request)
    {
        $playlists = Track::select("title as value", "id")
            ->where('title', 'LIKE', '%' . $request->get('search') . '%')
            ->limit(10)
            ->get();

        return response()->json($playlists);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlaylistRequest;
use App\Http\Requests\UpdatePlaylistRequest;
use App\Http\Resources\PlaylistsResource;
use App\Http\Resources\TracksResource;
use App\Models\Playlist;
use App\Models\Playlistentries;
use App\Models\Track;
use App\Traits\HttpResponses;
use DB;
use Exception;
use Illuminate\Http\Request;
use Validator;

class PlaylistsController extends Controller
{
    use HttpResponses;
    public function show($id)
    {
        $tracks = Track::select('tracks.*')->with('albums')
            ->leftJoin('playlistentries', 'playlistentries.track', '=', 'tracks.id')
            ->Where('playlistentries.playlist', $id)
            ->Where('tracks.public', 1)
            ->get();
        if ($tracks) {
            return TracksResource::collection($tracks);
        }
        return $this->notFound();
    }
    public function store(StorePlaylistRequest $request)
    {
        $playlist = new Playlist;
        $playlist->fill([
            'name' => $request->input('name'),
            'public' => $request->input('public'),
            'by' => auth()->user()->id
        ]);
        $playlist->save();
        if ($playlist && $request->track_id_list != null) {
            $trackList = explode(',', $request->track_id_list);
            foreach ($trackList as $track) {
                $request = Request();
                $request['tid'] = $track;
                $request['pid'] = $playlist->id;
                $this->playlistEntry($request);
            }
        }
        $data = Playlist::with('users')->findOrFail($playlist->id);
        return $this->sendResponse(PlaylistsResource::make($data), 'Playlist create successfully.');
    }
    public function update(UpdatePlaylistRequest $request)
    {
        try {
            $playlist = Playlist::find($request->id);
            $playlist->update($request->all());
            return $this->sendResponse($playlist, 'Playlist create successfully.');
        } catch (Exception $e) {
            return $this->notFound();
        }
    }
    public function checkTrackInPlaylist($id){
        $playlists = Playlist::with('users')
            ->where('by', auth()->user()->id)
            ->orderBy('id', 'desc')->get();
        if ($playlists) {
            return PlaylistsResource::collection($playlists);
        }
    }
    public function playlistEntry(Request $request)
    {
        // Add/Remove track from playlist
        $ownerPlaylist = Playlist::where('id', $request->pid)->where('by', auth()->user()->id)->get();
        if (count($ownerPlaylist) > 0) {
            // Verify if track exists
            $track = Track::findOrFail($request->tid)->get();
            if (count($track) > 0) {
                $checkTrack = Playlist::leftJoin('playlistentries', 'playlistentries.playlist', '=', 'playlists.id')->where('playlistentries.track', $request->tid)->where('playlistentries.playlist', $request->pid)->get();
                if (count($checkTrack) > 0) {
                    //Remove
                    Playlistentries::where('track', $request->tid)->where('playlist', $request->pid)->delete();
                    return $this->sendResponse(null, 'remove from playlist');
                } else {
                    //Add
                    $playlistEntries = new Playlistentries;
                    $playlistEntries->fill([
                        'playlist' => $request->pid,
                        'track' => $request->tid,
                    ]);
                    $playlistEntries->save();
                    if ($playlistEntries) {
                        return $this->sendResponse($ownerPlaylist, 'added to playlist');
                    }
                }
            }
        }
    }
    public function destroy($id)
    {
        try {
            $playlist = Playlist::where('id',$id)->where('by', auth()->user()->id)->delete();
            if ($playlist) {
                Playlistentries::where('playlist', $id)->delete();
            }
            return $this->sendResponse('', 'playlist deleted');
        } catch (Exception $e) {
            return $this->notFound();
        }
    }
    public function notFound()
    {
        return response()->json([
            'message' => __('Resource not found.'),
            'status' => 404
        ], 404);
    }
}

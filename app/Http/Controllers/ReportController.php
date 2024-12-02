<?php

namespace App\Http\Controllers;

use App\Http\Controllers\TracksController;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Playlistentries;
use App\Models\Report;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = in_array($request->input('sort'), ['asc', 'desc']) ? $request->input('sort') : 'desc';
        $status = $request->input('status');
        $perPage = in_array($request->input('per_page'), [10, 25, 50, 100]) ? $request->input('per_page') : config('settings.paginate');

        $reports = Report::with('users')->when($search, function ($query) use ($search) {
            return $query->SearchID($search);
        })
            ->where('state', 0)
            ->orderBy('id', $sort)
            ->paginate($perPage)
            ->appends(['search' => $search, 'sort' => $sort, 'per_page' => $perPage]);

        return view('admin.reports.index', compact('reports'));
    }
    public function show($id)
    {
        $report = Report::with('users')->findOrFail($id);
        if ($report['reason']) {
            $x = 'Reported by';
            $y = 'Author';
            $title = 'Reason';
        } else {
            $x = 'Claimant';
            $y = 'Infringing Material';
            $title = 'Copyright Infringement';
        }
        $track = $report['state'] == 2 ? '' : Track::findOrFail($report['track']);

        return view('admin.reports.show', compact('report', 'x', 'y', 'title', 'track'));
    }
    public function deleteReport($id)
    {
        $report = Report::findOrFail($id);
        $report->state = 1;
        $report->save();

        return Redirect::back()->with('success', __('Settings saved.'));
    }
    public function suspendTrack($id)
    {
        $report = Report::findOrFail($id);
        $report->state = 3;
        $report->save();
        //Update track
        $track = Track::findOrFail($report->track);
        $track->public = 2;
        $track->save();
        return Redirect::back()->with('success', __('Settings saved.'));
    }
    public function restoreTrack($id)
    {
        $report = Report::findOrFail($id);
        $report->state = 4;
        $report->save();
        //Update track
        $track = Track::findOrFail($report->track);
        $track->public = 1;
        $track->save();
        return Redirect::back()->with('success', __('Settings saved.'));
    }
    public function destroyTrack(Request $request, $id){
        $report = Report::findOrFail($id);
        $report->state = 2;
        $report->save();
        $track = Track::findOrFail($report->track);
        if($track->art != 'default.png'){
            if (file_exists(public_path('uploads/tracks/' . $track->art))) {
                unlink(public_path('uploads/tracks/' . $track->art));
            }
        }
        if($track->lyric){
            if (file_exists(public_path('uploads/tracks/' . $track->lyric))) {
                unlink(public_path('uploads/tracks/' . $track->lyric));
            }
        }
        unlink(public_path('uploads/tracks/' . $track->name));
        $track->forceDelete();
        //Like
        Like::where('track', $report->track)->delete();
        //Comment
        Comment::where('tid', $report->track)->delete();
        //Playlistentries
        Playlistentries::where('track', $report->track)->delete();

        return Redirect::back()->with('success', __(':name has been deleted.', ['name' => $track->title]));
    }
}

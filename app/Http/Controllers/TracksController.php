<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Comment;
use App\Models\Download;
use App\Models\Like;
use App\Models\Track;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Models\View;

class TracksController extends Controller
{
    public function index(Request $request){
        $search = $request->input('search');
        $searchBy = in_array($request->input('search_by'), ['name', 'artist', 'album']) ? $request->input('search_by') : 'name';
        $sortBy = in_array($request->input('sort_by'), ['id', 'name', 'views', 'downloads']) ? $request->input('sort_by') : 'id';
        $sort = in_array($request->input('sort'), ['asc', 'desc']) ? $request->input('sort') : 'desc';
        $status = $request->input('status');
        $perPage = in_array($request->input('per_page'), [10, 25, 50, 100]) ? $request->input('per_page') : config('settings.paginate');

        $tracks = Track::with('albums')->
        when($search, function ($query) use ($search) {
                return $query->searchName($search);
            })
            ->when($status, function ($query) use ($status) {
                return $query->ofStatus($status);
            })
            ->orderBy($sortBy, $sort)
            ->paginate($perPage)
            ->appends(['search' => $search, 'search_by' => $searchBy, 'status' => $status, 'sort_by' => $sortBy, 'sort' => $sort, 'per_page' => $perPage]);

        return view('admin.tracks.index',compact('tracks'));
    }
    public function show(Request $request,$id){
        $days = intval(str_replace(array('last', 'today', 'total'), array('', '0', '9999'), $request->filter));
        if(!in_array($days, array(0, 7, 30, 356, 9999))) {
			$days = 0;
		}

        $track = Track::where('id', '=', $id)->firstOrFail();
        $play = View::select('id')->where('time','>=', Carbon::now()->subDays($days))->where('track','=',$track->id)->get()->count();
        $like = Like::select('id')->where('time','>=', Carbon::now()->subDays($days))->where('track','=',$track->id)->get()->count();
        $download = Download::select('id')->where('time','>=', Carbon::now()->subDays($days))->where('track','=',$track->id)->get()->count();
        $comment = Comment::select('id')->where('created_at','>=', Carbon::now()->subDays($days))->where('tid','=',$track->id)->get()->count();
        //Likes by user
        $likes = Like::with('users')->where('track', $track->id)->limit(10)->get();

        $played_most = DB::table('views')
        ->select('views.by', DB::raw('COUNT(`by`) as `count`'), 'users.id','users.username','users.first_name','users.last_name','users.image')
        ->where('track', '=', $id)
        ->where('time','>=', Carbon::now()->subDays($days))
        ->join('users', 'views.by', '=', 'users.id')
        ->groupBy('users.id','users.username','users.first_name','users.last_name','users.image')
        ->orderBy('count', 'desc')
        ->limit(10)
        ->get();

        $downloaded_most = DB::table('downloads')
        ->select('downloads.by', DB::raw('COUNT(`by`) as `count`'), 'users.id','users.username','users.first_name','users.last_name','users.image')
        ->where('track', '=', $id)
        ->where('time','>=', Carbon::now()->subDays($days))
        ->join('users', 'downloads.by', '=', 'users.id')
        ->groupBy('users.id','users.username','users.first_name','users.last_name','users.image')
        ->orderBy('count', 'desc')
        ->limit(10)
        ->get();

        $countries = DB::table('views')
        ->select('users.country', DB::raw('COUNT(`country`) as `count`'))
        ->where('track', '=', $id)
        ->where('time','>=', Carbon::now()->subDays($days))
        ->where('users.country', '!=', '')
        ->join('users', 'views.by', '=', 'users.id')
        ->groupBy('users.country')
        ->orderBy('count', 'desc')
        ->limit(10)
        ->get();

        $cities = DB::table('views')
        ->select('users.city', DB::raw('COUNT(`city`) as `count`'))
        ->where('track', '=', $id)
        ->where('time','>=', Carbon::now()->subDays($days))
        ->where('users.city', '!=', '')
        ->join('users', 'views.by', '=', 'users.id')
        ->groupBy('users.city')
        ->orderBy('count', 'desc')
        ->limit(10)
        ->get();

        return view('admin.tracks.show', compact('track','play','likes','like','download','comment','played_most','downloaded_most','countries', 'cities'));
    }
    public function detail($id){
        $track = Track::where('id', '=', $id)->where('public',1)->firstOrFail();
        //Likes
        $likes = Like::with('users')->where('track', $track->id)->limit(10)->get();
        //Comments
        $comments = Comment::with('users')->where('tid', $track->id)->get();
        //Recommend
        $recommended = Track::where('album_id', '=', $track->album_id)->where('id', '!=', $track->id)->where('public',1)->orderBy('views','desc')->limit(5)->get();
        //Statistics
        $today = View::select('id')->where('time','>=', Carbon::now())->where('track','=',$track->id)->get()->count();
        $yesterday = View::select('id')->where('time','=', Carbon::yesterday())->where('track','=',$track->id)->get()->count();
        $total = View::select('id')->where('track','=',$track->id)->get()->count();
        return view('tracks.index', compact('track','likes','comments','recommended','today','yesterday','total'));
    }
    public function createTrack(){
        $albums = DB::table('albums')->select('albums.id as id','albums.name','albums.slug','productions.slug as folder')->where('albums.public', '1')->join('productions', 'albums.pid', '=', 'productions.id')->orderBy('albums.id', 'desc')->get();
        $artists = Artist::where('public', '=', 1)->orderBy('id','asc')->get()->pluck('name','id');
        return view('admin.tracks.new', compact('albums','artists'));
    }
    public function editTrack($id){
        $track = Track::findOrFail($id);
        $albums =  Album::where('public', '=', 1)->orderBy('id','desc')->get();
        $artists = Artist::where('public', '=', 1)->orderBy('id','asc')->get()->pluck('name','id');
        return view('admin.tracks.edit', compact('track','albums','artists'));
    }
    public function storeTrack(Request $request){
        $data = json_decode($request['data']);
        $art = 'default.png';
        $lyric = '';
        $name = '';
        $size = 0;
        $artist_array = json_decode(json_encode($data->artistId), true);
        $track = new Track;
        $album_data = explode(",", $data->albumId);
        $track->title = $data->title;
        $track->artist_id = implode(',', array_column($artist_array, 'id'));
        $track->description = $data->description;
        $track->album_id = $album_data[0];
        $album_path = $album_data[2].'/'.$album_data[1];
        $file_name = Str::slug($data->title) ? Str::slug($data->title) : Str::random(9);
        //Upload Cover
        if($request->hasFile('art')){
            $extension = pathinfo($request->art->getClientOriginalName(), PATHINFO_EXTENSION);
            $title = $file_name.'.'.$extension;
            $art = $album_path.'/'.$title;
            $request->art->move(public_path('uploads/tracks/'.$album_path.'/'), $title);
        }
        //Upload Lyric
        if($request->hasFile('lyric')){
            $extension = pathinfo($request->lyric->getClientOriginalName(), PATHINFO_EXTENSION);
            $title = $file_name.'.'.$extension;
            $lyric = $album_path.'/'.$title;
            $request->lyric->move(public_path('uploads/tracks/'.$album_path.'/'), $title);
        }
        //Upload Track
        if($request->hasFile('track')){
            $extension = pathinfo($request->track->getClientOriginalName(), PATHINFO_EXTENSION);
            $size = $request->file('track')->getSize();
            $title = $file_name.'.'.$extension;
            $name = $album_path.'/'.$title;
            $request->track->move(public_path('uploads/tracks/'.$album_path.'/'), $title);
        }
        $track->name = $name;
        $track->art = $art;
        $track->lyric = $lyric;
        $track->size = $size;
        $track->download = $data->download;
        $track->public = $data->public;
        $track->save();
    }
    public static function getArtistDetail($artistId){
        $artist_array = explode(',' , $artistId);
        $artist_detail = [];
        foreach($artist_array as $key => $value){
            $getArtist = Artist::findOrFail($value);
            $artist_detail['name'][] = rtrim($getArtist->name . ',', ',');
            $artist_detail['image'][] = rtrim($getArtist->image.',',',');
        }
        return $artist_detail;
    }
    public function updateTrack(Request $request, $id){
        $data = json_decode($request['data']);
        $track = Track::findOrFail($id);

        $artist_array = json_decode(json_encode($data->artistId), true);
        $album_data = explode(",", $data->albumId);
        $track->title = $data->title;
        $track->artist_id = implode(',', array_column($artist_array, 'id'));
        $track->description = $data->description;
        $track->album_id = $album_data[0];
        $album_path = $album_data[1];
        $file_name = Str::slug($data->title) ? Str::slug($data->title) : Str::random(9);
        //Update Cover
        if($request->hasFile('art')){
            $extension = pathinfo($request->art->getClientOriginalName(), PATHINFO_EXTENSION);
            $title = $file_name.'.'.$extension;
            if (file_exists(public_path('uploads/tracks/' . $track->art))) {
                if($track->art != 'default.png'){
                    unlink(public_path('uploads/tracks/' . $track->art));
                }
            }
            $art = $album_path.'/'.$title;
            $request->art->move(public_path('uploads/tracks/'.$album_path.'/'), $title);
            $track->art = $art;
        }
        //Update Lyric
        if($request->hasFile('lyric')){
            $extension = pathinfo($request->lyric->getClientOriginalName(), PATHINFO_EXTENSION);
            $title = $file_name.'.'.$extension;
            $lyric = $album_path.'/'.$title;
            if($track->lyric){
                if (file_exists(public_path('uploads/tracks/' . $track->lyric))) {
                    unlink(public_path('uploads/tracks/' . $track->lyric));
                }
            }
            $request->lyric->move(public_path('uploads/tracks/'.$album_path.'/'), $title);
            $track->lyric = $lyric;
        }
        //Update Track
        if($request->hasFile('track')){
            $extension = pathinfo($request->track->getClientOriginalName(), PATHINFO_EXTENSION);
            $size = $request->file('track')->getSize();
            $title = $file_name.'.'.$extension;
            if (file_exists(public_path('uploads/tracks/' . $track->name))) {
                unlink(public_path('uploads/tracks/' . $track->name));
            }
            $name = $album_path.'/'.$title;
            $request->track->move(public_path('uploads/tracks/'.$album_path.'/'), $title);
            $track->name = $name;
            $track->size = $size;
        }
        $track->download = $data->download;
        $track->public = $data->public;
        $track->save();
    }
    public function unpublicTrack(Request $request, $id){
        $track = Track::findOrFail($id);
        $track->public = 2;
        $track->save();

        return Redirect::back()->with('success', __('Settings saved.'));
    }

    public function publicTrack(Request $request, $id){
        $track = Track::findOrFail($id);
        $track->public = 1;
        $track->save();

        return Redirect::back()->with('success', __('Settings saved.'));
    }

    public function destroyTrack(Request $request, $id){
        $track = Track::findOrFail($id);
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
        return Redirect::back()->with('success', __(':name has been deleted.', ['name' => $track->title]));
    }
}

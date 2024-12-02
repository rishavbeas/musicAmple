<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlbumRequest;
use App\Http\Requests\UpdateAlbumRequest;
use App\Models\Album;
use App\Models\Production;
use App\Models\Track;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class AlbumsController extends Controller
{
    public function index(Request $request){
        $search = $request->input('search');
        $searchBy = 'name';
        $sortBy = in_array($request->input('sort_by'), ['id', 'name']) ? $request->input('sort_by') : 'id';
        $sort = in_array($request->input('sort'), ['asc', 'desc']) ? $request->input('sort') : 'desc';
        $status = $request->input('status');
        $perPage = in_array($request->input('per_page'), [10, 25, 50, 100]) ? $request->input('per_page') : config('settings.paginate');

        $albums = Album::with('productions')->when($search, function ($query) use ($search, $searchBy) {
                if($searchBy == 'name') {
                    return $query->searchName($search);
                }
            })
            ->when($status, function ($query) use ($status) {
                return $query->ofStatus($status);
            })
            ->orderBy($sortBy, $sort)
            ->paginate($perPage)
            ->appends(['search' => $search, 'search_by' => $searchBy, 'status' => $status, 'sort_by' => $sortBy, 'sort' => $sort, 'per_page' => $perPage]);
        return view('admin.albums.index', compact('albums'));
    }
    public function show($id){
        $album = Album::where('id', '=', $id)->firstOrFail();
        $tracks = Track::where('album_id', '=', $album->id)->get();
        return view('admin.albums.show', compact('album','tracks'));
    }
    public function createAlbum(){
        $productions =  Production::where('public', '=', 1)->get();
        return view('admin.albums.new', compact('productions'));
    }

    public function editAlbum($id){
        $album = Album::where('id', $id)->firstOrFail();
        $productions =  Production::where('public', '=', 1)->get();
        return view('admin.albums.edit', compact('album','productions'));
    }

    public function storeAlbum(StoreAlbumRequest $request)
    {
        $album = new Album;
        $productionData = explode(",", $request->input('pid'));
        $album->name = $request->input('name');
        $album->slug = Str::slug($request->input('name'));
        $album->pid = $productionData[0];
        $album->public = $request->input('public');
        //Create Folder
        $path = public_path('uploads/tracks/'.$productionData[1].'/'.$album->slug);
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }
        //Upload Image
        if($request->hasFile('image')){
            $extension = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_EXTENSION);
            $value = $album->slug.'.'.$extension;
            $request->file('image')->move(public_path('uploads/covers/albums'), $value);
        }
        $album->image = $value ?? 'default.png';
        $album->save();

        return Redirect::route('albums')->with('success', __(':name has been created.', ['name' => $request->input('name')]));
    }

    public function updateAlbum(UpdateAlbumRequest $request, $id)
    {
        $album = Album::findOrFail($id);
        $productionData = explode(",", $request->input('pid'));
        $album->name = $request->input('name');
        $album->slug = Str::slug($request->input('name'));
        $album->pid = $productionData[0];
        $album->public = $request->input('public');
        if($request->hasFile('image')){
            $extension = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_EXTENSION);
            $value = $album->slug.'.'.$extension;
            if (file_exists(public_path('uploads/covers/albums/' . $album->image))) {
                if($album->image != 'default.png'){
                    unlink(public_path('uploads/covers/albums/' . $album->image));
                }
            }
            // Save the file
            $request->file('image')->move(public_path('uploads/covers/albums'), $value);
            $album->image = $value;
        }

        $album->save();

        return Redirect::route('albums.edit', $id)->with('success', __('Settings saved.'));
    }

    public function unpublicAlbum(Request $request, $id){
        $album = Album::findOrFail($id);
        $album->public = 2;
        $album->save();

        return Redirect::back()->with('success', __('Settings saved.'));
    }

    public function publicAlbum(Request $request, $id){
        $album = Album::findOrFail($id);
        $album->public = 1;
        $album->save();

        return Redirect::back()->with('success', __('Settings saved.'));
    }

    public function destroyAlbum(Request $request, $id){
        $album = Album::findOrFail($id);
        if($album->image != 'default.png'){
            if (file_exists(public_path('uploads/covers/albums/' . $album->image))) {
                unlink(public_path('uploads/covers/albums/' . $album->image));
            }
        }
        $album->forceDelete();
        return Redirect::back()->with('success', __(':name has been deleted.', ['name' => $album->name]));
    }
}

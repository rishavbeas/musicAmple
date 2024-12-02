<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Playlist;
use App\Models\Production;
use App\Models\Widget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AppController extends Controller
{
    public function index()
    {
        $widgets_sort = json_encode(Widget::orderBy('sort_id','asc')->get()->toArray());
        return view('admin.app.index', compact('widgets_sort'));
    }
    public function createWidget()
    {
        $checkAds = Widget::where('type','ads')->count();
        $enableAds = ['albums' => 'Albums'];
        return view('admin.app.new',compact('enableAds'));
    }
    public function storeWidget(Request $request)
    {
        $widget = new Widget;

        $widget->title = $request->input('title');
        $widget->type = $request->input('type');
        $widget->public = $request->input('public');
        //Playlists
        if ($request->playlists) {
            $obj = json_decode($request->playlists, true);
            $widget->value = implode(',', array_column($obj, 'id'));
        }
        //Banner
        if ($request->hasFile('image')) {
            $value = $request->file('image')->hashName();
            // Save the file
            $request->file('image')->move(public_path('uploads/banners/'), $value);
            $widget->value = json_encode(array("link" => $request->link, "image" => $value), true);
        }
        //Custom Artists
        if ($request->artists) {
            $obj = json_decode($request->artists, true);
            $widget->value = implode(',', array_column($obj, 'id'));
        }
        //Custom Albums
        if ($request->albums) {
            $obj = json_decode($request->albums, true);
            $widget->value = implode(',', array_column($obj, 'id'));
        }
        //Custom Productions
        if ($request->productions) {
            $obj = json_decode($request->productions, true);
            $widget->value = implode(',', array_column($obj, 'id'));
        }
        //Admob Ads
        if($request->type == 'ads'){
            $checkAds = Widget::where('type','ads')->count();
            if($checkAds>0){
                return Redirect::route('app.new')->with('error', __('Can not create ads more than one.'));
            }else{
                $widget->value = json_encode(array("android" => $request->ads_android, "ios" => $request->ads_ios), true);
            }
        }
        $widget->save();
        return Redirect::route('app')->with('success', __(':name has been created.', ['name' => $request->input('title')]));
    }
    public function playlists()
    {
        return view('admin.app.playlists');
    }
    public function editWidget($id)
    {
        $widget = Widget::findOrFail($id);
        $image = '';
        $link = '';
        $androidAds = '';
        $iosAds = '';
        $artistList = '[]';
        $albumList = '[]';
        $playlistList = '[]';
        $productionList = '[]';
        if ($widget->type == 'banner') {
            $banner = json_decode($widget->value, true);
            $image = $banner["image"] ?? '';
            $link = $banner["link"] ?? '';
        }
        if ($widget->type == 'ads') {
            $ads = json_decode($widget->value, true);
            $androidAds = $ads["android"] ?? '';
            $iosAds = $ads["ios"] ?? '';
        }
        if ($widget->type == 'artists') {
            if ($widget->value) {
                $list = array();
                $artists = explode(',', $widget->value);
                foreach ($artists as $artist) {
                    $getArtist = Artist::findOrFail($artist);
                    $list[] = array(
                        'id' => $getArtist->id,
                        'name' => $getArtist->name,
                    );
                }
                $artistList = json_encode($list);
            }
        }
        if ($widget->type == 'albums') {
            if ($widget->value) {
                $list = array();
                $albums = explode(',', $widget->value);
                foreach ($albums as $album) {
                    $getAlbum = Album::findOrFail($album);
                    $list[] = array(
                        'id' => $getAlbum->id,
                        'name' => $getAlbum->name,
                    );
                }
                $albumList = json_encode($list);
            }
        }
        if ($widget->type == 'playlists') {
            if ($widget->value) {
                $list = array();
                $playlists = explode(',', $widget->value);
                foreach ($playlists as $playlist) {
                    $getPlaylist = Playlist::findOrFail($playlist);
                    $list[] = array(
                        'id' => $getPlaylist->id,
                        'name' => $getPlaylist->name,
                    );
                }
                $playlistList = json_encode($list);
            }
        }
        if ($widget->type == 'productions') {
            if ($widget->value) {
                $list = array();
                $productions = explode(',', $widget->value);
                foreach ($productions as $production) {
                    $getProduction = Production::findOrFail($production);
                    $list[] = array(
                        'id' => $getProduction->id,
                        'name' => $getProduction->name,
                    );
                }
                $productionList = json_encode($list);
            }
        }
        return view('admin.app.edit', compact('widget', 'image', 'link', 'artistList', 'albumList', 'playlistList', 'productionList', 'androidAds', 'iosAds'));
    }
    public function updateWidget(Request $request, $id)
    {
        $widget = Widget::findOrFail($id);
        $widget->title = $request->input('title');
        $widget->public = $request->input('public');
        if ($request->type == 'all') {
            $widget->value = null;
        }
        //Banner
        if ($request->hasFile('image')) {
            $old_banner = json_decode($widget->value, true);
            if ($old_banner != null) {
                if (file_exists(public_path('uploads/banners/' . $old_banner['image']))) {
                    unlink(public_path('uploads/banners/' . $old_banner['image']));
                }
            }
            $value = $request->file('image')->hashName();
            // Save the file
            $request->file('image')->move(public_path('uploads/banners/'), $value);
            $widget->value = json_encode(array("link" => $request->link, "image" => $value), true);
        }
        //Update Artists
        if ($request->artists) {
            if($request->artists!=null){
                $obj = json_decode($request->artists, true);
                $widget->value = implode(',', array_column($obj, 'id'));
            }
        }
        //Update Albums
        if ($request->albums) {
            $obj = json_decode($request->albums, true);
            $widget->value = implode(',', array_column($obj, 'id'));
        }
        //Update Playlists
        if ($request->playlists) {
            $obj = json_decode($request->playlists, true);
            $widget->value = implode(',', array_column($obj, 'id'));
        }
        //Update Productions
        if ($request->productions) {
            $obj = json_decode($request->productions, true);
            $widget->value = implode(',', array_column($obj, 'id'));
        }
        //Update Admob Ads
        if($request->ads_android && $request->ads_ios){
            $widget->value = json_encode(array("android" => $request->ads_android, "ios" => $request->ads_ios), true);
        }
        $widget->save();

        return Redirect::route('app.edit', $id)->with('success', __('Settings saved.'));
    }
    public function artistsAutoComplete(Request $request)
    {
        $playlists = Artist::select("name as value", "id")
            ->where('name', 'LIKE', '%' . $request->get('search') . '%')
            ->limit(10)
            ->get();

        return response()->json($playlists);
    }
    public function albumsAutoComplete(Request $request)
    {
        $playlists = Album::select("name as value", "id")
            ->where('name', 'LIKE', '%' . $request->get('search') . '%')
            ->limit(10)
            ->get();

        return response()->json($playlists);
    }
    public function playlistsAutoComplete(Request $request)
    {
        $playlists = Playlist::select("name as value", "id")
            ->where('name', 'LIKE', '%' . $request->get('search') . '%')
            ->limit(10)
            ->get();

        return response()->json($playlists);
    }
    public function productionsAutoComplete(Request $request)
    {
        $playlists = Production::select("name as value", "id")
            ->where('name', 'LIKE', '%' . $request->get('search') . '%')
            ->limit(10)
            ->get();

        return response()->json($playlists);
    }
    public function unpublicWidget(Request $request, $id)
    {
        $widget = Widget::findOrFail($id);
        $widget->public = 2;
        $widget->save();

        return Redirect::back()->with('success', __('Settings saved.'));
    }

    public function publicWidget(Request $request, $id)
    {
        $widget = Widget::findOrFail($id);
        $widget->public = 1;
        $widget->save();

        return Redirect::back()->with('success', __('Settings saved.'));
    }
    public function destroyWidget(Request $request, $id)
    {
        $widget = Widget::findOrFail($id);
        if ($widget->type == 'banner') {
            $old_banner = json_decode($widget->value, true);
            if ($old_banner != null) {
                if (file_exists(public_path('uploads/banners/' . $old_banner['image']))) {
                    unlink(public_path('uploads/banners/' . $old_banner['image']));
                }
            }
        }
        $widget->forceDelete();
        return Redirect::back()->with('success', __(':name has been deleted.', ['name' => $widget->title]));
    }
    public function updateOrder(Request $request){
        if($request->has('ids')){
            $arr = $request->input('ids');

            foreach($arr as $sortOrder => $id){
                $widget = Widget::find($id);
                $widget->sort_id = $sortOrder;
                $widget->save();
            }
            return ['success'=>true,'message'=>'Updated'];
        }
    }
}

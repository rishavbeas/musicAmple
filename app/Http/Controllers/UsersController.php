<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserProfileRequest;
use App\Models\Comment;
use App\Models\Download;
use App\Models\Like;
use App\Models\Playlist;
use App\Models\Playlistentries;
use App\Models\Relations;
use App\Models\Report;
use App\Models\Track;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules;
class UsersController extends Controller
{
    public function index(Request $request){
        $search = $request->input('search');
        $searchBy = in_array($request->input('search_by'), ['name', 'email']) ? $request->input('search_by') : 'name';
        $role = $request->input('role');
        $sortBy = in_array($request->input('sort_by'), ['id', 'name', 'email']) ? $request->input('sort_by') : 'id';
        $sort = in_array($request->input('sort'), ['asc', 'desc']) ? $request->input('sort') : 'desc';
        $perPage = in_array($request->input('per_page'), [10, 25, 50, 100]) ? $request->input('per_page') : config('settings.paginate');

        $users = User::when($search, function ($query) use ($search, $searchBy) {
                if($searchBy == 'email') {
                    return $query->searchEmail($search);
                }
                return $query->searchUserName($search);
            })
            ->where('id' ,'!=', Auth::user()->id)
            ->when(isset($role) && is_numeric($role), function ($query) use ($role) {
                return $query->ofRole($role);
            })
            ->orderBy($sortBy, $sort)
            ->paginate($perPage)
            ->appends(['search' => $search, 'search_by' => $searchBy, 'role' => $role, 'sort_by' => $sortBy, 'sort' => $sort, 'per_page' => $perPage]);
        return view('admin.users.index',['users' => $users]);
    }
    public function create(){
        return view('admin.users.new');
    }
    public function store(Request $request){
        $request->validate([
            'username' => ['required',  'string', 'unique:users,username', 'max:255'],
            'first_name' => ['sometimes', 'string', 'max:255'],
            'last_name' => ['sometimes', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role'  => ['required', 'integer', 'between:0,1'],
        ]);
        $user = new User;

        $user->username = $request->input('username');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role = $request->input('role');
        $user->image = 'default.png';
        $user->cover = 'default.png';
        $user->ip = $request->ip();

        $user->save();
        return Redirect::route('users')->with('success',  __(':name has been created.', ['name' => $request->input('username')]));
    }
    public function editUser($id) {
        $user = User::where('id', $id)
            ->firstOrFail();

        return view('admin.users.edit', compact('user'));
    }

    public function show($username) {
        $user = User::where('username', $username)
            ->firstOrFail();

        return view('profile.index', compact('user'));
    }

    public function updateUser(UpdateUserProfileRequest $request, $id) {
        $user = User::findOrFail($id);
        if ($request->user()->id == $user->id && $request->input('role') == 0) {
            return Redirect::route('users.edit', $id)->with('error', __('Operation denied.'));
        }

        $user->username = $request->input('username');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->country = $request->input('country') ?? '';
        $user->city = $request->input('city') ?? '';
        $user->website = $request->input('webstite');
        $user->facebook = $request->input('facebook');
        $user->twitter = $request->input('twitter');
        $user->instagram = $request->input('instagram');
        $user->youtube = $request->input('youtube');
        $user->telegram = $request->input('telegram');
        $user->description = $request->input('description');
        $user->role = $request->input('role');

        $user->save();
        return Redirect::route('users.edit', $id)->with('status', 'profile-updated');
    }

    public function suspendUser(Request $request, $id){
        $user = User::findOrFail($id);

        if ($request->user()->id == $user->id && $request->input('role') == 0) {
            return Redirect::route('users.edit', $id)->with('error', __('Operation denied.'));
        }

        $user->suspended = 1;
        $user->save();

        return Redirect::back()->with('success', __('Settings saved.'));
    }

    public function restoreUser(Request $request, $id){
        $user = User::findOrFail($id);

        if ($request->user()->id == $user->id && $request->input('role') == 0) {
            return Redirect::route('users.edit', $id)->with('error', __('Operation denied.'));
        }

        $user->suspended = 0;
        $user->save();

        return Redirect::back()->with('success', __('Settings saved.'));
    }

    public function destroyUser(Request $request, $id){
        $user = User::findOrFail($id);

        if ($request->user()->id == $user->id && $request->input('role') == 0) {
            return Redirect::route('users.edit', $id)->with('error', __('Operation denied.'));
        }
        // Delete the profile images
        deleteImages(array($user->image), 1);
        deleteImages(array($user->cover), 0);

        // Update Likes Count
        $likeTracks = Like::where('by', $user->id)->pluck('track');
        Track::whereIn('id', $likeTracks)->decrement('likes', 1);

        //Playlistentries
        $playlist = Playlist::where('by', $user->id)->pluck('id');
        Playlistentries::whereIn('playlist', $playlist)->delete();

        //Playlist
        Playlist::where('by', $user->id)->delete();
        //Comment
        Comment::where('uid', $user->id)->delete();
        //Download
        Download::where('by', $user->id)->delete();
        //Like
        Like::where('by', $user->id)->delete();
        //View
        \App\Models\View::where('by', $user->id)->delete();
        //Report
        Report::where('by', $user->id)->delete();
        //Relations
        Relations::where('subscriber', $user->id)->delete();
        Relations::where('leader', $user->id)->delete();

        $user->forceDelete();

        return Redirect::back()->with('success', __(':name has been deleted.', ['name' => realname($user->username, $user->first_name, $user->last_name)]));
    }
}

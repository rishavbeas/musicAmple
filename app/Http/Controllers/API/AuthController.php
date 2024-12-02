<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Http\Resources\ArtistsResource;
use App\Http\Resources\PlaylistsResource;
use App\Http\Resources\TracksResource;
use App\Http\Resources\UsersResource;
use App\Models\Comment;
use App\Models\Download;
use App\Models\Like;
use App\Models\Playlist;
use App\Models\Playlistentries;
use App\Models\Relations;
use App\Models\Report;
use App\Models\Track;
use App\Models\View;
use App\Traits\HttpResponses;
use Auth;
use Illuminate\Validation\Rules;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Storage;
use Str;
use Validator;

class AuthController extends Controller
{
    use HttpResponses;
    public function register(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'unique:users,username', 'max:255'],
            'first_name' => ['sometimes', 'string', 'max:255'],
            'last_name' => ['sometimes', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $request->request->add(['ip' => $request->ip()]);
        $input = $request->all();
        $image = 'default.png';
        if ($input['image'] != '') {
            $imageContent = file_get_contents($input['image']);
            $filename = date('mdYHis') . uniqid() . '.png';
            Storage::disk('public_uploads')->put('uploads/avatars/' . $filename, $imageContent);
            $image = $filename;
        }
        $input['image'] = $image;
        $input['password'] = Hash::make($request->password);
        $user = User::create($input);
        $success['token'] = $user->createToken(config('app.name'))->plainTextToken;
        $success['username'] = $user->username;

        return $this->sendResponse($success, 'User register successfully.');
    }
    public function socialLogin(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $request->request->add(['ip' => $request->ip()]);
            $request->validate([
                'first_name' => ['sometimes', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            ]);
            $input = $request->all();
            $image = 'default.png';
            if ($input['image'] != '') {
                $imageContent = file_get_contents($input['image']);
                $filename = date('mdYHis') . uniqid() . '.png';
                Storage::disk('public_uploads')->put('uploads/avatars/' . $filename, $imageContent);
                $image = $filename;
            }
            $input['last_name'] = '';
            $input['image'] = $image;
            $input['username'] = $this->generateUserName($request->first_name);
            $input['password'] = Hash::make($request->password);
            $user = User::create($input);
        }
        $success['token'] = $user->createToken(config('app.name'))->plainTextToken;
        $success['username'] = $user->username;
        return $this->sendResponse($success, 'Login success');
    }

    public function login(Request $request)
    {
        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt(array($fieldType => $request->username, 'password' => $request->password))) {
            $user = Auth::user();
            if ($user->suspended == 1) {
                return $this->sendError('This account is currently suspended.');
            } else {
                $success['token'] = $user->createToken(config('app.name'))->plainTextToken;
                $success['username'] = $user->username;

                return $this->sendResponse($success, 'User login successfully.');
            }
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return $this->sendResponse('', 'You have successfully been logged out.');
    }

    public function account()
    {
        $user = auth()->user();
        if (auth()->user()->suspended == 1) {
            auth()->user()->tokens()->delete();
            return $this->sendError(null, 'This account is currently suspended.');
        } else {
            return $this->sendResponse(UsersResource::make(auth()->user()), 'User login successfully.');
        }
    }

    public function playlists()
    {
        $playlists = Playlist::with('users')
            ->where('by', auth()->user()->id)
            ->orderBy('playlists.id', 'desc')
            ->paginate(config('settings.m_per_playlist'));
        if ($playlists) {
            return PlaylistsResource::collection($playlists)->resource;
        }
    }
    public function likes()
    {
        $tracks = Track::with('albums')
            ->leftJoin('likes', 'likes.track', '=', 'tracks.id')
            ->Where('likes.by', auth()->user()->id)
            ->paginate(config('settings.e_per_page'));
        if ($tracks) {
            return TracksResource::collection($tracks)->resource;
        }
    }
    public function subscriptions()
    {
        $subscriptions = Relations::join('artists', 'relations.leader', '=', 'artists.id')->where('relations.subscriber', auth()->user()->id)->paginate(config('settings.e_per_page'));
        return ArtistsResource::collection($subscriptions)->resource;
    }
    public function subscribers()
    {
        $subscriptions = Relations::join('users', 'relations.leader', '=', 'users.id')->where('relations.subscriber', auth()->user()->id)->paginate(config('settings.e_per_page'));
        return UsersResource::collection($subscriptions)->resource;
    }
    public function updateGeneral(UpdateUserProfileRequest $request)
    {
        auth()->user()->fill($request->validated());
        auth()->user()->save();
        return $this->sendResponse(UsersResource::make(auth()->user()), 'User update successfully.');
    }
    public function updateSocial(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'facebook' => ['string', 'nullable'],
            'twitter' => ['string', 'nullable'],
            'instagram' => ['string', 'nullable'],
            'telegram' => ['string', 'nullable'],
            'youtube' => ['string', 'nullable'],
        ]);

        if ($validator->fails()) {
            return $this->sendError('Please try again and check all fields', $validator->errors());
        }
        auth()->user()->fill($validator->validated());
        auth()->user()->save();
        return $this->sendResponse(UsersResource::make(auth()->user()), 'User update successfully.');
    }
    public function updatePassword(Request $request)
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        auth()->user()->update([
            'password' => Hash::make($validated['password']),
        ]);
        return $this->sendResponse(UsersResource::make(auth()->user()), 'Password update successfully.');
    }
    public function updateImage(ProfileUpdateRequest $request)
    {
        if ($request->hasFile('image')) {
            $value = $request->file('image')->hashName();
            // Check if the file exists
            if (file_exists(public_path('uploads/avatars/' . auth()->user()->image))) {
                if ($request->user()->image != 'default.png') {
                    unlink(public_path('uploads/avatars/' . auth()->user()->image));
                }
            }
            // Save the file
            $request->file('image')->move(public_path('uploads/avatars'), $value);
            auth()->user()->fill([
                'image' => $value
            ]);
            auth()->user()->save();
            return $this->sendResponse(UsersResource::make(auth()->user()), 'User update successfully.');
        } else {
            return $this->sendError('error', __('You did not selected any files to be uploaded, or the selected file(s) are empty.'));
        }
    }
    public function updateCover(Request $request)
    {
        if ($request->hasFile('cover')) {
            $value = $request->file('cover')->hashName();
            // Check if the file exists
            if (file_exists(public_path('uploads/covers/' . auth()->user()->cover))) {
                if ($request->user()->cover != 'default.png') {
                    unlink(public_path('uploads/covers/' . auth()->user()->cover));
                }
            }
            // Save the file
            $request->file('cover')->move(public_path('uploads/covers'), $value);
            auth()->user()->fill([
                'cover' => $value
            ]);
            auth()->user()->save();
            return $this->sendResponse(UsersResource::make(auth()->user()), 'User update successfully.');
        } else {
            return $this->sendError('error', __('You did not selected any files to be uploaded, or the selected file(s) are empty.'));
        }
    }
    public function subscribe(Request $request, $id)
    {
        $subscribe = Relations::where('subscriber', auth()->user()->id)->where('leader', $id)->where('type', $request->type)->get();
        if (count($subscribe) > 0) {
            Relations::where('subscriber', auth()->user()->id)->where('leader', $id)->where('type', $request->type)->delete();
            return $this->sendResponse(false, 'Unfollow');
        } else {
            $follow = Relations::create([
                'subscriber' => auth()->user()->id,
                'leader' => $id,
                'type' => $request->type
            ]);
            return $this->sendResponse(true, 'Follow success');
        }
    }
    public function checkSubscribe(Request $request, $id)
    {
        //Subscribe & Unsubscribe Button
        $subscribe = Relations::where('subscriber', auth()->user()->id)->where('leader', $id)->where('type', $request->type)->get();
        return $this->sendResponse(count($subscribe) > 0 ? true : false, null);
    }
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);
        $user = auth()->user();
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
        View::where('by', $user->id)->delete();
        //Report
        Report::where('by', $user->id)->delete();
        //Relations
        Relations::where('subscriber', $user->id)->delete();
        Relations::where('leader', $user->id)->delete();

        $user->delete();
        return $this->sendResponse(null, 'User delete successfully.');
    }
    public function generateUserName($name){
        $username = Str::lower(Str::slug($name));
        if(User::where('username', '=', $username)->exists()){
            $uniqueUserName = $username.Str::lower(Str::random(4));
            $username = $this->generateUserName($uniqueUserName);
        }
        return $username;
    }
}

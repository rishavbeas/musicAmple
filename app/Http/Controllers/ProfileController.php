<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('admin.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updateImage(ProfileUpdateRequest $request) {
        $request->user()->fill($request->validated());
        if($request->hasFile('avatar')){
            $value = $request->file('avatar')->hashName();
            deleteImages(array($request->user()->image), 1);
            // Save the file
            $request->file('avatar')->move(public_path('uploads/avatars'), $value);
        }else{
            return back()->with('error', __('You did not selected any files to be uploaded, or the selected file(s) are empty.'));
        }

        $request->user()->image = $value;
        $request->user()->save();
        return back()->with('success', __('Settings saved.'));
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        // Delete the profile images
        deleteImages(array($user->image), 1);
        deleteImages(array($user->cover), 0);

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

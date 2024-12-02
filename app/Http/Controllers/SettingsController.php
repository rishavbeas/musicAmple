<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSettingsRequest;
use App\Http\Requests\UpdateSettingsRequest;
use App\Models\Settings;
use Illuminate\Support\Facades\Redirect;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(UpdateSettingsRequest $request)
    {
        if($request->hasFile('logo')){
            $extension = pathinfo($request->file('logo')->getClientOriginalName(), PATHINFO_EXTENSION);
            if (file_exists(public_path('uploads/brand/' . config('settings.logo')))) {
                unlink(public_path('uploads/brand/' . config('settings.logo')));
            }
            $request->file('logo')->move(public_path('uploads/brand'), 'logo.'.$extension);
        }

        Settings::first()->update($request->except(['_token','logo']));
        return Redirect::route('settings')->with('status', 'settings-updated');
    }
}

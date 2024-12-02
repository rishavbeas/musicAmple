<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');

// new-custom-admin-login
 Route::middleware('admin.guest')->group(function () {
Route::get('/admin/login', [App\Http\Controllers\Admin\AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin-login-custom',[App\Http\Controllers\Admin\AdminAuthController::class,'login'])->name('admin.login.custom');
});
// Page
Route::get('/pages/{id}', 'PageController@show')->name('pages.show');
// Profile
Route::get('/profile/{username}', 'UsersController@show')->name('profile.username');
// Playlist
Route::get('/playlists/{id}', 'PlaylistsController@showPlaylist')->name('playlists.show');
// Track
Route::get('/track/{id}', 'TracksController@detail')->name('tracks.detail');

Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::redirect('/', 'admin/dashboard');
    Route::post('logout/admin', [App\Http\Controllers\Admin\AdminAuthController::class, 'logout'])->name('admin.custom.logout');
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile', [ProfileController::class, 'updateImage'])->name('profile.image');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tracks
    Route::get('/tracks', 'TracksController@index')->name('tracks');
    Route::get('/tracks/new', 'TracksController@createTrack')->name('tracks.new');
    Route::get('/tracks/{id}/edit', 'TracksController@editTrack')->name('tracks.edit');
    Route::get('/tracks/{id}', 'TracksController@show')->name('tracks.show');
    Route::post('/tracks/new', 'TracksController@storeTrack');
    Route::post('/tracks/{id}/edit', 'TracksController@updateTrack');
    Route::post('/tracks/{id}/destroy', 'TracksController@destroyTrack')->name('tracks.destroy');
    Route::post('/tracks/{id}/unpublic', 'TracksController@unpublicTrack')->name('tracks.unpublic');
    Route::post('/tracks/{id}/public', 'TracksController@publicTrack')->name('tracks.public');
    // Artist
    Route::get('/artists', 'ArtistsController@index')->name('artists');
    Route::get('/artists/new', 'ArtistsController@createArtist')->name('artists.new');
    Route::get('/artists/{id}/edit', 'ArtistsController@editUser')->name('artists.edit');
    Route::get('/artists/{id}', 'ArtistsController@show')->name('artists.show');
    Route::post('/artists/new', 'ArtistsController@storeUser');
    Route::post('/artists/{id}/general', 'ArtistsController@updateGeneral')->name('artists.general');
    Route::post('/artists/{id}/social', 'ArtistsController@updateSocial')->name('artists.social');
    Route::post('/artists/{id}/profile', 'ArtistsController@updateProfile')->name('artists.profile');
    Route::post('/artists/{id}/destroy', 'ArtistsController@destroyUser')->name('artists.destroy');
    Route::post('/artists/{id}/suspend', 'ArtistsController@suspendUser')->name('artists.suspend');
    Route::post('/artists/{id}/restore', 'ArtistsController@restoreUser')->name('artists.restore');
    // Album
    Route::get('/albums', 'AlbumsController@index')->name('albums');
    Route::get('/albums/new', 'AlbumsController@createAlbum')->name('albums.new');
    Route::get('/albums/{id}/edit', 'AlbumsController@editAlbum')->name('albums.edit');
    Route::get('/albums/{id}', 'AlbumsController@show')->name('albums.show');
    Route::post('/albums/new', 'AlbumsController@storeAlbum');
    Route::post('/albums/{id}/edit', 'AlbumsController@updateAlbum');
    Route::post('/albums/{id}/destroy', 'AlbumsController@destroyAlbum')->name('albums.destroy');
    Route::post('/albums/{id}/unpublic', 'AlbumsController@unpublicAlbum')->name('albums.unpublic');
    Route::post('/albums/{id}/public', 'AlbumsController@publicAlbum')->name('albums.public');

    // Production
    Route::get('/productions', 'ProductionsController@index')->name('productions');
    Route::get('/productions/new', 'ProductionsController@createProduction')->name('productions.new');
    Route::get('/productions/{id}/edit', 'ProductionsController@editProduction')->name('productions.edit');
    Route::post('/productions/new', 'ProductionsController@storeProduction');
    Route::post('/productions/{id}/edit', 'ProductionsController@updateProduction');
    Route::post('/productions/{id}/destroy', 'ProductionsController@destroyProduction')->name('productions.destroy');
    Route::post('/productions/{id}/unpublic', 'ProductionsController@unpublicProduction')->name('productions.unpublic');
    Route::post('/productions/{id}/public', 'ProductionsController@publicProduction')->name('productions.public');

    // Playlist
    Route::get('/playlists', 'PlaylistsController@index')->name('playlists');
    Route::get('/playlists/new', 'PlaylistsController@createPlaylist')->name('playlists.new');
    Route::get('/playlists/{id}/edit', 'PlaylistsController@editPlaylist')->name('playlists.edit');
    Route::get('/playlists/tracks/autocomplete', 'PlaylistsController@tracksAutoComplete')->name('playlists.tracks.autocomplete');
    Route::post('/playlists/new', 'PlaylistsController@storePlaylist');
    Route::post('/playlists/{id}/edit', 'PlaylistsController@updatePlaylist');
    Route::post('/playlists/{id}/destroy', 'PlaylistsController@destroyPlaylist')->name('playlists.destroy');
    Route::post('/playlists/{id}/private', 'PlaylistsController@privatePlaylist')->name('playlists.private');
    Route::post('/playlists/{id}/public', 'PlaylistsController@publicPlaylist')->name('playlists.public');


    Route::get('/statistics', 'StatisticsController@index')->name('statistics');
    // User
    Route::get('/users', 'UsersController@index')->name('users');
    Route::get('/users/create', 'UsersController@create')->name('users.create');
    Route::get('/users/{id}/edit', 'UsersController@editUser')->name('users.edit');
    Route::post('/users/create', 'UsersController@store')->name('users.store');
    Route::post('/users/{id}/edit', 'UsersController@updateUser');
    Route::post('/users/{id}/destroy', 'UsersController@destroyUser')->name('users.destroy');
    Route::post('/users/{id}/suspend', 'UsersController@suspendUser')->name('users.suspend');
    Route::post('/users/{id}/restore', 'UsersController@restoreUser')->name('users.restore');

    // Page
    Route::get('/pages', 'PageController@index')->name('pages');
    Route::get('/pages/new', 'PageController@createPage')->name('pages.new');
    Route::get('/pages/{id}/edit', 'PageController@editPage')->name('pages.edit');
    Route::post('/pages/new', 'PageController@storePage');
    Route::post('/pages/{id}/edit', 'PageController@updatePage');
    Route::post('/pages/{id}/destroy', 'PageController@destroyPage')->name('pages.destroy');

    // Report
    Route::get('/reports', 'ReportController@index')->name('reports');
    Route::get('/reports/{id}', 'ReportController@show')->name('reports.show');
    Route::get('/reports/{id}/delete', 'ReportController@deleteReport')->name('reports.delete');
    Route::get('/reports/{id}/suspend', 'ReportController@suspendTrack')->name('reports.suspend');
    Route::get('/reports/{id}/restore', 'ReportController@restoreTrack')->name('reports.restore');
    Route::get('/reports/{id}/track', 'ReportController@destroyTrack')->name('reports.delete.track');

    // APP
    Route::get('/app', 'AppController@index')->name('app');
    Route::get('/app/new', 'AppController@createWidget')->name('app.new');
    Route::get('/app/playlists', 'AppController@playlists')->name('app.playlist');
    Route::get('/app/playlists/autocomplete', 'AppController@playlistsAutoComplete')->name('app.playlists.autocomplete');
    Route::get('/app/artists/autocomplete', 'AppController@artistsAutoComplete')->name('app.artists.autocomplete');
    Route::get('/app/albums/autocomplete', 'AppController@albumsAutoComplete')->name('app.albums.autocomplete');
    Route::get('/app/productions/autocomplete', 'AppController@productionsAutoComplete')->name('app.productions.autocomplete');
    Route::get('/app/{id}/edit', 'AppController@editWidget')->name('app.edit');
    Route::post('/app/new', 'AppController@storeWidget');
    Route::post('/app/{id}/edit', 'AppController@updateWidget');
    Route::post('/app/{id}/unpublic', 'AppController@unpublicWidget')->name('app.unpublic');
    Route::post('/app/{id}/public', 'AppController@publicWidget')->name('app.public');
    Route::post('/app/{id}/destroy', 'AppController@destroyWidget')->name('app.destroy');
    Route::post('/app/update-order', 'AppController@updateOrder');

    // Settings
    Route::get('/settings', 'SettingsController@index')->name('settings');
    Route::post('/settings', 'SettingsController@update');
});

// Install
Route::prefix('install')->group(function () {
    Route::middleware('install')->group(function () {
        Route::get('/', 'InstallController@index')->name('install');
        Route::get('/requirements', 'InstallController@requirements')->name('install.requirements');
        Route::get('/permissions', 'InstallController@permissions')->name('install.permissions');
        Route::get('/database', 'InstallController@database')->name('install.database');
        Route::get('/account', 'InstallController@account')->name('install.account');

        Route::post('/database', 'InstallController@storeConfig');
        Route::post('/account', 'InstallController@storeDatabase');
    });

    Route::get('/complete', 'InstallController@complete')->name('install.complete');
});
// Update
Route::prefix('update')->group(function () {
    Route::get('/', 'UpdateController@index')->name('update');
    Route::get('/overview', 'UpdateController@overview')->name('update.overview');
    Route::get('/complete', 'UpdateController@complete')->name('update.complete');

    Route::post('/overview', 'UpdateController@updateDatabase');
});
require __DIR__ . '/auth.php';

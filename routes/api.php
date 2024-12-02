<?php
namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login/google', 'socialLogin');
    Route::post('login', 'login');
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('account', [AuthController::class, 'account']);
    Route::get('account/playlists', [AuthController::class, 'playlists']);
    Route::get('account/likes', [AuthController::class, 'likes']);
    Route::get('account/subscriptions', [AuthController::class, 'subscriptions']);
    Route::get('account/subscribers', [AuthController::class, 'subscribers']);
    Route::put('account/general', [AuthController::class, 'updateGeneral']);
    Route::put('account/social', [AuthController::class, 'updateSocial']);
    Route::put('account/password', [AuthController::class, 'updatePassword']);
    Route::post('account/image', [AuthController::class, 'updateImage']);
    Route::post('account/cover', [AuthController::class, 'updateCover']);
    Route::post('account/check/subscribe/{id}', [AuthController::class, 'checkSubscribe']);
    Route::post('account/subscribe/{id}', [AuthController::class, 'subscribe']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::delete('account/delete', [AuthController::class, 'destroy']);
    //Playlist
    Route::get('playlists/check/{id}', [PlaylistsController::class, 'checkTrackInPlaylist']);
    Route::post('playlists/new', [PlaylistsController::class, 'store']);
    Route::post('playlists/add', [PlaylistsController::class, 'playlistEntry']);
    Route::post('playlists/update', [PlaylistsController::class, 'update']);
    Route::delete('playlists/delete/{id}', [PlaylistsController::class, 'destroy']);
    //Track
    Route::post('add/likes', [TracksController::class, 'addLikes']);
    Route::post('add/dislikes/{id}', [TracksController::class, 'disLikes']);
    Route::post('add/comments/{id}', [TracksController::class, 'addComment']);
    Route::post('add/report/{id}', [TracksController::class, 'addReport']);
    Route::post('check/likes/{id}', [TracksController::class, 'checkLikes']);
    Route::post('edit/comments/{id}', [TracksController::class, 'editComment']);
    Route::delete('delete/comments/{id}', [TracksController::class, 'deleteComment']);
    //Stream
    Route::get('stream', [StreamController::class, 'stream']);

});
Route::get('explorer', [HomeController::class, 'explorer']);
Route::get('/tracks/{filter}', [HomeController::class, 'index']);
//Artist
Route::get('/artists', [ArtistsController::class, 'index']);
Route::get('/artists/{id}', [ArtistsController::class, 'show']);
Route::get('/artists/tracks/{id}', [ArtistsController::class, 'tracks']);
// Route::post('/artists/tracks/{id}', [ArtistsController::class, 'tracks']);
Route::get('/artists/albums/{id}', [ArtistsController::class, 'albums']);
Route::get('/artists/subscribers/{id}', [ArtistsController::class, 'subscribers']);
//Album
Route::get('/albums', [AlbumsController::class, 'index']);
Route::get('/albums/{id}', [AlbumsController::class, 'show']);
//Production
Route::get('/productions', [ProductionsController::class, 'index']);
Route::get('/productions/{id}', [ProductionsController::class, 'show']);
//Search
Route::get('/search/tracks/{name}', [SearchController::class, 'tracks']);
Route::get('/search/artists/{name}', [SearchController::class, 'artists']);
Route::get('/search/albums/{name}', [SearchController::class, 'albums']);
Route::get('/search/playlists/{name}', [SearchController::class, 'playlists']);
Route::get('/search/users/{name}', [SearchController::class, 'users']);
Route::get('/search/suggestions/{name}', [SearchController::class, 'suggestions']);
//Playlist
Route::get('/playlists/{id}', [PlaylistsController::class, 'show']);
//Profile
Route::get('profile/playlists/{id}', [ProfileController::class, 'playlists']);
Route::get('profile/likes/{id}', [ProfileController::class, 'likes']);
Route::get('profile/subscriptions/{id}', [ProfileController::class, 'subscriptions']);
Route::get('profile/subscribers/{id}', [ProfileController::class, 'subscribers']);
//Track
Route::post('add/view/{id}', [TracksController::class, 'addView']);
Route::post('add/download/{id}', [TracksController::class, 'addDownload']);
Route::get('tracks/likes/{id}', [TracksController::class, 'likesFromTracks']);
Route::get('tracks/comments/{id}', [TracksController::class, 'loadComments']);
//Settings
Route::get('settings', [SettingsController::class, 'index']);

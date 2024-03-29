<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
	Route::get('/', array( 'as' => 'index', 'uses' => 'ArtistController@index' ) );
	Route::get('/home', array( 'as' => 'home', 'uses' => 'ArtistController@index' ) );

// Artist
	Route::model('artist', 'App\Models\Artist');
	Route::resource('artist', 'ArtistController');
	Route::get( '/artist/{artist}/delete', array( 'as' => 'artist.delete', 'uses' => 'ArtistController@delete' ) );

// Album
	Route::model('album', 'App\Models\Album');
	Route::resource('album', 'AlbumController');
	Route::get( '/album/{album}/delete', array( 'as' => 'album.delete', 'uses' => 'AlbumController@delete' ) );
	Route::post( '/album/save-order', array( 'as' => 'album.save-order', 'uses' => 'AlbumController@save_order' ) );

// Release
	Route::model('release', 'App\Models\Release');
	Route::resource('release', 'ReleaseController');
	Route::get( '/release/{release}/delete', array( 'as' => 'release.delete', 'uses' => 'ReleaseController@delete' ) );
	Route::get( '/release/{release}/export-id3', array( 'as' => 'release.export-id3', 'uses' => 'ReleaseController@export_id3' ) );
	Route::post( '/release/generate-catalog-num', array( 'as' => 'release.catalog-num', 'uses' => 'ReleaseController@generate_catalog_num' ) );

// Tracks
	Route::model('track', 'App\Models\Track');
	Route::get( '/track/{track}/delete', array( 'as' => 'track.delete', 'uses' => 'TrackController@delete' ) );
	Route::post( '/track/save-order', array( 'as' => 'track.save-order', 'uses' => 'TrackController@save_order' ) );
	Route::resource('track', 'TrackController');

// Audio
	Route::model('audio', 'App\Models\Audio');
	Route::get( '/audio/{audio}/delete/', array( 'as' => 'audio.delete', 'uses' => 'AudioController@delete' ) );
	Route::resource('audio', 'AudioController');

// Ecommerce
	Route::model('ecommerce', 'App\Models\Ecommerce');
	Route::get( '/ecommerce/{ecommerce}/delete', array( 'as' => 'ecommerce.delete', 'uses' => 'EcommerceController@delete' ) );
	Route::post( '/ecommerce/save-order', array( 'as' => 'ecommerce.save-order', 'uses' => 'EcommerceController@save_order' ) );
	Route::resource('ecommerce', 'EcommerceController');

// Songs
	Route::model('song', 'App\Models\Song');
	Route::get( '/song/{song}/delete', array( 'as' => 'song.delete', 'uses' => 'SongController@delete' ) );
	Route::get( '/song/{song}/lyrics', array( 'as' => 'song.lyrics', 'uses' => 'SongController@lyrics' ) );
	Route::resource('song', 'SongController');

// Recordings
	Route::model('recording', 'App\Models\Recording');
	Route::get( '/recording/{recording}/delete', array( 'as' => 'recording.delete', 'uses' => 'RecordingController@delete' ) );
	Route::post( '/recording/generate-isrc', array( 'as' => 'recording.isrc', 'uses' => 'RecordingController@generate_isrc' ) );
	Route::resource('recording', 'RecordingController');

// Profile
	Route::model('user', 'App\Models\User');
	Route::resource('user', 'UserController');
	Route::get( '/user/{user}/delete', array( 'as' => 'user.delete', 'uses' => 'UserController@delete' ) );
});

Auth::routes();

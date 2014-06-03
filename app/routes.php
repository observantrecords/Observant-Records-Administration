<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array( 'as' => 'home', 'before' => 'auth', 'uses' => 'ArtistController@index' ) );

// Artist
Route::model('artist', 'Artist');
Route::resource('artist', 'ArtistController');
Route::get( '/artist/{artist}/delete', array( 'as' => 'artist.delete', 'before' => 'auth', 'uses' => 'ArtistController@delete' ) );

// Album
Route::model('album', 'Album');
Route::resource('album', 'AlbumController');
Route::get( '/album/{album}/delete', array( 'as' => 'album.delete', 'before' => 'auth', 'uses' => 'AlbumController@delete' ) );
Route::post( '/album/save-order', array( 'as' => 'album.save-order', 'before' => 'auth|csrf', 'uses' => 'AlbumController@save_order' ) );

// Release
Route::model('release', 'Release');
Route::resource('release', 'ReleaseController');
Route::get( '/release/{release}/delete', array( 'as' => 'release.delete', 'before' => 'auth', 'uses' => 'ReleaseController@delete' ) );
Route::get( '/release/{release}/export-id3', array( 'as' => 'release.export-id3', 'before' => 'auth', 'uses' => 'ReleaseController@export_id3' ) );

// Tracks
Route::model('track', 'Track');
Route::resource('track', 'TrackController');
Route::get( '/track/{track}/delete', array( 'as' => 'track.delete', 'before' => 'auth', 'uses' => 'TrackController@delete' ) );
Route::post( '/track/save-order', array( 'as' => 'track.save-order', 'before' => 'auth|csrf', 'uses' => 'TrackController@save_order' ) );

// Audio
Route::model('audio', 'Audio');
Route::resource('audio', 'AudioController');
Route::get( '/audio/{audio}/delete/', array( 'as' => 'audio.delete', 'before' => 'auth', 'uses' => 'AudioController@delete' ) );

// Ecommerce
Route::model('ecommerce', 'Ecommerce');
Route::resource('ecommerce', 'EcommerceController');
Route::get( '/ecommerce/{ecommerce}/delete', array( 'as' => 'ecommerce.delete', 'before' => 'auth', 'uses' => 'EcommerceController@delete' ) );
Route::post( '/ecommerce/save-order', array( 'as' => 'ecommerce.save-order', 'before' => 'auth|csrf', 'uses' => 'EcommerceController@save_order' ) );

// Songs
Route::model('song', 'Song');
Route::resource('song', 'SongController');
Route::get( '/song/{song}/delete', array( 'as' => 'song.delete', 'before' => 'auth', 'uses' => 'SongController@delete' ) );
Route::get( '/song/{song}/lyrics', array( 'as' => 'song.lyrics', 'before' => 'auth', 'uses' => 'SongController@lyrics' ) );

// Recordings
Route::model('recording', 'Recording');
Route::resource('recording', 'RecordingController');
Route::get( '/recording/{recording}/delete', array( 'as' => 'recording.delete', 'before' => 'auth', 'uses' => 'RecordingController@delete' ) );
Route::post( '/recording/generate-isrc', array( 'as' => 'recording.isrc', 'before' => 'auth', 'uses' => 'RecordingController@generate_isrc' ) );

// Authentication
Route::get( '/login', array( 'as' => 'auth.login', 'uses' => 'AuthController@login') );
Route::get( '/logout', array( 'as' => 'auth.logout', 'uses' => 'AuthController@sign_out' ) );
Route::post( '/signin', array( 'as' => 'auth.signin', 'uses' => 'AuthController@sign_in' ) );
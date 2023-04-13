<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\ArtistResource;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\ReleaseResource;
use App\Http\Resources\TrackResource;
use App\Http\Resources\SongResource;
use App\Http\Resources\EcommerceResource;
use App\Http\Resources\AlbumFormatResource;
use App\Http\Resources\ReleaseFormatResource;
use App\Http\Resources\ArtistCollection;
use App\Http\Resources\AlbumCollection;
use App\Http\Resources\ReleaseCollection;
use App\Http\Resources\TrackCollection;
use App\Http\Resources\SongCollection;
use App\Http\Resources\EcommerceCollection;
use App\Http\Resources\AlbumFormatCollection;
use App\Http\Resources\ReleaseFormatCollection;
use App\Models\Artist;
use App\Models\Album;
use App\Models\Release;
use App\Models\Track;
use App\Models\Song;
use App\Models\Ecommerce;
use App\Models\AlbumFormat;
use App\Models\ReleaseFormat;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function() {
    Route::get('/artists/', function () {
        return new ArtistCollection(Artist::all());
    });
    Route::get('/artist/{id}', function (string $id) {
        return new ArtistResource(Artist::findOrFail($id));
    } );
    Route::get('/albums/', function () {
        return new AlbumCollection(Album::all());
    });
    Route::get('/album/{id}', function (string $id) {
        return new AlbumResource(Album::findOrFail($id));
    } );
    Route::get('/album-format/', function () {
        return new AlbumFormatCollection(AlbumFormat::all());
    });
    Route::get('/album-format/{id}', function (string $id) {
        return new AlbumFormatResource(AlbumFormat::findOrFail($id));
    } );
    Route::get('/releases/', function () {
        return new ReleaseCollection(Release::all());
    });
    Route::get('/release/{id}', function (string $id) {
        return new ReleaseResource(Release::findOrFail($id));
    } );
    Route::get('/release-format/', function () {
        return new ReleaseFormatCollection(ReleaseFormat::all());
    });
    Route::get('/release-format/{id}', function (string $id) {
        return new ReleaseFormatResource(ReleaseFormat::findOrFail($id));
    } );
    Route::get('/tracks/', function () {
        return new TrackCollection(Track::all());
    });
    Route::get('/track/{id}', function (string $id) {
        return new TrackResource(Track::findOrFail($id));
    } );
    Route::get('/songs/', function () {
        return new SongCollection(Song::all());
    });
    Route::get('/song/{id}', function (string $id) {
        return new SongResource(Song::findOrFail($id));
    } );
    Route::get('/ecommerce/', function () {
        return new EcommerceCollection(Ecommerce::all());
    });
    Route::get('/ecommerce/{id}', function (string $id) {
        return new EcommerceResource(Ecommerce::findOrFail($id));
    } );
});
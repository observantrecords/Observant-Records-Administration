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
    Route::get('/artist/{id}/albums', function (string $id, Request $request) {

        $album = new Album();

        if ($request->hasAny(['orderBy', 'order', 'visible', 'format'])) {
            $orderBy = $request->query('orderBy', 'album_order');
            $order = $request->query('order', 'asc');
            $visible = $request->query('visible', 1);
            $format = $request->query('format');

            $where = [
                'album_is_visible' => $visible,
            ];
            if (!empty($format)) {
                $where['album_format_id'] = $format;
            }

            return new AlbumCollection($album->where($where)->orderBy($orderBy, $order)->get());
        }

        return new ArtistResource(Artist::with('albums')->findOrFail($id));
    } );
    Route::get('/albums/', function (Request $request) {

         if ($request->hasAny(['orderBy', 'order', 'visible', 'format'])) {
             $orderBy = $request->query('orderBy', 'album_order');
             $order = $request->query('order', 'asc');
             $visible = $request->query('visible', 1);
             $format = $request->query('format');

             $where = [
                 'album_is_visible' => $visible,
             ];
             if (!empty($format)) {
                 $where['album_format_id'] = $format;
             }

             return new AlbumCollection(Album::where($where)->orderBy($orderBy, $order)->get());
         }

        return new AlbumCollection(Album::all());
    });
    Route::get('/album/{id}', function (string $id) {
        return new AlbumResource(Album::with('primary_release.tracks', 'primary_release.ecommerce', 'releases')->findOrFail($id));
    } );
    Route::get('/album-format/', function () {
        return new AlbumFormatCollection(AlbumFormat::all());
    });
    Route::get('/album-format/{id}', function (string $id) {
        return new AlbumFormatResource(AlbumFormat::findOrFail($id));
    } );
    Route::get('/releases/', function (Request $request) {

        if ($request->hasAny(['orderBy', 'order', 'visible', 'format'])) {
            $orderBy = $request->query('orderBy', 'release_release_date');
            $order = $request->query('order', 'asc');
            $visible = $request->query('visible', 1);
            $format = $request->query('format');

            $where = [
                'release_is_visible' => $visible,
            ];
            if (!empty($format)) {
                $where['release_format_id'] = $format;
            }

            return new ReleaseCollection(Release::where($where)->orderBy($orderBy, $order)->get());
        }

        return new ReleaseCollection(Release::all());
    });
    Route::get('/release/{id}', function (string $id) {
        return new ReleaseResource(Release::with('tracks', 'ecommerce')->findOrFail($id));
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
    Route::get('/songs/', function (Request $request) {

        if ($request->hasAny(['orderBy', 'order', 'artist'])) {

            $song = new Song();

            $orderBy = $request->query('orderBy', 'song_title');
            $order = $request->query('order', 'asc');
            $artist = $request->query('artist');

            if (!empty($artist)) {
                $where = [
                    'song_primary_artist_id' => $artist,
                ];
                return new SongCollection(Song::where($where)->orderBy($orderBy, $order)->get());
            }

            return new SongCollection(Song::orderBy($orderBy, $order)->get());
        }

        return new SongCollection(Song::all());
    });
    Route::get('/song/{id}', function (string $id) {
        return new SongResource(Song::findOrFail($id));
    } );
    Route::get('/ecommerce/', function (Request $request) {

        if ($request->hasAny(['orderBy', 'order', 'label'])) {
            $orderBy = $request->query('orderBy', 'ecommerce_list_order');
            $order = $request->query('order', 'asc');
            $label = $request->query('label');

            if (!empty($label)) {
                $where = [
                    'ecommerce_label' => $label,
                ];

                return new EcommerceCollection(Ecommerce::where($where)->orderBy($orderBy, $order)->get());
            }

            return new EcommerceCollection(Ecommerce::orderBy($orderBy, $order)->get());
        }

        return new EcommerceCollection(Ecommerce::all());
    });
    Route::get('/ecommerce/{id}', function (string $id) {
        return new EcommerceResource(Ecommerce::findOrFail($id));
    } );
});
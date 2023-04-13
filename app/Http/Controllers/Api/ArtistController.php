<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artists = Artist::orderBy('artist_last_name')->get();

        return Response::json($artists);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $artist = json_decode($id);

        $album_parameters = \Illuminate\Support\Facades\Request::collect()->filter(function ($value, $key) {
            return (strpos($key, 'album_') === 0);
        })->toArray();
        $where = ['album_artist_id' => $artist->artist_id];
        if (!empty($album_parameters)) {
            $where = array_merge($where, $album_parameters);
        }

        $albums = Album::with(['primary_release.ecommerce', 'primary_release.tracks.song', 'format'])->where($where)->get();

        $artist->artist_api_path = '/artist/' . $artist->artist_id;
        $artist->albums = $albums->toArray();

        return Response::json($artist);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Release;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artist_id = \Illuminate\Support\Facades\Request::get('artist');
        if (!empty($artist_id)) {
            $albums = Album::where('album_artist_id', $artist_id)->orderBy('album_title')->get();
        } else {
            $albums = Album::orderBy('album_title')->get();
        }
        $albums->load('artist');

        return Response::json($albums);
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
        $album = json_decode($id);

        $album->primary_release = Release::with(['tracks.song','format'])->where('release_album_id', $album->album_id)->get()->toArray();

        return Response::json($album);
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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\AlbumFormat;
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

        $parameters = \Illuminate\Support\Facades\Request::collect()->filter(function ($value, $key) {
            return (strpos($key, 'album_') === 0);
        })->toArray();

        if (!empty($parameters)) {
            $albums = Album::where($parameters)->orderBy('album_title')->get();
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

        $album->primary_release = Release::with(['ecommerce', 'tracks.song', 'format'])->where('release_id', $album->album_primary_release_id)->first();
        $album->format = AlbumFormat::where('format_id', $album->album_format_id)->first();

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

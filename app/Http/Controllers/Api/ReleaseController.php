<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Release;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $album_id = \Illuminate\Support\Facades\Request::get('album');
        if (!empty($album_id)) {
            $releases = Release::where('release_album_id', $album_id)->orderBy('release_catalog_num')->get();
        } else {
            $releases = Release::orderBy('release_catalog_num')->get();
        }
        $releases->load('album.artist');

        return Response::json($releases);
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
        $release = json_decode($id);

        $track_model = new Track();
        $release->tracks = $track_model->findReleaseTracks($release->release_id);

        return Response::json($release);
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

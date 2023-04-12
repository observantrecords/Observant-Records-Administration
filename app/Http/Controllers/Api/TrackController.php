<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Release;
use App\Models\Song;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TrackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $release_id = \Illuminate\Support\Facades\Request::get('release');

        if (!empty($release_id)) {
            $tracks = Track::where('track_release_id', $release_id)->orderBy('track_disc_num')->orderBy('track_track_num')->get();
        } else {
            $tracks = Track::orderBy('track_release_id')->orderBy('track_disc_num')->orderBy('track_track_num')->get();
        }
        $tracks->load('release', 'song');


        return Response::json($tracks);
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
        $track = json_decode($id);

        $track->release = Release::with('album.artist')->where('release_id', $track->track_release_id)->get();
        $track->song = Song::where('song_id', $track->track_song_id)->get();

        return Response::json($track);
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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ecommerce;
use App\Models\Release;
use App\Models\ReleaseFormat;
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
        $parameters = \Illuminate\Support\Facades\Request::collect()->filter(function ($value, $key) {
            return (strpos($key, 'release_') === 0);
        })->toArray();

        if (!empty($album_id)) {
            $releases = Release::where($parameters)->orderBy('release_catalog_num')->get();
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
        $release->ecommerce = Ecommerce::where('ecommerce_release_id', $release->release_id)->get();
        $release->tracks = $track_model->findReleaseTracks($release->release_id);
        $release->format = ReleaseFormat::where('format_id', $release->release_format_id)->first();

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

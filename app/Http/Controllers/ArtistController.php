<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Song;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;

class ArtistController extends Controller {

	private $layout_variables = array();

	public function __construct() {

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$artists = Artist::orderBy('artist_last_name')->get();

		$method_variables = array(
			'artists' => $artists,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('artist.index', $data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$artist = new Artist;

		$method_variables = array(
			'artist' => $artist,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('artist.create', $data);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$artist = new Artist;

		$fields = $artist->getFillable();

		foreach ($fields as $field) {
			$artist->{$field} = Request::get($field);
		}

		$result = $artist->save();

		if ($result !== false) {
			return Redirect::route('artist.show', $artist->artist_id)->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('artist.index')->with('error', 'Your changes were not saved.');
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$method_variables = array(
			'artist' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return view('artist.show', $data);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$method_variables = array(
			'artist' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('artist.edit', $data);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

		$fields = $id->getFillable();

		foreach ($fields as $field) {
			$id->{$field} = Request::get($field);
		}

		$result = $id->save();

		if ($result !== false) {
			return Redirect::route('artist.show', $id->artist_id)->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('artist.index')->with('error', 'Your changes were not saved.');
		}
	}

	/**
	 * Show the form for deleting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id) {

		$method_variables = array(
			'artist' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('artist.delete', $data);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$confirm = (boolean) Request::get('confirm');
		$artist_display_name = $id->artist_display_name;

		if ($confirm === true) {
			// Gather albums, releases, tracks, audio, and ecommerce.
			if (count($id->albums) > 0) {
				foreach ($id->albums as $album) {
					if (count($album->releases) > 0) {
						foreach ($album->releases as $release) {
							if (count($release->tracks) > 0) {
								foreach ($release->tracks as $track) {
									// Remove audio.
									if (count($track->recording->audio) > 0) {
										foreach ($track->recording->audio as $audio) {
											$audio->delete();
										}
									}

									// Remove recording.
									$track->recording()->delete();

									// Remove ecommerce and content by tracks.
									$track->ecommerce()->delete();
								}

								// Remove tracks.
								$release->tracks()->delete();

								// Remove ecommerce.
								$release->ecommerce()->delete();
							}
						}
					}

					// Remove releases.
					$album->releases()->delete();
				}
			}

			// Remove albums.
			$id->albums()->delete();

			// Remove artist.
			$artist_id = $id->artist_id;
			$id->delete();

			// Remove primary artist ID from songs, but do not remove songs.
			$songs = Song::where('song_primary_artist_id', $artist_id)->update(array( 'song_primary_artist_id' => 0 ));

			return Redirect::route('artist.index')->with('message', $artist_display_name . ' was deleted.');
		} else {
			return Redirect::route('artist.show', $id->artist_id)->with('error', $artist_display_name . ' was not deleted.');
		}
	}


}

<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Song;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class SongController extends Controller {

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
		$artist_id = Input::get('artist');

		if (!empty($artist_id)) {
			$songs = Song::where('song_primary_artist_id', $artist_id)->orderBy('song_title')->get();
			$artist = Artist::find($artist_id);
		} else {
			$songs = Song::orderBy('song_title')->get();
			$artist = new Artist;
		}

		$method_variables = array(
			'songs' => $songs,
			'artist' => $artist,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('song.index', $data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$song = new Song;

		$artist_id = Input::get('artist');

		if (!empty($artist_id)) {
			$song->song_primary_artist_id = $artist_id;
			$song->artist = Artist::find($artist_id);
		}

		$artists = $this->build_artist_options();

		$method_variables = array(
			'song' => $song,
			'artists' => $artists,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('song.create', $data);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$song = new Song;

		$fields = $song->getFillable();

		foreach ($fields as $field) {
			$song->{$field} = Input::get($field);
		}

		$result = $song->save();

		if ($result !== false) {
			return Redirect::route('song.show', array('id' => $song->song_id))->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('song.index', array('artist' => $song->song_primary_artist_id) )->with('error', 'Your changes were not saved.');
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
			'song' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('song.show', $data);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$artists = $this->build_artist_options();

		$method_variables = array(
			'song' => $id,
			'artists' => $artists,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('song.edit', $data);
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
			$id->{$field} = Input::get($field);
		}

		$result = $id->save();

		if ($result !== false) {
			return Redirect::route('song.show', array('id' => $id->song_id))->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('song.index', array('artist' => $id->song_primary_artist_id) )->with('error', 'Your changes were not saved.');
		}
	}

	public function delete($id) {

		$method_variables = array(
			'song' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('song.delete', $data);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$confirm = (boolean) Input::get('confirm');
		$song_title = $id->song_title;
		$artist_id = $id->song_primary_artist_id;

		if ($confirm === true) {
			// Remove recordings.
			$id->recordings()->delete();

			// Remove tracks.
			$id->tracks()->delete();

			// Remove song.
			$id->delete();
			return Redirect::route('song.index', array('artist' => $artist_id  ))->with('message', $song_title . ' was deleted.');
		} else {
			return Redirect::route('song.show', array('id' => $id->song_id))->with('error', $song_title . ' was not deleted.');
		}

	}

	private function build_artist_options() {
		$artists = Artist::orderBy('artist_display_name')->pluck('artist_display_name', 'artist_id');
		$artists = array(0 => '&nbsp;') + $artists->toArray();

		return $artists;
	}

}

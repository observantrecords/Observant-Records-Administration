<?php

class RecordingController extends \BaseController {

	private $layout_variables = array();

	public function __construct() {
		global $config_url_base;

		$this->layout_variables = array(
			'config_url_base' => $config_url_base,
		);

		$this->beforeFilter('auth');

		$this->beforeFilter('csrf', array( 'only' => array( 'store', 'update', 'destroy' ) ) );
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
			$artist = Artist::find($artist_id);
			$recordings = Recording::where('recording_artist_id', $artist_id)->orderBy('recording_isrc_num')->get();
		} else {
			$artist = new Artist;
			$recordings = Recording::orderBy('recording_isrc_num')->get();
		}
		$recordings->load('song');

		$recording_list = $recordings->lists('recording_isrc_num', 'recording_id');
		foreach ($recording_list as $r => $recording) {
			$song_title = (!empty($recordings->find($r)->song->song_title)) ? $recordings->find($r)->song->song_title : 'TBD';
			$recording_list[$r] = $recording . ' ('. $song_title . ')';
		}
		$recording_list = array(0 => '&nbsp;') + $recording_list;

		$method_variables = array(
			'recordings' => $recording_list,
			'artist' => $artist,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('recording.index', $data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$recording = new Recording;

		$artist_id = Input::get('artist');
		if (!empty($artist_id)) {
			$recording->recording_artist_id = $artist_id;
			$recording->artist = Artist::find($artist_id);
		}

		$artists = Artist::orderBy('artist_last_name')->lists('artist_display_name', 'artist_id');
		$artists = array(0 => '&nbsp;') + $artists;

		$songs = Song::orderBy('song_title')->lists('song_title', 'song_id');
		$songs = array(0 => '&nbsp;') + $songs;

		$method_variables = array(
			'recording' => $recording,
			'artists' => $artists,
			'songs' => $songs,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('recording.create', $data);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$recording = new Recording;

		$fields = $recording->getFillable();

		foreach ($fields as $field) {
			$recording->{$field} = Input::get($field);
		}

		$result = $recording->save();

		if ($result !== false) {
			return Redirect::route('recording.show', array('id' => $recording->recording_id))->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('recording.index', array('artist' => $recording->recording_artist_id))->with('error', 'Your changes were not saved.');
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
			'recording' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('recording.show', $data);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$artists = Artist::orderBy('artist_last_name')->lists('artist_display_name', 'artist_id');
		$artists = array(0 => '&nbsp;') + $artists;

		$songs = Song::orderBy('song_title')->lists('song_title', 'song_id');
		$songs = array(0 => '&nbsp;') + $songs;

		$method_variables = array(
			'recording' => $id,
			'artists' => $artists,
			'songs' => $songs,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('recording.edit', $data);
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

		$recording_isrc_num = Input::get('recording_isrc_num');
		if (!empty($recording_isrc_num)) {
			$isrc = RecordingISRC::where('isrc_code', $recording_isrc_num)->first();
			$isrc->isrc_recording_id = $id->recording_id;
			$isrc->save();
		}

		$result = $id->save();

		if ($result !== false) {
			return Redirect::route('recording.show', array('id' => $id->recording_id))->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('recording.index', array('artist' => $id->recording_artist_id))->with('error', 'Your changes were not saved.');
		}
	}


	public function delete($id) {

		$method_variables = array(
			'recording' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('recording.delete', $data);
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
		$recording_isrc_num = $id->recording_isrc_num;

		if ($confirm === true) {
			// Remove audio.
			$id->audio()->delete();

			// Remove ISRC.
			$id->isrc()->delete();

			// Remove recording.
			$id->delete();
			return Redirect::route('recording.index', array('artist' => $id->recording_artist_id) )->with('message', $recording_isrc_num . ' was deleted.');
		} else {
			return Redirect::route('recording.show', array('id' => $id->recording_id  ))->with('error', $recording_isrc_num . ' was not deleted.');
		}
	}

	public function generate_isrc() {
		$isrc = new RecordingISRC;
		$recording_isrc_code = (object) array('isrc_code' => $isrc->generate_code());
		echo json_encode($recording_isrc_code);
	}

}

<?php

class AudioController extends \BaseController {

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
		$recording_id = Input::get('recording');

		if (!empty($recording_id)) {
			$recording = Recording::find($recording_id);
			$audio_files = Audio::where('audio_recording_id', $recording_id)->orderBy('audio_file_name')->get();
		} else {
			$recording = new Recording;
			$audio_files = Audio::orderBy('audio_file_name')->get();
		}
		$audio_files->load('recording');

		$method_variables = array(
			'audio_files' => $audio_files,
			'recording' => $recording,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('audio.index', $data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$audio = new Audio;

		$recording_id = Input::get('recording');

		if (!empty($recording_id)) {
			$audio->audio_recording_id = $recording_id;
			$audio->recording = Recording::find($recording_id);

			$recording_songs = Recording::with('song')->with('artist')->where('recording_artist_id', $audio->recording->artist->artist_id)->orderBy('recording_isrc_num')->get();

			$s3_directories = $this->list_folders($audio->recording->artist->artist_alias);
		} else {
			$recording_songs = Recording::with('song')->with('artist')->orderBy('recording_isrc_num')->get();

			$s3_directories = $this->list_folders();
		}

		$recordings = $recording_songs->lists('recording_isrc_num', 'recording_id');
		foreach ($recordings as $r => $recording) {
			$recordings[$r] = empty($recording) ? 'ISRC no. not set' : $recording;
			$song_title = !empty($recording_songs->find($r)->song->song_title) ? $recording_songs->find($r)->song->song_title : 'TBD';
			$recordings[$r] .= ' (' . $song_title . ')';
		}

		$recordings = array(0 => '&nbsp;') + $recordings;

		foreach ($s3_directories as $i => $s3_directory) {
			$s3_directories[$i] = '/' . $s3_directory;
		}

		$method_variables = array(
			'audio' => $audio,
			'recordings' => $recordings,
			'recordings_json' => $recording_songs->toJSON(),
			's3_directories' => json_encode($s3_directories),
			'original_audio_id' => null,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('audio.create', $data);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$audio = new Audio;

		$fields = $audio->getFillable();

		foreach ($fields as $field) {
			$audio->{$field} = Input::get($field);
		}

		$result = $audio->save();

		if ($result !== false) {
			return Redirect::route('audio.show', array('id' => $audio->audio_id))->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('audio.index')->with('error', 'Your changes were not saved.');
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
			'audio' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('audio.show', $data);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$audio_files = Audio::where('audio_recording_id', $id->audio_recording_id)->orderBy('audio_file_name')->get();

		$recording_songs = Recording::with('song')->with('artist')->where('recording_artist_id', $id->recording->artist->artist_id)->orderBy('recording_isrc_num')->get();
		$recordings = $recording_songs->lists('recording_isrc_num', 'recording_id');
		foreach ($recordings as $r => $recording) {
			$recordings[$r] = empty($recording) ? 'ISRC no. not set' : $recording;
			$recordings[$r] .= ' (' . $recording_songs->find($r)->song->song_title . ')';
		}

		$recordings = array(0 => '&nbsp;') + $recordings;

		$s3_directories = $this->list_folders($id->recording->artist->artist_alias);

		$method_variables = array(
			'audio' => $id,
			'audio_files' => $audio_files,
			'recordings' => $recordings,
			's3_directories' => json_encode($s3_directories),
			'original_audio_id' => null,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('audio.edit', $data);
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
			return Redirect::route('audio.show', array('id' => $id->audio_id))->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('recording.show', array('id' => $id->audio_recording_id))->with('error', 'Your changes were not saved.');
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
			'audio' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('audio.delete', $data);
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
		$audio_file_name = $id->audio_file_name;
		$recording_id = $id->audio_recording_id;

		if ($confirm === true) {
			$id->delete();
			return Redirect::route('recording.show', array( 'id' => $recording_id ))->with('message', $audio_file_name . ' was deleted.');
		} else {
			return Redirect::route('audio.show', array('id' => $id->audio_id))->with('error', $audio_file_name . ' was not deleted.');
		}
	}

	private function list_folders($artist_alias = null) {
		try {
			$params = array(
				'key' => ACCESS_KEY_ID,
				'secret' => SECRET_ACCESS_KEY,
			);

			$s3 = Aws\S3\S3Client::factory($params);

			$prefix = 'artists/';
			if (!empty($artist_alias)) {
				$prefix .= $artist_alias;
			}
			$directories = array();

			$args = array(
				'Bucket' => 'observantrecords',
				'Prefix' => $prefix,
			);
			$results = $s3->getIterator('ListObjects', $args);

			foreach ($results as $result) {
				$dirname = '/' . dirname($result['Key']);
				if (array_search($dirname, $directories) === false) {
					$directories[] = $dirname;
				}
			}
			return $directories;
		} catch (Exception $ex) {

		}
	}
}

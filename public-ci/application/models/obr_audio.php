<?php

/**
 * Obr_Audio
 * 
 * Obr_Audio is a model for Observant Records audio files.
 *
 * @author Greg Bueno
 */

class Obr_Audio extends MY_Model {
	
	public $_table = 'ep4_audio';
	public $primary_key = 'audio_id';
	public $belongs_to = array(
		'recording' => array(
			'model' => 'Obr_Recording',
			'primary_key' => 'audio_recording_id',
		),
	);
	public $has_many = array(
		'logs' => array(
			'model' => 'Obr_Audio_Log',
			'primary_key' => 'log_audio_id',
		),
	);
	
	protected $soft_delete = true;
	protected $soft_delete_key = 'audio_deleted';
	
	public function __construct($params = null) {
		parent::__construct($params);
	}
	
	public function retrieve_by_artist_id($artist_id) {
		$this->_database->join('ep4_songs', 'audio_song_id=song_id', 'left outer');
		$this->_database->order_by('song_title, audio_mp3_file_path, audio_mp3_file_name');
		$this->_database->where('audio_artist_id', $artist_id);
		$result = $this->get_all();
		return $result;
	}
}

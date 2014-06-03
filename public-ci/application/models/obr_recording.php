<?php

/**
 * Obr_Audio_Map
 * 
 * Obr_Audio_Map is a model for mapping audio files with Observant Records tracks.
 * This model is deprecated since audio now have a one-to-many relationship
 * with tracks.
 *
 * @author Greg Bueno
 */

class Obr_Recording extends MY_Model {
	
	public $_table = 'ep4_recordings';
	public $primary_key = 'recording_id';
	public $belongs_to = array(
		'song' => array(
			'model' => 'Obr_Song',
			'primary_key' => 'recording_song_id',
		),
		'artist' => array(
			'model' => 'Obr_Artist',
			'primary_key' => 'recording_artist_id',
		),
	);
	public $has_many = array(
		'track' => array(
			'model' => 'Obr_Track',
			'primary_key' => 'track_recording_id',
		),
		'audio' => array(
			'model' => 'Obr_Audio',
			'primary_key' => 'audio_recording_id',
		),
	);
	
	protected $soft_delete = true;
	protected $soft_delete_key = 'recording_deleted';
	
	public function __construct($params = null) {
		parent::__construct($params);
	}
	
}

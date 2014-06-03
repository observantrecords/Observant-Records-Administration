<?php

/**
 * Obr_Track
 * 
 * Obr_Track is a model for Observant Records album tracks.
 *
 * @author Greg Bueno
 */

class Obr_Track extends MY_Model {
	
	public $_table = 'ep4_tracks';
	public $primary_key = 'track_id';
	public $belongs_to = array(
		'release' => array(
			'model' => 'Obr_Release',
			'primary_key' => 'track_release_id',
		),
		'song' => array(
			'model' => 'Obr_Song',
			'primary_key' => 'track_song_id',
		),
		'recording' => array(
			'model' => 'Obr_Recording',
			'primary_key' => 'track_recording_id',
		),
	);
	protected $soft_delete = true;
	protected $soft_delete_key = 'track_deleted';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function retrieve_by_release_id($release_id) {
		$this->order_by('track_disc_num, track_track_num');
		$result = $this->get_many_by('track_release_id', $release_id);
		return $result;
	}
}

?>

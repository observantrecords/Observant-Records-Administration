<?php

/**
 * ep4_song
 *
 * ep4_song is a model of an Observant Records artist song.
 * 
 * @author Greg Bueno
 */

class Obr_Song extends MY_Model {
	
	public $_table = 'ep4_songs';
	public $primary_key = 'song_id';
	public $belongs_to = array(
		'artist' => array(
			'model' => 'Obr_Artist',
			'primary_key' => 'song_primary_artist_id',
		),
	);
	public $has_many = array(
		'recordings' => array(
			'model' => 'Obr_Recording',
			'primary_key' => 'recording_song_id',
		),
		'tracks' => array(
			'model' => 'Obr_Track',
			'primary_key' => 'track_song_id',
		),
	);
	protected $soft_delete = true;
	protected $soft_delete_key = 'song_deleted';
	
	public function __construct() {
		parent::__construct();
	}
}

?>

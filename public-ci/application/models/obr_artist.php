<?php

/**
 * Obr_Artist
 * 
 * Obr_Artist is a model for an Observant Records artist.
 *
 * @author Greg Bueno
 */

class Obr_Artist extends MY_Model {
	
	public $_table = 'ep4_artists';
	public $primary_key = 'artist_id';
	public $has_many = array(
		'albums' => array(
			'model' => 'Obr_Album',
			'primary_key' => 'album_artist_id',
		),
		'song' => array(
			'model' => 'Obr_Song',
			'primary_key' => 'song_primary_artist_id',
		),
		'recording' => array(
			'model' => 'Obr_Recording',
			'primary_key' => 'recording_artist_id',
		),
	);
	protected $soft_delete = true;
	protected $soft_delete_key = 'artist_deleted';

	public function __construct() {
		parent::__construct();
	}

}

?>

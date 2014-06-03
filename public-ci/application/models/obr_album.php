<?php

/**
 * Obr_Album
 * 
 * Obr_Album is a model for Observant Records albums.
 *
 * @author Greg Bueno
 */

class Obr_Album extends MY_Model {

	public $_table = 'ep4_albums';
	public $primary_key = 'album_id';
	public $belongs_to = array(
		'artist' => array(
			'model' => 'Obr_Artist',
			'primary_key' => 'album_artist_id',
		),
		'format' => array(
			'model' => 'Obr_Album_Format',
			'primary_key' => 'album_format_id',
		),
		'primary_release' => array(
			'model' => 'Obr_Release',
			'primary_key' => 'album_primary_release_id',
		),
	);
	public $has_many = array(
		'releases' => array(
			'model' => 'Obr_Release',
			'primary_key' => 'release_album_id',
		), 
	);
	protected $soft_delete = true;
	protected $soft_delete_key = 'album_deleted';
	
	public function __construct($params = null) {
		parent::__construct($params);
	}

	public function retrieve_by_artist_id($artist_id) {
		$this->_database->order_by('album_order, album_release_date');
		$this->_database->where('album_artist_id', $artist_id);
		$rsAlbums = $this->get_all();
		return $rsAlbums;
	}
}

?>

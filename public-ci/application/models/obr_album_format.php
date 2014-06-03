<?php

/**
 * Obr_Album_Format
 *
 * Obr_Album_Format is a model for album formats.
 * 
 * @author Greg Bueno
 */

class Obr_Album_Format extends MY_Model {
	
	public $_table = 'ep4_albums_formats';
	public $primary_key = 'format_id';
	public $has_many = array(
		'albums' => array(
			'model' => 'Obr_Album',
			'primary_key' => 'album_format_id',
		),
	);
	protected $soft_delete = true;
	protected $soft_delete_key = 'format_deleted';
	
	public function __construct() {
		parent::__construct();
	}
}

?>

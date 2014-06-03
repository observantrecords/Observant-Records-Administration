<?php

/**
 * Obr_Album_Format
 *
 * @author Greg Bueno
 */

class Obr_Release_Format extends MY_Model {
	
	public $_table = 'ep4_albums_releases_formats';
	public $primary_key = 'format_id';
	public $has_many = array(
		'releases' => array(
			'model' => 'Obr_Release',
			'primary_key' => 'release_format_id',
		),
	);
	protected $soft_delete = true;
	protected $soft_delete_key = 'format_deleted';
	
	
	public function __construct() {
		parent::__construct();
	}
}

?>

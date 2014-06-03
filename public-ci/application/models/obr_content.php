<?php

/**
 * Obr_Content
 * 
 * Obr_Content is a model for content relationships between Observant Records
 * and Movable Type.
 *
 * @author Greg Bueno
 */
class Obr_Content extends MY_Model {
	
	public $_table = 'ep4_content';
	public $primary_key = 'content_id';
	public $belongs_to = array(
		'releases' => array(
			'model' => 'Obr_Release',
			'primary_key' => 'content_release_id',
		),
		'tracks' => array(
			'model' => 'Obr_Track', 
			'primary_key' => 'content_track_id',
		),
	);
	protected $soft_delete = true;
	protected $soft_delete_key = 'content_deleted';
	
	public function __construct() {
		parent::__construct();
	}
}

?>

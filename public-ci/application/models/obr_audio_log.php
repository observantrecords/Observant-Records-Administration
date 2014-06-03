<?php

/**
 * Obr_Audio_Log
 *
 * Obr_Audio_Log is a model for logging audio traffic.
 * 
 * @author Greg Bueno
 */

class Obr_Audio_Log extends MY_Model {
	
	public $_table = 'ep4_audio_log';
	public $primary_key = 'log_id';
	public $belongs_to = array(
		'audio' => array(
			'model' => 'Obr_Audio',
			'primary_key' => 'log_audio_id',
		),
	);
	protected $soft_delete = true;
	protected $soft_delete_key = 'log_deleted';
	
	public function __construct() {
		parent::__construct();
	}
}

?>

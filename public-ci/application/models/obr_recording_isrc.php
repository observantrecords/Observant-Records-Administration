<?php

/**
 * Obr_Recording_Isrc
 * 
 * Obr_Recording_Isrc maps ISRC codes with recordings. The model enforces uniqueness
 * of the ISRC code and its relationship to an audio track.
 *
 * @author Greg Bueno
 */

class Obr_Recording_Isrc extends MY_Model {
	
	public $_table = 'ep4_recordings_isrc';
	public $primary_key = 'isrc_id';
	public $belongs_to = array(
		'recording' => array(
			'model' => 'Obr_Recording',
			'primary_key' => 'isrc_recording_id',
		),
	);
	protected $soft_delete = true;
	protected $soft_delete_key = 'isrc_deleted';
	
	private $_isrc_registrant_code;
	private $_isrc_country_code;
	private $_isrc_stem;
	
	public function __construct() {
		parent::__construct();
		
		$this->table_name = 'ep4_recordings_isrc';
		$this->primary_index_field = 'isrc_id';
		
		$this->_isrc_registrant_code = ISRC_REGISTRANT_CODE;
		$this->_isrc_country_code = ISRC_COUNTRY_CODE;
		
		$this->_isrc_stem = ISRC_COUNTRY_CODE . '-' . $this->_isrc_registrant_code . '-' . date('y') . '-';
	}
	
	public function generate_code() {
		$isrc_code = null;
		
		// Get the first available unassigned code for the current year.
		$result = $this->_retrieve_unassigned_code();
		
		// If no unassigned code is available, create one.
		$isrc_code = (empty($result)) ? $this->_create_code() : $result->isrc_code;
		
		return $isrc_code;
	}
	
	public function update($primary_value, $data, $skip_validation = FALSE) {
		// If audio_isrc_audio_id is being set, make sure it hasn't been
		// assigned to another audio file.
		if (!empty($data['audio_isrc_audio_id'])) {
			$is_writeable = $this->_validate_assignment($data['audio_isrc_audio_id']);
			
			if ($is_writeable === false) {
				$this->error = 'Another ISRC code has already been assigned to this audio file.';
				return false;
			}
		}
		
		return parent::update($primary_value, $data, $skip_validation);
	}
	
	public function insert($data, $skip_validation = FALSE) {
		// If isrc_recording_id is being set, make sure it hasn't been
		// assigned to another audio file.
		if (!empty($data['isrc_recording_id'])) {
			$is_writeable = $this->_validate_assignment($data['isrc_recording_id']);
			
			if ($is_writeable === false) {
				$this->error = 'Another ISRC code has already been assigned to this audio file.';
				return false;
			}
		}
		
		parent::insert($data, $skip_validation);
	}
	
	public function retrieve_by_audio_id($isrc_recording_id, $return_rs = true) {
		if (false !== ($result = $this->get_by('isrc_recording_id', $isrc_recording_id))) {
			return ($return_rs === true) ? $this->return_rs($result) : $result;
		}
		return false;
	}
	
	private function _create_code() {
		$isrc_code = null;
		
		// Get the most recently generated code for the year.
		$result = $this->_retrieve_last_code();
		
		// If a result exists, increment the designation code.
		if (!empty($result)) {
			list ($country, $registrant, $year, $designation) = explode('-', $result->isrc_code);
			$new_designation = intval($designation);
			$new_designation++;
			$isrc_code = $country . '-' . $registrant . '-' . $year . '-' . sprintf('%05d', $new_designation);
		} else {
		// If no result exists, create the first code.
			$isrc_code = $this->_isrc_stem . sprintf('%05d', 1);
		}
		
		// Save the code in the database.
		$this->_save_unassigned_code($isrc_code);
		
		// Return the code.
		return $isrc_code;
	}
	
	private function _retrieve_unassigned_code() {
		$this->db->from($this->table_name);
		$this->db->like('isrc_code', $this->_isrc_stem, 'after');
		$this->db->where('isrc_recording_id', 0);
		$this->db->order_by('isrc_code');
		$result = $this->db->get();
		return $result->row();
	}
	
	private function _retrieve_last_code() {
		$this->db->from($this->table_name);
		$this->db->like('isrc_code', $this->_isrc_stem, 'after');
		$this->db->order_by('isrc_code', 'desc');
		$result = $this->db->get();
		return $result->row();
	}
	
	private function _save_unassigned_code($isrc_code) {
		$unassigned_code = array(
			'isrc_code' => $isrc_code,
			'isrc_recording_id' => 0,
		);
		
		$id = $this->insert($unassigned_code);
		return $id;
	}
	
	private function _validate_assignment($isrc_recording_id) {
		if ($isrc_recording_id == 0) {
			// Zero is an acceptable repeatable value.
			return true;
		} else {
			// If the value is greater than zero, check to make sure
			// it isn't assigned to any other code.
			$result = $this->get_by('isrc_recording_id', $isrc_recording_id);
			if ($result->num_rows() < 1) {
				return true;
			}
		}
		
		return false;
	}
}

?>

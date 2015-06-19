<?php
/**
 * Created by PhpStorm.
 * User: gregbueno
 * Date: 6/1/14
 * Time: 8:55 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecordingISRC extends Model {

	protected $table = 'ep4_recordings_isrc';
	protected $primaryKey = 'isrc_id';
	protected $softDelete = true;
	protected $fillable = array(
		'isrc_code',
		'isrc_recording_id',
	);
	protected $guarded = array(
		'isrc_id',
		'isrc_deleted',
	);

	private $_isrc_registrant_code;
	private $_isrc_country_code;
	private $_isrc_stem;

	public function __construct() {
		$this->_isrc_registrant_code = ISRC_REGISTRANT_CODE;
		$this->_isrc_country_code = ISRC_COUNTRY_CODE;

		$this->_isrc_stem = ISRC_COUNTRY_CODE . '-' . $this->_isrc_registrant_code . '-' . date('y') . '-';
	}

	public function isrc() {
		return $this->hasOne('App\Models\Recording', 'isrc_recording_id', 'recording_id');
	}

	public function generate_code() {
		$isrc_code = null;

		// Get the first available unassigned code for the current year.
		$result = $this->_retrieve_unassigned_code();

		// If no unassigned code is available, create one.
		$isrc_code = (empty($result)) ? $this->_create_code() : $result->isrc_code;

		return $isrc_code;
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

	private function _retrieve_last_code() {
		$result = DB::table($this->table)->where('isrc_code', 'LIKE', $this->_isrc_stem . '%')->orderBy('isrc_code', 'desc')->first();
		return $result;
	}

	private function _retrieve_unassigned_code() {
		$result = DB::table($this->table)->where('isrc_code', 'LIKE', $this->_isrc_stem . '%')->where('isrc_recording_id', 0)->orderBy('isrc_code')->first();
		return $result;
	}

	private function _save_unassigned_code($isrc_code) {
		$this->isrc_code = $isrc_code;
		$this->isrc_recording_id = 0;
		$this->save();

		return $this->isrc_id;
	}

	private function _validate_assignment($isrc_recording_id) {
		if ($isrc_recording_id == 0) {
			// Zero is an acceptable repeatable value.
			return true;
		} else {
			// If the value is greater than zero, check to make sure
			// it isn't assigned to any other code.
			$result = $this->get_by('isrc_recording_id', $isrc_recording_id);
			$result = DB::table($this->table)->where('isrc_recording_id', $isrc_recording_id)->count();
			if ($result < 1) {
				return true;
			}
		}

		return false;
	}
}
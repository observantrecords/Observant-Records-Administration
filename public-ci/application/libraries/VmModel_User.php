<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * VmModel_User
 *
 * @author Greg Bueno
 */
require_once('VmModel.php');

class VmModel_User extends VmModel {

	public function __construct($params = null) {
		parent::__construct($params);
		$this->table_name = 'vm_users';
		$this->primary_index_field = 'user_id';
	}

	public function get_all_users($order_by = '') {
		if (empty($order_by)) {
			$order_by = 'user_first_name' . ' asc';
		}
		$this->db->order_by($order_by);
		$row = $this->db->get($this->table_name);
		return $row;
	}

	public function get_pending_users() {
		$this->db->where('user_level_mask', 2);
		$this->db->order_by('user_date_added', 'desc');
		$row = $this->db->get($this->user_table_name);
		return $row;
	}

	public function get_user_by_access_mask($access_mask) {
		$this->db->where('(user_access_mask & ' . $access_mask . ') = ' . $access_mask);
		$this->db->order_by('user_login', 'asc');
		$row = $this->db->get($this->user_table_name);
		return $row;
	}

	public function get_user_by_login($user_login, $return_recordset = true) {
		$row = $this->retrieve('user_login', $user_login);
		return ($return_recordset === true) ? $this->return_rs($row) : $row;
	}

	public function get_user_by_email($user_email, $return_recordset = true) {
		$row = $this->retrieve('user_email', $user_email);
		return ($return_recordset === true) ? $this->return_rs($row) : $row;
	}

	public function get_user_by_temp_password($user_temp_password) {
		$row = $this->retrieve('user_temp_password', $user_temp_password);
		return ($return_recordset === true) ? $this->return_rs($row) : $row;
	}

	public function update_user_by_email($user_email, $input) {
		return (false !== $this->update('user_email', $user_email, $input)) ? true : false;
	}

}

?>

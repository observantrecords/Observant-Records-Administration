<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * VmModel_User
 *
 * @author Greg Bueno
 */
class VmModel_UserLog extends VmModel {

	public function __construct($params = null) {
		parent::__construct($params);
		$this->table_name = 'vm_users_log';
		$this->primary_index_field = 'log_id';
	}

	public function log_action($msg, $user_id = null) {
		if (!empty($_SESSION['user_id'])) {
			$input['log_user_id'] = !empty($user_id) ? $user_id : $_SESSION['user_id'];
		}
		$input['log_message'] = $msg;
		$input['log_ip'] = $_SERVER['REMOTE_ADDR'];
		$input['log_date_added'] = date("Y-m-d H:i:s");

		$this->create($input);
	}

}

?>

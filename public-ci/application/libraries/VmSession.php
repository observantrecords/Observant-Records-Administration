<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * VmSession
 *
 * 
 * @package CodeIgniter
 * @subpackage Vigilant Media Network
 * @category Libraries
 * @author Greg Bueno
 * @copyright (c) 2012 Greg Bueno
 */
class VmSession {

	protected $CI;
	public $application_name;
	public $session_flag = 'is_logged_in';
	
	public function __construct($params = null) {
		$this->CI = & get_instance();
		$this->CI->load->library('VmModel_User', $params);
		$this->CI->load->library('VmModel_UserLog', $params);
	}

	public function login($login, $password, $success_location, $failure_location) {
		if (empty($success_location)) {
			$success_location = $_SERVER['HTTP_REFERRER'];
		}

		if (empty($failure_location)) {
			$failure_location = $_SERVER['HTTP_REFERRER'];
		}

		// Don't login if the session is already established.
		if ($this->CI->phpsession->get(null, $this->session_flag) == true) {
			header('Location: ' . $success_location);
			die();
		}

		// Don't authenticate if no login information is passed.
		if (empty($login) || empty($password)) {
			$this->CI->phpsession->flashsave('error', 'Make sure your fill in both your username and password.');
			header('Location: ' . $failure_location);
			die();
		}

		// Retrieve user record by login.
		if (false !== ($rs = $this->authenticate($login, $password))) {
			// Establish the session.
			foreach ($rs as $field => $value) {
				if ($field != 'user_temp_password' || $field != 'user_password') {
					$this->CI->phpsession->save(null, $value, $field);
				}
			}
			$this->CI->phpsession->save(null, true, $this->session_flag);
			$this->CI->vmmodel_userlog->log_action($login . ' logged in to ' . $this->application_name . '.');

			// Redirect.
			header('Location: ' . $success_location);
			die();
		} else {
			// Log a failure.
			$this->CI->vmmodel_userlog->log_action($login . ' failed to log in to ' . $this->application_name . '.');
			$this->CI->phpsession->flashsave('error', 'We could not find a matching user name and password.');

			// Redirect.
			header('Location: ' . $failure_location);
			die();
		}
	}
	
	public function logout($login, $redirect = null) {
		if (empty($redirect)) {
			$redirect = $_SERVER['HTTP_REFERER'];
		}

		$this->CI->vmmodel_userlog->log_action($login . ' logged out.');
		
		session_destroy();
		header('Location: ' . $redirect);
	}

	private function authenticate($login, $password) {
		if (false !== ($rs = $this->CI->vmmodel_user->get_user_by_login($login))) {
			if (crypt($password, $rs->user_password) == $rs->user_password) {
				return $rs;
			}
		}
		return false;
	}

}

?>

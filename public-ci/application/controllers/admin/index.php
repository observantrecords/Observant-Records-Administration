<?php

class Index extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->library('ObservantView');
		$this->load->library('VmSession', array('dsn' => 'mt'));
		$this->load->model('Obr_Artist');
	}

	public function index() {
		$this->vmview->format_section_head('Administration');

		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsArtists = $this->Obr_Artist->get_all();
			$this->mysmarty->assign('rsArtists', $rsArtists);
		}

		$this->vmview->display('admin/obr_admin_index.tpl', true);
	}

	public function login() {
		$login = $this->input->get_post('login');
		$password = $this->input->get_post('password');
		$success_location = '/index.php/admin/';
		$failure_location = '/index.php/admin/';

		$this->vmsession->login($login, $password, $success_location, $failure_location);
	}

	public function logout() {
		$this->vmsession->logout($_SESSION['user_login'], '/index.php/admin/');
	}
}

?>

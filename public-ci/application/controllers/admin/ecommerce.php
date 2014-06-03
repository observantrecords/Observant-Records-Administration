<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ecommerce
 *
 * @author gbueno
 */
class Ecommerce extends CI_Controller
{
	public function __construct() {
		parent::__construct();

		$this->load->library('ObservantView');
		$this->load->library('VmSession');
		$this->load->helper('Model');
		$this->load->model('Obr_Ecommerce');
		$this->load->model('Obr_Release');
		$this->load->model('Obr_Track');
		$this->load->model('Obr_Album');
		$this->load->model('Obr_Artist');
	}
	
	public function index() {
		
	}
	
	public function browse() {
		
	}
	
	public function view($ecommerce_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsEcommerce = $this->Obr_Ecommerce->get($ecommerce_id);
			$rsRelease = $this->Obr_Release->with('album')->get($rsEcommerce->ecommerce_release_id);
			$rsArtist = $this->Obr_Artist->get($rsRelease->album->album_artist_id);
			$this->vmview->format_section_head($rsRelease->album->album_title, $rsEcommerce->ecommerce_label);
			$this->mysmarty->assign('rsRelease', $rsRelease);
			$this->mysmarty->assign('rsEcommerce', $rsEcommerce);
			$this->mysmarty->assign('rsArtist', $rsArtist);
			$this->mysmarty->assign('track_id', $ecommerce_id);
		}

		$this->vmview->display('admin/obr_ecommerce_view.tpl');
	}
	
	public function add($release_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsRelease = $this->Obr_Release->with('album')->get($release_id);
			$this->mysmarty->assign('rsRelease', $rsRelease);
			
			if (empty($this->vmview->section_head)) {
				$this->vmview->format_section_head($rsRelease->album->album_title, 'Create an ecommerce link');
			}
			
			$rsLabels = $this->Obr_Ecommerce->retrieve_all_labels();
			$labels = array();
			foreach ($rsLabels as $rsLabel) {
				$labels[] = $rsLabel->ecommerce_label;
			}
			
			$this->mysmarty->assign('labels', json_encode($labels));
			
			$link_count = $this->Obr_Ecommerce->count_by('ecommerce_release_id', $release_id);
			$this->mysmarty->assign('ecommerce_list_order', $link_count + 1);
			
			$rsArtist = $this->Obr_Artist->get($rsRelease->album->album_artist_id);
			$this->mysmarty->assign('rsArtist', $rsArtist);

			$this->mysmarty->assign('ecommerce_release_id', $release_id);
		}

		$this->vmview->display('admin/obr_ecommerce_edit.tpl');
	}
	
	public function edit($ecommerce_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsEcommerce = $this->Obr_Ecommerce->get($ecommerce_id);
			$rsRelease = $this->Obr_Release->with('album')->get($rsEcommerce->ecommerce_release_id);
			$this->vmview->format_section_head($rsRelease->album->album_title, $rsEcommerce->ecommerce_label);
			$this->mysmarty->assign('rsEcommerce', $rsEcommerce);
			$this->mysmarty->assign('ecommerce_id', $ecommerce_id);
		}

		$this->add($rsEcommerce->ecommerce_release_id);
	}
	
	public function save_order($release_id) {
		$ecomm_links = $this->input->get_post('ecommerce');

		$is_success = true;
		if (count($ecomm_links) > 0) {
			foreach ($ecomm_links as $ecomm_link) {
				if (false === $this->_update_ecommerce($ecomm_link['ecommerce_id'], $ecomm_link)) {
					$is_success = false;
					$error = 'Ecommerce list order was not saved. Check link for ' . $ecomm_link['ecommerce_label'] . ' (' . $ecomm_link['ecommerce_url'] . ').';
					break;
				}
			}
		}

		echo ($is_success == true) ? 'Ecommerce list order has been saved.' : $error;
	}

	public function delete($ecommerce_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsEcommerce = $this->Obr_Ecommerce->get($ecommerce_id);
			$rsRelease = $this->Obr_Release->with('album')->get($rsEcommerce->ecommerce_release_id);
			$this->vmview->format_section_head($rsRelease->album->album_title, $rsEcommerce->ecommerce_label);
			$this->mysmarty->assign('rsEcommerce', $rsEcommerce);
			$this->mysmarty->assign('ecommerce_id', $ecommerce_id);
			$this->mysmarty->assign('ecommerce_release_id', $rsEcommerce->ecommerce_release_id);
		}

		$this->vmview->display('admin/obr_ecommerce_delete.tpl');
	}
	
	public function create() {
		$redirect = $_SERVER['HTTP_REFERER'];
		$input = build_update_data($this->Obr_Ecommerce->_table);
		if (false !== ($ecommerce_id = $this->Obr_Ecommerce->insert($input))) {
			$redirect = '/index.php/admin/ecommerce/view/' . $ecommerce_id . '/';
			$this->phpsession->flashsave('msg', 'You successfully created an ecommerce link.');
		} else {
			$this->phpsession->flashsave('error', 'You failed to create an ecommerce link.');
		}

		header('Location: ' . $redirect);
		die();
	}
	
	public function update($ecommerce_id) {
		$redirect = $_SERVER['HTTP_REFERER'];
		$input = build_update_data($this->Obr_Ecommerce->_table);
		if (false !== $this->Obr_Ecommerce->update($ecommerce_id, $input)) {
			$redirect = '/index.php/admin/ecommerce/view/' . $ecommerce_id . '/';
			$this->phpsession->flashsave('msg', 'You successfully updated an ecommerce link.');
		} else {
			$this->phpsession->flashsave('error', 'You failed to create an ecommerce link.');
		}

		header('Location: ' . $redirect);
		die();
	}
	
	public function remove($ecommerce_id) {
		$confirm = $this->input->get_post('confirm');
		$redirect = $this->input->get_post('redirect');
		$ecommerce_release_id = $this->input->get_post('ecommerce_release_id');
		
		if ($confirm == true) {
			$this->Obr_Ecommerce->delete($ecommerce_id);
			
			$this->phpsession->flashsave('msg', 'Ecommerce link was deleted.');
			$redirect = '/index.php/admin/release/view/' . $ecommerce_release_id . '/';
		} else {
			$this->phpsession->flashsave('msg', 'Deletion was canceled.');
		}
		
		header('Location: ' . $redirect);
	}
	
	private function _update_ecommerce($ecommerce_id, $input) {
		if (false !== $this->Obr_Ecommerce->update($ecommerce_id, $input)) {
			return true;
		}
		return false;
	}
}

?>

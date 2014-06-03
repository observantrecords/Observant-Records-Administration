<?php

/**
 * Album
 * 
 * Album is a controller for maintaining albums by Observant Records artists.
 *
 * @author Greg Bueno
 */
class Album extends CI_Controller {
	
	public function __construct() {
		parent::__construct();

		$this->load->library('ObservantView');
		$this->load->library('VmSession');
		$this->load->helper('Model');
		$this->load->model('Obr_Artist');
		$this->load->model('Obr_Album');
		$this->load->model('Obr_Album_Format');
		$this->load->model('Obr_Release');
		$this->load->model('Obr_Release_Format');
	}
	
	public function browse($album_artist_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$this->observantview->_set_artist_header($album_artist_id);
			$rsAlbums = $this->Obr_Album->retrieve_by_artist_id($album_artist_id);
			$this->mysmarty->assign('rsAlbums', $rsAlbums);
			$this->mysmarty->assign('artist_id', $album_artist_id);
		}
		
		$this->vmview->display('admin/obr_album_list.tpl', true);
	}
	
	public function view($album_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsAlbum = $this->Obr_Album->with('primary_release')->get($album_id);
			$rsReleases = $this->Obr_Release->with('format')->get_many_by('release_album_id', $album_id);
			$rsArtist = $this->observantview->_set_artist_header($rsAlbum->album_artist_id, $rsAlbum->album_title);
			
			$this->mysmarty->assign('rsArtist', $rsArtist);
			$this->mysmarty->assign('rsAlbum', $rsAlbum);
			$this->mysmarty->assign('rsReleases', $rsReleases);
			$this->mysmarty->assign('album_id', $album_id);
		}
		
		$this->vmview->display('admin/obr_album_view.tpl', true);
	}
	
	public function add($album_artist_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			if (empty($this->vmview->section_head)) {
				$this->observantview->_set_artist_header($album_artist_id, 'Create an album');
			}
			
			$rsFormats = $this->Obr_Album_Format->get_all();
			$this->mysmarty->assign('rsFormats', $rsFormats);
			
			$this->mysmarty->assign('album_artist_id', $album_artist_id);
		}
		
		$this->vmview->display('admin/obr_album_edit.tpl', true);
	}
	
	public function edit($album_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsAlbum = $this->Obr_Album->with('releases')->get($album_id);
			$this->observantview->_set_artist_header($rsAlbum->album_artist_id, $rsAlbum->album_title);
			$this->mysmarty->assign('rsAlbum', $rsAlbum);
			$this->mysmarty->assign('album_id', $album_id);
		}
		
		$this->add($rsAlbum->album_artist_id);
	}
	
	public function delete($album_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsAlbum = $this->Obr_Album->get($album_id);
			$this->observantview->_set_artist_header($rsAlbum->album_artist_id, $rsAlbum->album_title);
			$this->mysmarty->assign('rsAlbum', $rsAlbum);
			$this->mysmarty->assign('album_id', $album_id);
		}
		
		$this->vmview->display('admin/obr_album_delete.tpl', true);
	}
	
	public function save_order() {
		$albums = $this->input->get_post('albums');

		$is_success = true;
		if (count($albums) > 0) {
			foreach ($albums as $album) {
				if (false === $this->_update_album($album['album_id'], $album)) {
					$is_success = false;
					$error = 'Album order was not saved.';
					break;
				}
			}
		}

		echo ($is_success == true) ? 'Album order has been saved.' : $error;
	}

	public function create() {
		$redirect = $_SERVER['HTTP_REFERER'];
		$input = build_update_data($this->Obr_Album->_table);
		if (false !== ($album_id = $this->Obr_Album->insert($input))) {
			$redirect = '/index.php/admin/album/view/' . $album_id . '/';
			$this->phpsession->flashsave('msg', 'You successfully created an album.');
		} else {
			$this->phpsession->flashsave('error', 'You failed to create an album.');
		}

		header('Location: ' . $redirect);
		die();
	}
	
	public function update($album_id) {
		$redirect = $_SERVER['HTTP_REFERER'];
		$input = build_update_data($this->Obr_Album->_table);
		if (false !== $this->Obr_Album->update($album_id, $input)) {
			$redirect = '/index.php/admin/album/view/' . $album_id . '/';
			$this->phpsession->flashsave('msg', 'You successfully updated an album.');
		} else {
			$this->phpsession->flashsave('error', 'You failed to update an album.');
		}

		header('Location: ' . $redirect);
		die();
	}
	
	public function remove($album_id) {
		$this->load->model('Obr_Track');
		$this->load->model('Obr_Audio_Map');
		$this->load->model('Obr_Content');
		$this->load->model('Obr_Ecommerce');
		$confirm = $this->input->get_post('confirm');
		$redirect = $this->input->get_post('redirect');
		$album_artist_id = $this->input->get_post('album_artist_id');
		
		if ($confirm == true) {
			// Gather releases, tracks, ecommerce and content.
			$rsReleases = $this->Obr_Release->with('tracks')->get_many_by('release_album_id', $album_id);

			if (!empty($rsReleases)) {
				foreach ($rsReleases as $r => $rsRelease) {
					foreach ($rsRelease->tracks as $t => $rsTrack) {
						// Remove audio maps BUT NOT audio.
						$this->Obr_Audio_Map->delete_by('map_track_id', $rsTrack->track_id);
						
						// Remove ecommerce and content by tracks.
						$this->Obr_Content->delete_by('content_track_id', $rsTrack->track_id);
						$this->Obr_Ecommerce->delete_by('ecommerce_track_id', $rsTrack->track_id);
					}
					// Remove tracks.
					$this->Obr_Track->delete_by('track_release_id', $rsRelease->release_id);

					// Remove content.
					$this->Obr_Content->delete_by('content_release_id', $rsRelease->release_id);

					// Remove ecommerce.
					$this->Obr_Ecommerce->delete_by('ecommerce_release_id', $rsRelease->release_id);
				}
				
				// Remove releases.
				$this->Obr_Release->delete_by('release_album_id', $album_id);
			}

			// Remove album.
			$this->Obr_Album->delete($album_id);
			
			$this->phpsession->flashsave('msg', 'Album was deleted.');
			$redirect = '/index.php/admin/album/browse/' . $album_artist_id . '/';
		} else {
			$this->phpsession->flashsave('msg', 'Deletion was canceled.');
		}
		
		header('Location: ' . $redirect);
	}
	
	private function _update_album($album_id, $input) {
		if (false !== $this->Obr_Album->update($album_id, $input)) {
			return true;
		}
		return false;
	}
}

?>

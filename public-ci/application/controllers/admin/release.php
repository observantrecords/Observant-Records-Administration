<?php

/**
 * Release
 * 
 * Release is a controller for maintaining releases of albums by Observant Records artists.
 *
 * @author Greg Bueno
 */
class Release extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->library('ObservantView');
		$this->load->library('VmSession');
		$this->load->helper('Model');
		$this->load->model('Obr_Artist');
		$this->load->model('Obr_Album');
		$this->load->model('Obr_Release');
		$this->load->model('Obr_Release_Format');
		$this->load->model('Obr_Track');
		$this->load->model('Obr_Ecommerce');
	}
	
	public function browse($release_album_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsReleases = $this->Obr_Release->with('album')->with('format')->get_many_by('release_album_id', $release_album_id);
			$this->observantview->_set_artist_header($rsReleases[0]->album->album_artist_id, $rsReleases[0]->album->album_title);
			$this->mysmarty->assign('rsReleases', $rsReleases);
			$this->mysmarty->assign('album_id', $release_album_id);
		}
		
		$this->vmview->display('admin/obr_release_list.tpl', true);
	}
	
	public function view($release_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsRelease = $this->Obr_Release->with('album')->with('format')->get($release_id);
			
			$this->Obr_Track->order_by('track_disc_num, track_track_num');
			$rsTracks = $this->Obr_Track->with('song')->get_many_by('track_release_id', $release_id);
			
			foreach ($rsTracks as $rsTrack) {
				$rsRelease->tracks[$rsTrack->track_disc_num][$rsTrack->track_track_num] = $rsTrack;
			}
			
			$this->Obr_Ecommerce->order_by('ecommerce_list_order');
			$rsEcommerce = $this->Obr_Ecommerce->get_many_by('ecommerce_release_id', $release_id);
			$rsRelease->ecommerce = $rsEcommerce;
			
			$this->mysmarty->assign('rsRelease', $rsRelease);
			$this->mysmarty->assign('release_id', $release_id);
			
			$rsArtist = $this->observantview->_set_artist_header($rsRelease->album->album_artist_id, $rsRelease->album->album_title);
			$this->mysmarty->assign('rsArtist', $rsArtist);
		}
		
		$this->vmview->display('admin/obr_release_view.tpl', true);
	}
	
	public function add($album_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsAlbum = $this->Obr_Album->get($album_id);
			if (empty($this->vmview->section_head)) {
				$rsArtist = $this->observantview->_set_artist_header($rsAlbum->album_artist_id, $rsAlbum->album_title);
				$this->mysmarty->assign('rsArtist', $rsArtist);
			}
			
			$rsAlbums = $this->Obr_Album->retrieve_by_artist_id($rsAlbum->album_artist_id);
			$this->mysmarty->assign('rsAlbums', $rsAlbums);
			
			$rsFormats = $this->Obr_Release_Format->get_all();
			$this->mysmarty->assign('rsFormats', $rsFormats);
		}
		
		$this->vmview->display('admin/obr_release_edit.tpl', true);
	}
	
	public function edit($release_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsRelease = $this->Obr_Release->with('album')->with('format')->get($release_id);
			$rsArtist = $this->observantview->_set_artist_header($rsRelease->album->album_artist_id, $rsRelease->album->album_title);
			$this->mysmarty->assign('rsRelease', $rsRelease);
			$this->mysmarty->assign('rsArtist', $rsArtist);
			
			$this->mysmarty->assign('release_id', $release_id);
		}
		
		$this->add($rsRelease->release_album_id);
	}
	
	public function delete($release_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsRelease = $this->Obr_Release->with('album')->with('format')->get($release_id);
			$this->observantview->_set_artist_header($rsRelease->album->album_artist_id, $rsRelease->album->album_title);
			$this->mysmarty->assign('rsRelease', $rsRelease);
			$this->mysmarty->assign('release_id', $release_id);
			$this->mysmarty->assign('release_album_id', $rsRelease->release_album_id);
		}
		
		$this->vmview->display('admin/obr_release_delete.tpl', true);
	}
	
	public function export_id3($release_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsRelease = $this->Obr_Release->with('album')->with('format')->get($release_id);
			
			$this->Obr_Track->order_by('track_disc_num, track_track_num');
			$rsTracks = $this->Obr_Track->with('song')->with('recording')->get_many_by('track_release_id', $release_id);
			
			$rsArtist = $this->Obr_Artist->get($rsRelease->album->album_artist_id);
			
			$file_lines = array();
			foreach ($rsTracks as $rsTrack) {
				$tag = array(
					$rsArtist->artist_display_name,
					$rsArtist->artist_display_name,
					$rsRelease->album->album_title,
					date('Y', strtotime($rsRelease->release_release_date)),
					'Other',
					'℗ ' . date('Y', strtotime($rsRelease->release_release_date)) . ' Observant Records',
					$rsTrack->recording->recording_isrc_num,
					sprintf('%02d', $rsTrack->track_track_num),
					$rsTrack->song->song_title,
				);
				$tag_line = implode('|', $tag);
				$file_lines[] = $tag_line;
			}
			$file = implode("\r\n", $file_lines);
			
			$file_with_bom = chr(239) . chr(187) . chr(191) . $file;
			
			$file_name = $rsArtist->artist_display_name . ' - ' . $rsRelease->album->album_title . '.m3u.txt';
			header('Cache-Control: private');
			header('Content-Disposition: attachment; filename="' . $file_name . '"');
			header("Content-Type: text/plain; charset=utf-8");
			echo $file_with_bom;
			die();
		}
	}

	public function create() {
		$redirect = $_SERVER['HTTP_REFERER'];
		$input = build_update_data($this->Obr_Release->_table);
		if (false !== ($release_id = $this->Obr_Release->insert($input))) {
			$redirect = '/index.php/admin/release/view/' . $release_id . '/';
			$this->phpsession->flashsave('msg', 'You successfully created a release.');
		} else {
			$this->phpsession->flashsave('error', 'You failed to create a release.');
		}

		header('Location: ' . $redirect);
		die();
	}
	
	public function update($release_id) {
		$redirect = $_SERVER['HTTP_REFERER'];
		$input = build_update_data($this->Obr_Release->_table);
		if (false !== $this->Obr_Release->update($release_id, $input)) {
			$redirect = '/index.php/admin/release/view/' . $release_id . '/';
			$this->phpsession->flashsave('msg', 'You successfully updated a release.');
		} else {
			$this->phpsession->flashsave('error', 'You failed to create a release.');
		}

		header('Location: ' . $redirect);
		die();
	}
	
	public function remove($release_id) {
		$this->load->model('Obr_Audio_Map');
		$this->load->model('Obr_Content');
		$this->load->model('Obr_Ecommerce');
		$confirm = $this->input->get_post('confirm');
		$redirect = $this->input->get_post('redirect');
		$release_album_id = $this->input->get_post('release_album_id');
		
		if ($confirm == true) {
			// Gather tracks.
			$rsTracks = $this->Obr_Track->get_many_by('track_release_id', $release_id);
			
			foreach ($rsTracks as $t => $rsTrack) {
				// Remove audio maps.
				$this->Obr_Audio_Map->delete_by('map_track_id', $rsTrack->track_id);
				
				// Remove ecommerce and content by tracks.
				$this->Obr_Content->delete_by('content_track_id', $rsTrack->track_id);
				$this->Obr_Ecommerce->delete_by('ecommerce_track_id', $rsTrack->track_id);
			}

			// Remove tracks.
			$this->Obr_Track->delete_by('track_release_id', $release_id);

			// Remove content.
			$this->Obr_Content->delete_by('content_release_id', $release_id);

			// Remove ecommerce.
			$this->Obr_Ecommerce->delete_by('ecommerce_release_id', $release_id);

			// Remove releases.
			$this->Obr_Release->delete_by('release_album_id', $release_id);
			
			$this->phpsession->flashsave('msg', 'Release was deleted.');
			$redirect = '/index.php/admin/album/view/' . $release_album_id . '/';
		} else {
			$this->phpsession->flashsave('msg', 'Deletion was canceled.');
		}
		
		header('Location: ' . $redirect);
	}
}

?>

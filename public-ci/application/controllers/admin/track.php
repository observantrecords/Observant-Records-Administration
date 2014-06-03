<?php

/**
 * Track
 * 
 * Track is a controller for maintaining tracks of releases from albums by Observant Records artists.
 *
 * @author Greg Bueno
 */
class Track extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->library('ObservantView');
		$this->load->library('VmSession');
		$this->load->library('VmDebug');
		$this->load->model('Obr_Artist');
		$this->load->model('Obr_Audio');
		$this->load->model('Obr_Recording');
		$this->load->model('Obr_Release');
		$this->load->model('Obr_Song');
		$this->load->model('Obr_Track');
		$this->load->helper('Model');
	}

	public function browse($release_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsRelease = $this->Obr_Release->with('album')->get($release_id);
			$rsTracks = $this->Obr_Track->with('song')->get_many_by('track_release_id', $release_id);

			foreach ($rsTracks as $rsTrack) {
				$rsRelease->tracks[$rsTrack->track_disc_num][$rsTrack->track_track_num] = $rsTrack;
			}
			
			$this->vmview->format_section_head($rsRelease->album->album_title, 'Tracks');
			$this->mysmarty->assign('rsRelease', $rsRelease);
			$this->mysmarty->assign('release_id', $release_id);
		}

		$this->vmview->display('admin/obr_track_list.tpl', true);
	}

	public function view($track_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsTrack = $this->Obr_Track->with('song')->with('recording')->get($track_id);
			$rsRelease = $this->Obr_Release->with('album')->get($rsTrack->track_release_id);
			$rsArtist = $this->Obr_Artist->get($rsRelease->album->album_artist_id);
			$this->vmview->format_section_head($rsRelease->album->album_title, $rsTrack->song->song_title);
			$this->mysmarty->assign('rsRelease', $rsRelease);
			$this->mysmarty->assign('rsTrack', $rsTrack);
			$this->mysmarty->assign('rsArtist', $rsArtist);
			$this->mysmarty->assign('track_id', $track_id);
		}

		$this->vmview->display('admin/obr_track_view.tpl');
	}

	public function add($release_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$this->Obr_Song->order_by('song_title');
			$rsSongs = $this->Obr_Song->get_all();
			
			$rsRelease = $this->Obr_Release->with('album')->get($release_id);
			if (empty($this->vmview->section_head)) {
				$this->vmview->format_section_head($rsRelease->album->album_title, 'Create a track');
			}
			
			$rsArtist = $this->Obr_Artist->get($rsRelease->album->album_artist_id);
			$this->mysmarty->assign('rsArtist', $rsArtist);

			$this->Obr_Recording->order_by('recording_isrc_num');
			$rsRecordings = $this->Obr_Recording->with('song')->get_many_by('recording_artist_id', $rsRelease->album->album_artist_id);
			
			$this->mysmarty->assign('rsRecordings', $rsRecordings);
			$this->mysmarty->assign('rsSongs', $rsSongs);
			$this->mysmarty->assign('rsRelease', $rsRelease);
			$this->mysmarty->assign('release_id', $release_id);
		}

		$this->vmview->display('admin/obr_track_edit.tpl');
	}

	public function edit($track_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsTrack = $this->Obr_Track->with('song')->get($track_id);
			$rsRelease = $this->Obr_Release->with('album')->get($rsTrack->track_release_id);
			$this->vmview->format_section_head($rsRelease->album->album_title, $rsTrack->song->song_title);
			$this->mysmarty->assign('rsTrack', $rsTrack);
			$this->mysmarty->assign('track_id', $track_id);
		}

		$this->add($rsTrack->track_release_id);
	}

	public function delete($track_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsTrack = $this->Obr_Track->with('song')->get($track_id);
			$rsRelease = $this->Obr_Release->with('album')->get($rsTrack->track_release_id);
			$this->vmview->format_section_head($rsRelease->album->album_title, $rsTrack->song->song_title);
			$this->mysmarty->assign('rsTrack', $rsTrack);
			$this->mysmarty->assign('track_id', $track_id);
			$this->mysmarty->assign('track_release_id', $rsTrack->track_release_id);
		}

		$this->vmview->display('admin/obr_track_delete.tpl');
	}

	public function create() {
		$redirect = $_SERVER['HTTP_REFERER'];
		$input = build_update_data($this->Obr_Track->_table);
		if (false !== ($track_id = $this->Obr_Track->insert($input))) {
			$redirect = '/index.php/admin/track/view/' . $track_id . '/';
			$this->phpsession->flashsave('msg', 'You successfully created a track.');
		} else {
			$this->phpsession->flashsave('error', 'You failed to create a track.');
		}

		header('Location: ' . $redirect);
		die();
	}

	public function update($track_id) {
		$redirect = $_SERVER['HTTP_REFERER'];
		$input = build_update_data($this->Obr_Track->_table);
		if (false !== $this->Obr_Track->update($track_id, $input)) {
			$redirect = '/index.php/admin/track/view/' . $track_id . '/';
			$this->phpsession->flashsave('msg', 'You successfully updated a track.');
		} else {
			$this->phpsession->flashsave('error', 'You failed to create a track.');
		}

		header('Location: ' . $redirect);
		die();
	}

	public function remove($track_id) {
		$this->load->model('Obr_Audio_Map');
		$this->load->model('Obr_Content');
		$this->load->model('Obr_Ecommerce');
		$confirm = $this->input->get_post('confirm');
		$redirect = $this->input->get_post('redirect');
		$track_release_id = $this->input->get_post('track_release_id');
		
		if ($confirm == true) {
			// Remove audio maps.
			$this->Obr_Audio_Map->delete_by('map_track_id', $track_id);

			// Remove ecommerce and content by tracks.
			$this->Obr_Content->delete_by('content_track_id', $track_id);
			$this->Obr_Ecommerce->delete_by('ecommerce_track_id', $track_id);

			// Remove track.
			$this->Obr_Track->delete($track_id);

			$this->phpsession->flashsave('msg', 'Track was deleted.');
			$redirect = '/index.php/admin/release/view/' . $track_release_id . '/';
		} else {
			$this->phpsession->flashsave('msg', 'Deletion was canceled.');
		}
		
		header('Location: ' . $redirect);
	}

	public function save_order($release_id) {
		$tracks = $this->input->get_post('tracks');

		$is_success = true;
		if (count($tracks) > 0) {
			foreach ($tracks as $track) {
				if (false === $this->_update_track($track['track_id'], $track)) {
					$is_success = false;
					$error = 'Track order was not saved. Check disc ' . $track['track_disc_num'] . ', track ' . $track['track_track_num'] . '.';
					break;
				}
			}
		}

		echo ($is_success == true) ? 'Track order has been saved.' : $error;
	}

	private function _update_track($track_id, $input) {
		if (false !== $this->Obr_Track->update($track_id, $input)) {
			return true;
		}
		return false;
	}
}

?>

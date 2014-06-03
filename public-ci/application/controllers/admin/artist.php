<?php

/**
 * Artist
 * 
 * Artist is a controller for maintaining Observant Records artists.
 *
 * @author Greg Bueno
 */
class Artist extends CI_Controller
{
	/**
	 * Artist is a controller for maintaining Observant Records artists.
	 */
	public function __construct() {
		parent::__construct();
		
		// Configure the view defaults.
		$this->load->library('ObservantView');
		// Load session data.
		$this->load->library('VmSession');
		// Load models.
		$this->load->model('Obr_Artist');
		$this->load->model('Obr_Album');
		// Load helpers.
		$this->load->helper('model');
	}
	
	/**
	 * browse
	 * 
	 * browse() displays a list of Observant Records artists.
	 */
	public function browse() {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$this->vmview->format_section_head('Artists');
			
			$rsArtists = $this->Obr_Artist->get_all();
			$this->mysmarty->assign('rsArtists', $rsArtists);
		}

		$this->vmview->display('admin/obr_artist_list.tpl', true);
	}
	
	/**
	 * view
	 * 
	 * view() lists the details of an individual Observant Records artist.
	 * 
	 * @param int $artist_id
	 */
	public function view($artist_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			// Retrieve artist info.
			$rsArtist = $this->Obr_Artist->get($artist_id);
			
			$this->mysmarty->assign('rsArtist', $rsArtist);
			$this->vmview->format_section_head($rsArtist->artist_display_name);
			
			$rsAlbums = $this->Obr_Album->retrieve_by_artist_id($artist_id);
			$this->mysmarty->assign('rsAlbums', $rsAlbums);
			
			$this->mysmarty->assign('artist_id', $artist_id);
		}

		$this->vmview->display('admin/obr_artist_view.tpl', true);
	}
	
	/**
	 * add
	 * 
	 * add() displays a form with which to create an Observant Records artist.
	 */
	public function add() {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			if (empty($this->vmview->section_head)) {
				$this->vmview->format_section_head('Create an artist');
			}
		}
		
		$this->vmview->display('admin/obr_artist_edit.tpl', true);
	}
	
	/**
	 * edit
	 * 
	 * edit() displays a form with which to update an Observant Records artist.
	 * 
	 * @param int $artist_id
	 */
	public function edit($artist_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsArtist = $this->Obr_Artist->get($artist_id);
			$this->vmview->format_section_head($rsArtist->artist_display_name);
			$this->mysmarty->assign('rsArtist', $rsArtist);
			$this->mysmarty->assign('artist_id', $artist_id);
		}

		$this->add();
	}
	
	/**
	 * delete
	 * 
	 * delete() displays a form to confirm the deletion of an Observant Records
	 * artist.
	 * 
	 * @param int $artist_id
	 */
	public function delete($artist_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsArtist = $this->Obr_Artist->get($artist_id);
			$this->vmview->format_section_head($rsArtist->artist_display_name);
			$this->mysmarty->assign('rsArtist', $rsArtist);
			$this->mysmarty->assign('artist_id', $artist_id);
		}
		
		$this->vmview->display('admin/obr_artist_delete.tpl', true);
	}
	
	/**
	 * create
	 * 
	 * create() saves changes made to a newly-added Observant Records artist.
	 * 
	 */
	public function create() {
		$redirect = $_SERVER['HTTP_REFERER'];
		$input = build_update_data($this->Obr_Artist->_table);
		if (false !== ($artist_id = $this->Obr_Artist->insert($input))) {
			$redirect = '/index.php/admin/artist/view/' . $artist_id . '/';
			$this->phpsession->flashsave('msg', 'You successfully created an artist.');
		} else {
			$this->phpsession->flashsave('error', 'You failed to create an artist.');
		}

		header('Location: ' . $redirect);
		die();
	}
	
	/**
	 * update
	 * 
	 * update() saves changes made to an Observant Records artist.
	 * 
	 * @param int $artist_id
	 */
	public function update($artist_id) {
		$redirect = $_SERVER['HTTP_REFERER'];
		$input = build_update_data($this->Obr_Artist->_table);
		if (false !== $this->Obr_Artist->update($artist_id, $input)) {
			$redirect = '/index.php/admin/artist/view/' . $artist_id . '/';
			$this->phpsession->flashsave('msg', 'You successfully updated an artist.');
		} else {
			$this->phpsession->flashsave('error', 'You failed to create an artist.');
		}

		header('Location: ' . $redirect);
		die();
	}

	/**
	 * remove
	 * 
	 * remove() performs a soft delete on an artist and his/her works.
	 * 
	 * @param int $artist_id
	 */
	public function remove($artist_id) {
		$this->load->model('Obr_Song');
		$this->load->model('Obr_Release');
		$this->load->model('Obr_Track');
		$this->load->model('Obr_Audio');
		$this->load->model('Obr_Audio_Map');
		$this->load->model('Obr_Audio_Isrc');
		$this->load->model('Obr_Content');
		$this->load->model('Obr_Ecommerce');
		$confirm = $this->input->get_post('confirm');
		$redirect = $this->input->get_post('redirect');
		
		if ($confirm == true) {
			// Gather albums, releases, tracks, audio, ecommerce and content.
			$rsAlbums = $this->Obr_Album->get_many_by('album_artist_id', $artist_id);
			
			if (!empty($rsAlbums)) {
				foreach ($rsAlbums as $rsAlbum) {
					$rsReleases = $this->Obr_Release->with('tracks')->get_many_by('release_album_id', $rsAlbum->album_id);
					if (!empty($rsReleases)) {
						foreach ($rsReleases as $rsRelease) {
							if (!empty($rsRelease->tracks)) {
								foreach ($rsRelease->tracks as $rsTrack) {
									// Remove audio maps.
									$this->Obr_Audio_Map->delete_by('map_track_id', $rsTrack->track_id);

									// Remove audio.
									$this->_remove_audio($rsTrack->track_audio_id);

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
						}
					}
					// Remove releases.
					$this->Obr_Release->delete_by('release_album_id', $rsAlbum->album_id);
				}
			}
			// Remove audio maps missed by track deletion.
			$rsAudio = $this->Obr_Audio->with('maps')->get_by('audio_artist_id', $artist_id);
			
			if (!empty($rsAudio)) {
				if (count($rsAudio) > 0) {
					foreach ($rsAudio as $rsFile) {
						$this->_remove_audio($rsAudio->audio_id);
					}
				} else {
					$this->_remove_audio($rsAudio->audio_id);
				}
			}
			
			// Remove album.
			$this->Obr_Album->delete_by('album_artist_id', $artist_id);
			
			// Remove artist.
			$this->Obr_Artist->delete($artist_id);
			
			// Remove primary artist ID from songs, but do not remove songs.
			$input = array(
				'song_primary_artist_id' => 0,
			);
			$this->Obr_Song->update_by('song_primary_artist_id', $artist_id, $input);
			
			$this->phpsession->flashsave('msg', 'Artist was deleted.');
			$redirect = '/index.php/admin/';
		} else {
			$this->phpsession->flashsave('msg', 'Deletion was canceled.');
		}
		
		header('Location: ' . $redirect);
	}
	
	private function _remove_audio($audio_id) {
		$this->load->model('Obr_Audio_Map');
		$this->load->model('Obr_Audio_Log');
		$this->load->model('Obr_Audio_Isrc');
		
		// Remove maps.
		$this->Obr_Audio_Map->delete_by('map_audio_id', $audio_id);

		// Remove logs.
		$this->Obr_Audio_Log->delete_by('log_audio_id', $audio_id);

		// Remove ISRC.
		$this->Obr_Audio_Isrc->delete_by('audio_isrc_audio_id', $audio_id);

		// Remove audio.
		$this->Obr_Audio->delete($audio_id);
	}
}

?>

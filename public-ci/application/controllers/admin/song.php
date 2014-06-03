<?php

/**
 * Song is a controller for maintaining songs by Observant Records artists.
 *
 * @author Greg Bueno
 */
class Song extends CI_Controller {
	
	/**
	 * Song is a controller for maintaining songs by Observant Records artists.
	 */
	public function __construct() {
		parent::__construct();

		// Configure the view defaults.
		$this->load->library('ObservantView');
		// Load session data.
		$this->load->library('VmSession');
		// Load models.
		$this->load->model('Obr_Artist');
		$this->load->model('Obr_Audio');
		$this->load->model('Obr_Song');
		$this->load->model('Obr_Recording');
		$this->load->model('Obr_Track');
		// Load helpers.
		$this->load->helper('model');
	}

	/**
	 * browse
	 * 
	 * browse() displays a list of songs associated with an artist.
	 */
	public function browse($artist_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$this->observantview->_set_artist_header($artist_id, 'Songs');
			$this->Obr_Song->order_by('song_title');
			$rsSongs = $this->Obr_Song->get_many_by('song_primary_artist_id', $artist_id);
			$this->mysmarty->assign('rsSongs', $rsSongs);
			$this->mysmarty->assign('artist_id', $artist_id);
		}

		$this->vmview->display('admin/obr_song_list.tpl');
	}

	/**
	 * view
	 * 
	 * view() lists the details of an individual song.
	 * 
	 * @param int $song_id
	 */
	public function view($song_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsSong = $this->Obr_Song->get($song_id);
			if (!empty($rsSong)) {
				$rsSong->tracks = $this->Obr_Track->with('release')->get_many_by('track_song_id', $song_id);
				$rsSong->recordings = $this->Obr_Recording->get_many_by('recording_song_id', $song_id);
			}
			$this->observantview->_set_artist_header($rsSong->song_primary_artist_id, $rsSong->song_title);
			$this->mysmarty->assign('rsSong', $rsSong);
			$this->mysmarty->assign('song_id', $song_id);
		}

		$this->vmview->display('admin/obr_song_view.tpl');
	}

	/**
	 * add
	 * 
	 * add() displays a form with which to create a song.
	 */
	public function add($artist_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			if (empty($this->vmview->section_head)) {
				$this->observantview->_set_artist_header($artist_id, 'Create a song');
			}
			$this->mysmarty->assign('artist_id', $artist_id);
		}

		$this->vmview->display('admin/obr_song_edit.tpl');
	}

	/**
	 * edit
	 * 
	 * edit() displays a form with which to update a song.
	 * 
	 * @param int $song_id
	 */
	public function edit($song_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsSong = $this->Obr_Song->get($song_id);
			$this->observantview->_set_artist_header($rsSong->song_primary_artist_id, $rsSong->song_title);
			$this->mysmarty->assign('rsSong', $rsSong);
			$this->mysmarty->assign('song_id', $song_id);
		}

		$this->add($rsSong->song_primary_artist_id);
	}

	/**
	 * delete
	 * 
	 * delete() displays a form to confirm the deletion of a song.
	 * 
	 * @param int $song_id
	 */
	public function delete($song_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsSong = $this->Obr_Song->with('audio')->with('tracks')->get($song_id);
			$this->observantview->_set_artist_header($rsSong->song_primary_artist_id, $rsSong->song_title);
			$this->mysmarty->assign('rsSong', $rsSong);
			$this->mysmarty->assign('song_id', $song_id);
		}

		$this->vmview->display('admin/obr_song_delete.tpl');
	}

	/**
	 * create
	 * 
	 * create() saves changes made to a newly-added song.
	 * 
	 */
	public function create() {
		$redirect = $_SERVER['HTTP_REFERER'];
		$input = build_update_data($this->Obr_Song->_table);
		if (false !== ($song_id = $this->Obr_Song->insert($input))) {
			$redirect = '/index.php/admin/song/view/' . $song_id . '/';
			$this->phpsession->flashsave('msg', 'You successfully created a song.');
		} else {
			$this->phpsession->flashsave('error', 'You failed to create a song.');
		}

		header('Location: ' . $redirect);
		die();
	}

	/**
	 * update
	 * 
	 * update() saves changes made to a song.
	 * 
	 * @param int $song_id
	 */
	public function update($song_id) {
		$redirect = $_SERVER['HTTP_REFERER'];
		$input = build_update_data($this->Obr_Song->_table);
		if (false !== $this->Obr_Song->update($song_id, $input)) {
			$redirect = '/index.php/admin/song/view/' . $song_id . '/';
			$this->phpsession->flashsave('msg', 'You successfully updated a song.');
		} else {
			$this->phpsession->flashsave('error', 'You failed to udpate a song.');
		}

		header('Location: ' . $redirect);
		die();
	}
	
	/**
	 * remove
	 * 
	 * remove() performs a soft delete on a song and records related to a song,
	 * namely tracks and audio files.
	 * 
	 * @param int $song_id
	 */
	public function remove($song_id) {
		$confirm = $this->input->get_post('confirm');
		$redirect = $this->input->get_post('redirect');
		
		if ($confirm == true) {
			$rsSong = $this->Obr_Song->with('audio')->with('tracks')->get($song_id);
			$artist_id = $rsSong->song_primary_artist_id;
			
			// Remove audio.
			if (!empty($rsSong->audio)) {
				foreach ($rsSong->audio as $rsAudio) {
					$this->Obr_Audio->delete($rsAudio->audio_id);
				}
			}

			// Remove tracks.
			if (!empty($rsSong->tracks)) {
				foreach ($rsSong->tracks as $rsTrack) {
					$this->Obr_Track->delete($rsTrack->track_id);
				}
			}

			// Remove song.
			$this->Obr_Song->delete($song_id);

			$this->phpsession->flashsave('msg', 'Song was deleted.');
			$redirect = '/index.php/admin/song/browse/' . $artist_id . '/';
		} else {
			$this->phpsession->flashsave('msg', 'Deletion was canceled.');
		}
		
		header('Location: ' . $redirect);
	}
	
	/**
	 * save_lyrics
	 * 
	 * save_lyrics() exports a song's lyrics as a text file.
	 * 
	 * @param int $song_id
	 */
	public function save_lyrics($song_id)
	{
		$rsSong = $this->Obr_Song->get($song_id);
		$file = 'Eponymous 4 - ' . $rsSong->song_title . '.txt';

		header('Cache-Control: private');
		header('Content-Disposition: attachment; filename="' . $file . '"');
		header("Content-Type: text/plain; charset=utf-8");
		echo $rsSong->song_title . "\r\n";
		if (!empty($rsSong->song_written_date)) {echo $rsSong->song_written_date . "\r\n";}
		echo "\r\n";
		echo strip_tags($rsSong->song_lyrics);
		die();
	}
}

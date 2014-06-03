<?php

/**
 * Recording
 * 
 * Recoridng is a controller to maintain Observant Records recordings.
 *
 * @author Greg Bueno
 */
class Recording extends CI_Controller {

	public function __construct() {
		parent::__construct();

		// Configure the view defaults.
		$this->load->library('ObservantView');
		// Load session data.
		$this->load->library('VmSession');
		// Load MP3 tag editing library.
		$this->load->library('MyId3');
		// Load models.
		$this->load->model('Obr_Artist');
		$this->load->model('Obr_Audio');
		$this->load->model('Obr_Audio_Log');
		$this->load->model('Obr_Recording');
		$this->load->model('Obr_Recording_Isrc');
		$this->load->model('Obr_Song');
		// Load helpers.
		$this->load->helper('model');

		$this->production_file_path = '/home/nemesisv/websites/prod/observantrecords.com/www';

		$this->myid3->setOption(array('encoding' => 'UTF-8'));
	}
	
	/**
	 * browse
	 * 
	 * browse() displays a list of audio files by an Observant Records artist.
	 * 
	 * @param type $artist_id
	 */
	public function browse($artist_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$this->observantview->_set_artist_header($artist_id, 'Recordings');
			
			$this->Obr_Recording->order_by('recording_isrc_num');
			$rsRecordings = $this->Obr_Recording->with('song')->get_many_by('recording_artist_id', $artist_id);
			$this->mysmarty->assign('rsRecordings', $rsRecordings);
			$this->mysmarty->assign('artist_id', $artist_id);
		}

		$this->vmview->display('admin/obr_recording_list.tpl', true);
	}
	
	/**
	 * view
	 * 
	 * view() lists the details of an individual audio file.
	 * 
	 * @param type $recording_id
	 */
	public function view($recording_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsRecording = $this->Obr_Recording->with('song')->with('audio')->with('isrc')->get($recording_id);
			$this->observantview->_set_artist_header($rsRecording->recording_artist_id, $rsRecording->song->song_title);
			$this->mysmarty->assign('rsRecording', $rsRecording);
			
			$this->mysmarty->assign('recording_id', $recording_id);
		}

		$this->vmview->display('admin/obr_recording_view.tpl', true);
	}
	
	/**
	 * add
	 * 
	 * add() displays a form with which to create an audio file.
	 * 
	 * @param int $artist_id
	 */
	public function add($artist_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			if (empty($this->vmview->section_head)) {
				$this->observantview->_set_artist_header($artist_id, 'Create recording');
			}
			
			$this->Obr_Artist->order_by('artist_display_name');
			$rsArtists = $this->Obr_Artist->get_all();
			$this->mysmarty->assign('rsArtists', $rsArtists);
			
			$this->mysmarty->assign('recording_artist_id', $artist_id);
			
			$this->Obr_Song->order_by('song_title');
			$rsSongs = $this->Obr_Song->get_all();
			$this->mysmarty->assign('rsSongs', $rsSongs);
		}

		$this->vmview->display('admin/obr_recording_edit.tpl', true);
	}
	
	/**
	 * edit
	 * 
	 * edit() displays a form with which to update an audio file.
	 * 
	 * @param type $recording_id
	 */
	public function edit($recording_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsRecording = $this->Obr_Recording->with('song')->get($recording_id);
			$this->observantview->_set_artist_header($rsRecording->recording_artist_id, $rsRecording->song->song_title);
			$this->mysmarty->assign('rsRecording', $rsRecording);
			$this->mysmarty->assign('recording_id', $recording_id);
			
			$this->add($rsRecording->recording_artist_id);
		}

	}
	
	/**
	 * delete
	 * 
	 * delete() displays a form to confirm the deletion of an audio file.
	 * 
	 */
	public function delete($recording_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsRecording = $this->Obr_Recording->with('song')->get($recording_id);
			$this->observantview->_set_artist_header($rsRecording->recording_artist_id, $rsRecording->song->song_title);
			$this->mysmarty->assign('rsRecording', $rsRecording);
			$this->mysmarty->assign('recording_id', $recording_id);
		}

		$this->vmview->display('admin/obr_recording_delete.tpl');
	}
	
	/**
	 * generate_isrc
	 * 
	 * generate_isrc() is an AJAX callback method to return the next available
	 * ISRC code in a pool.
	 */
	public function generate_isrc() {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$recording_isrc_code = (object) array('isrc_code' => $this->Obr_Recording_Isrc->generate_code());
			echo json_encode($recording_isrc_code);
		}
	}
	
	/**
	 * create
	 * 
	 * create() saves changes made to a newly-added audio_file.
	 * 
	 */
	public function create() {
		$redirect = $_SERVER['HTTP_REFERER'];
		$input = build_update_data($this->Obr_Recording->_table);
		$recording_isrc_code = $this->input->get_post('recording_isrc_num');
		
		if (false !== ($recording_id = $this->Obr_Recording->insert($input))) {
			if (!empty($recording_isrc_code)) {
				$this->Obr_Recording_Isrc->update_by('isrc_code', $recording_isrc_code, array(
					'isrc_recording_id' => $recording_id,
					));
			}
			$redirect = '/index.php/admin/recording/view/' . $recording_id . '/';
			$this->phpsession->flashsave('msg', 'You successfully created a recording.');
		} else {
			$this->phpsession->flashsave('error', 'You failed to create a recording.');
		}

		header('Location: ' . $redirect);
		die();
	}
	
	/**
	 * update
	 * 
	 * update() saves changes made to an audio file.
	 * 
	 * @param type $recording_id
	 */
	public function update($recording_id) {
		$redirect = $_SERVER['HTTP_REFERER'];
		$input = build_update_data($this->Obr_Recording->_table);
		$recording_isrc_code = $this->input->get_post('recording_isrc_num');
		
		if (false !== $this->Obr_Recording->update($recording_id, $input)) {
			if (!empty($recording_isrc_code)) {
				$this->Obr_Recording_Isrc->update_by('isrc_code', $recording_isrc_code, array(
					'isrc_recording_id' => $recording_id,
					));
			}
			
			$redirect = '/index.php/admin/recording/view/' . $recording_id . '/';
			$this->phpsession->flashsave('msg', 'You successfully updated a recording.');
		} else {
			$this->phpsession->flashsave('error', 'You failed to update a recording. ' . mysql_error());
		}

		header('Location: ' . $redirect);
		die();
	}
	
	/**
	 * remove
	 * 
	 * remove() performs a soft delete on an audio file.
	 * 
	 */
	public function remove($recording_id) {
		$confirm = $this->input->get_post('confirm');
		$redirect = $this->input->get_post('redirect');
		$remove_file = $this->input->get_post('remove_file');
		
		if ($confirm == true) {
			$rsRecording = $this->Obr_Recording->get($recording_id);
			$artist_id = $rsRecording->recording_artist_id;
			
			// Remove audio.
			$this->Obr_Audio->delete_by('audio_recording_id', $recording_id);
			
			// Remove ISRC.
			$this->Obr_Recording_Isrc->delete_by('isrc_recording_id', $recording_id);
			
			// Remove recording.
			$this->Obr_Recording->delete($recording_id);
			
			$this->phpsession->flashsave('msg', 'Recording was deleted.');
			$redirect = '/index.php/admin/recording/browse/' . $artist_id . '/';
		} else {
			$this->phpsession->flashsave('msg', 'Deletion was canceled.');
		}
		
		header('Location: ' . $redirect);
	}
}

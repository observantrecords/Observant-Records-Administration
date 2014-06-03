<?php

/**
 * Audio
 * 
 * Audio is a controller to maintain Observant Records audio files.
 *
 * @author Greg Bueno
 */
class Audio extends CI_Controller {
	
	private $production_file_path;

	public function __construct() {
		parent::__construct();

		// Configure the view defaults.
		$this->load->library('ObservantView');
		// Load session data.
		$this->load->library('VmSession');
		// Load MP3 tag editing library.
		$this->load->library('MyId3');
		$this->load->library('ObservantS3');
		// Load models.
		$this->load->model('Obr_Artist');
		$this->load->model('Obr_Audio');
		$this->load->model('Obr_Audio_Log');
		$this->load->model('Obr_Recording');
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
			$this->observantview->_set_artist_header($artist_id, 'Audio');
			$rsFiles = $this->Obr_Audio->retrieve_by_artist_id($artist_id);
			$this->mysmarty->assign('rsFiles', $rsFiles);
			$this->mysmarty->assign('artist_id', $artist_id);
		}

		$this->vmview->display('admin/obr_audio_list.tpl', true);
	}
	
	/**
	 * view
	 * 
	 * view() lists the details of an individual audio file.
	 * 
	 * @param type $audio_id
	 */
	public function view($audio_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsFile = $this->Obr_Audio->get($audio_id);
			$rsFile->recording = $this->Obr_Recording->with('song')->get($rsFile->audio_recording_id);
			$this->observantview->_set_artist_header($rsFile->recording->recording_artist_id, $rsFile->recording->song->song_title);
			$this->mysmarty->assign('rsFile', $rsFile);
			
			$this->mysmarty->assign('audio_id', $audio_id);

			if (!empty($rsFile))
			{
				$audio_full_path = $this->production_file_path . $rsFile->audio_file_path . '/' . $rsFile->audio_file_name;
				$audio_tags = $this->myid3->analyze($audio_full_path);

				if (!empty($audio_tags['tags'])) {
					$id3v1 = $audio_tags['tags']['id3v1'];
					$id3v2 = $audio_tags['tags']['id3v2'];

					$this->mysmarty->assign('id3v1', $id3v1);
					$this->mysmarty->assign('id3v2', $id3v2);
				}
			}
		}

		$this->vmview->display('admin/obr_audio_view.tpl', true);
	}
	
	/**
	 * add
	 * 
	 * add() displays a form with which to create an audio file.
	 * 
	 * @param int $artist_id
	 */
	public function add($recording_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsRecording = $this->Obr_Recording->with('artist')->get($recording_id);
			$this->mysmarty->assign('artist_alias', $rsRecording->artist->artist_alias);
			
			if (empty($this->vmview->section_head)) {
				$this->observantview->_set_artist_header($rsRecording->recording_artist_id, 'Create audio file');
			}

			$this->Obr_Recording->order_by('recording_isrc_num');
			$rsRecordings = $this->Obr_Recording->with('song')->with('artist')->get_all();
			$this->mysmarty->assign('rsRecordings', $rsRecordings);
			
			$recordings = array();
			foreach ($rsRecordings as $recording) {
				$recordings[] = (object) array(
					'recording_id' => $recording->recording_id,
					'artist' => $recording->artist->artist_display_name,
					'song_title' => $recording->song->song_title,
				);
			}
			
			$s3_directories = $this->observants3->list_folders($rsRecording->artist->artist_alias);
			foreach ($s3_directories as $i => $s3_directory) {
				$s3_directories[$i] = '/' . $s3_directory;
			}
			
			$this->mysmarty->assign('recording_id', $recording_id);
			
			$this->mysmarty->assign('recordings', json_encode($recordings));
			$this->mysmarty->assign('s3_directories', json_encode($s3_directories));
		}
		
		$this->mysmarty->assign('recording_id', $recording_id);
		$this->vmview->display('admin/obr_audio_edit.tpl', true);
	}
	
	/**
	 * edit
	 * 
	 * edit() displays a form with which to update an audio file.
	 * 
	 * @param type $audio_id
	 */
	public function edit($audio_id, $is_duplicate = false) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsFile = $this->Obr_Audio->get($audio_id);
			$rsFile->recording = $this->Obr_Recording->with('song')->get($rsFile->audio_recording_id);
			$this->observantview->_set_artist_header($rsFile->recording->recording_artist_id, $rsFile->recording->song->song_title);
			$this->mysmarty->assign('rsFile', $rsFile);
			if ($is_duplicate === false) {
				$this->mysmarty->assign('audio_id', $audio_id);
			}
			$this->add($rsFile->audio_recording_id);
		}
	}
	
	/**
	 * duplicate
	 * 
	 * duplicate() displays a form with which to create an audio file
	 * with a previous audio file populating the fields of the form.
	 * 
	 * @param type $audio_id
	 */
	public function duplicate($audio_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$this->mysmarty->assign('original_audio_id', $audio_id);
			$this->edit($audio_id, true);
		}
	}
	
	/**
	 * delete
	 * 
	 * delete() displays a form to confirm the deletion of an audio file.
	 * 
	 */
	public function delete($audio_id) {
		if (!empty($_SESSION[$this->vmsession->session_flag])) {
			$rsAudio = $this->Obr_Audio->with('maps')->with('recording')->get($audio_id);
			$rsAudio->recording = $this->Obr_Recording->with('song')->get($rsAudio->audio_recording_id);
			$this->observantview->_set_artist_header($rsAudio->recording->recording_artist_id, $rsAudio->recording->song->song_title);
			
			$display_remove_file = (file_exists($this->production_file_path . $rsAudio->audio_file_path . '/' . $rsAudio->audio_file_name)) ? true : false;
			$this->mysmarty->assign('display_remove_file', $display_remove_file);
			
			$this->mysmarty->assign('rsAudio', $rsAudio);
			$this->mysmarty->assign('audio_id', $audio_id);
		}

		$this->vmview->display('admin/obr_audio_delete.tpl');
	}
	
	/**
	 * create
	 * 
	 * create() saves changes made to a newly-added audio_file.
	 * 
	 */
	public function create() {
		$redirect = $_SERVER['HTTP_REFERER'];
		$input = build_update_data($this->Obr_Audio->_table);
		
		if (false !== ($audio_id = $this->Obr_Audio->insert($input))) {
			$redirect = '/index.php/admin/audio/view/' . $audio_id . '/';
			$this->phpsession->flashsave('msg', 'You successfully created an audio file.');
		} else {
			$this->phpsession->flashsave('error', 'You failed to create an audio file.');
		}

		header('Location: ' . $redirect);
		die();
	}
	
	/**
	 * update
	 * 
	 * update() saves changes made to an audio file.
	 * 
	 * @param type $audio_id
	 */
	public function update($audio_id) {
		$redirect = $_SERVER['HTTP_REFERER'];
		$input = build_update_data($this->Obr_Audio->_table);
		
		if (false !== $this->Obr_Audio->update($audio_id, $input)) {
			$redirect = '/index.php/admin/audio/view/' . $audio_id . '/';
			$this->phpsession->flashsave('msg', 'You successfully updated an audio file.');
		} else {
			$this->phpsession->flashsave('error', 'You failed to update an audio file. ' . mysql_error());
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
	public function remove($audio_id) {
		$confirm = $this->input->get_post('confirm');
		$redirect = $this->input->get_post('redirect');
		$remove_file = $this->input->get_post('remove_file');
		
		if ($confirm == true) {
			$rsAudio = $this->Obr_Audio->with('maps')->get($audio_id);
			$artist_id = $rsAudio->audio_artist_id;
			
			// Remove maps.
			$this->Obr_Audio_Map->delete_by('map_audio_id', $audio_id);
			
			// Remove log.
			$this->Obr_Audio_Log->delete_by('log_audio_id', $audio_id);
			
			// Remove audio.
			$this->Obr_Audio->delete($audio_id);
			
			$remove_file_message = null;
			if ($remove_file == true) {
				$audio_full_path = $this->production_file_path . $rsAudio->audio_mp3_file_path . '/' . $rsAudio->audio_mp3_file_name;
				if (file_exists($audio_full_path)) {
					if (ENVIRONMENT === 'production') {
						unlink($audio_file_path);
					}
					$remove_file_message .= ' File was removed from server.';
				}
			}

			$this->phpsession->flashsave('msg', 'Audio file was deleted.' . $remove_file_message);
			$redirect = '/index.php/admin/audio/browse/' . $artist_id . '/';
		} else {
			$this->phpsession->flashsave('msg', 'Deletion was canceled.');
		}
		
		header('Location: ' . $redirect);
	}
}

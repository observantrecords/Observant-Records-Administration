<?php

/**
 * Obr_Release
 * 
 * Obr_Release is a model for Observant Records releases. Releases are individual
 * products based on albums.
 *
 * @author Greg Bueno
 */

class Obr_Release extends MY_Model {
	
	public $_table = 'ep4_albums_releases';
	public $primary_key = 'release_id';
	public $belongs_to = array(
		'album' => array(
			'model' => 'Obr_Album',
			'primary_key' => 'release_album_id',
		),
		'format' => array(
			'model' => 'Obr_Release_Format',
			'primary_key' => 'release_format_id',
		),
	);
	public $has_many = array(
		'tracks' => array(
			'model' => 'Obr_Track',
			'primary_key' => 'track_release_id',
		),
		'ecommerce' => array(
			'model' => 'Obr_Ecommerce',
			'primary_key' => 'ecommerce_release_id',
		),
		'content' => array(
			'model' => 'Obr_Content',
			'primary_key' => 'content_release_id',
		),
	);
	protected $soft_delete = true;
	protected $soft_delete_key = 'release_deleted';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function retrieve_by_id($id, $return_recordset = true) {
		if (empty($id)) {
			$id = $this->release_album_id;
		}

		$this->db->join('ep4_albums', 'release_album_id=album_id', 'left');
		$this->db->join('ep4_albums_releases_formats', 'release_format_id=format_id', 'left outer');
		if (false !== ($rsRelease = parent::retrieve_by_id($id, $return_recordset))) {
			if ($return_recordset === true) {
				$rs = $rsRelease;
				if ($this->config['fetch_tracks']) {
					$this->CI->Obr_Track->set_config('return_discs', $this->config['return_discs']);
					if (false !== ($rsTrack = $this->CI->Obr_Track->retrieve_by_release_id($id))) {
						$rs->tracks = $rsTrack;
					}
				}
				return $rs;
			} else {
				return $rsRelease;
			}
			return false;
		}
	}
	
	public function retrieve_by_album_id($album_id, $return_recordset = true) {
		$this->db->join('ep4_albums', 'release_album_id=album_id', 'left');
		$this->db->join('ep4_albums_releases_formats', 'release_format_id=format_id', 'left outer');
		if (false !== ($rsRelease = parent::retrieve('release_album_id', $album_id, $return_recordset))) {
			if ($return_recordset === true) {
				return $this->return_smarty_array($rsRelease);
			} else {
				return $rsRelease;
			}
		}
		return false;
	}

	public function get_latest_release($return_result = true) {
		$this->CI->db->from($this->table_name);
		$this->CI->db->where('release_is_visible', 1);
		$this->CI->db->order_by('release_release_date', 'desc');
		$this->CI->db->limit(1);

		if (false !== ($rowRelease = $this->CI->db->get())) {
			if ($return_result === true) {
				$rsRelease = $this->return_rs($rowRelease);
				if (!empty($rsRelease->release_album_id)) {
					$this->CI->load->model('Obr_Album');
					$rsAlbum = $this->CI->Obr_Album->retrieve_by_id($rsRelease->release_album_id);
					$rs = (object) array_merge((array) $rsAlbum, (array) $rsRelease);
					return $rs;
				}
			}
			return $rowRelease;
		}
		return false;
	}
}

?>

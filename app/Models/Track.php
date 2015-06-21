<?php
/**
 * Created by PhpStorm.
 * User: gregbueno
 * Date: 5/26/14
 * Time: 5:38 PM
 */

namespace ObservantRecords\App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Track extends Model {

	protected $table = 'ep4_tracks';
	protected $primaryKey = 'track_id';
	protected $softDelete = true;
	protected $fillable = array(
		'track_song_id',
		'track_release_id',
		'track_recording_id',
		'track_disc_num',
		'track_track_num',
		'track_alias',
		'track_is_visible',
		'track_audio_is_linked',
		'track_audio_is_downloadable',
		'track_uplaya_score',
	);
	protected $guarded = array(
		'track_id',
		'track_deleted',
	);

	public function release() {
		return $this->belongsTo('ObservantRecords\App\Admin\Models\Release', 'track_release_id', 'release_id');
	}

	public function song() {
		return $this->hasOne('ObservantRecords\App\Admin\Models\Song', 'song_id', 'track_song_id');
	}

	public function recording() {
		return $this->hasOne('ObservantRecords\App\Admin\Models\Recording', 'recording_id', 'track_recording_id');
	}

	public function ecommerce() {
		return $this->hasMany('ObservantRecords\App\Admin\Models\Ecommerce', 'ecommerce_track_id', 'track_id');
	}

	public function findReleaseTracks($release_id) {
		$tracks_formatted = array();
		$tracks = Track::where('track_release_id', $release_id)->orderBy('track_disc_num')->orderBy('track_track_num')->get();

		if (!empty($tracks)) {
			foreach ($tracks as $track) {
				$tracks_formatted[$track->track_disc_num][] = $track;
			}
		}

		return $tracks_formatted;
	}
}
<?php
/**
 * Created by PhpStorm.
 * User: gbueno
 * Date: 5/28/14
 * Time: 2:59 PM
 */

class Recording extends Eloquent {

	protected $table = 'ep4_recordings';
	protected $primaryKey = 'recording_id';
	protected $softDelete = true;
	protected $fillable = array(
		'recording_song_id',
		'recording_artist_id',
		'recording_isrc_num',
	);
	protected $guarded = array(
		'recording_id',
		'recording_deleted',
	);

	public function song() {
		return $this->belongsTo('Song', 'recording_song_id', 'song_id');
	}

	public function artist() {
		return $this->belongsTo('Artist', 'recording_artist_id', 'artist_id');
	}

	public function isrc() {
		return $this->hasOne('RecordingISRC', 'isrc_code', 'recording_isrc_num');
	}

	public function audio() {
		return $this->hasMany('Audio', 'audio_recording_id', 'recording_id');
	}

} 
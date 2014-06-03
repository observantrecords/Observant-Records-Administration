<?php
/**
 * Created by PhpStorm.
 * User: gregbueno
 * Date: 5/26/14
 * Time: 4:00 PM
 */

class Artist extends Eloquent {

	protected $table = 'ep4_artists';
	protected $primaryKey = 'artist_id';
	protected $softDelete = true;
	protected $fillable = array(
		'artist_last_name',
		'artist_first_name',
		'artist_display_name',
		'artist_alias',
		'artist_url',
		'artist_bio',
		'artist_bio_more',
	);
	protected $guarded = array(
		'artist_id',
	);

	public function __construct() {

	}

	public function albums() {
		return $this->hasMany('Album', 'album_artist_id', 'artist_id')->orderBy('album_order');
	}

	public function songs() {
		return $this->hasMany('Song', 'song_primary_artist_id', 'artist_id')->orderBy('song_title');
	}

	public function recordings() {
		return $this->hasMany('Recording', 'recording_artist_id', 'artist_id');
	}

	public function scopeEponymous4($query) {
		return $query->where('artist_id', '=', 1);
	}

	public function scopeEmptyEnsemble($query) {
		return $query->where('artist_id', '=', 2);
	}

} 
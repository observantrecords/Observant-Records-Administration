<?php
/**
 * Created by PhpStorm.
 * User: gregbueno
 * Date: 5/26/14
 * Time: 5:58 PM
 */

namespace ObservantRecords\App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model {

	protected $table = 'ep4_songs';
	protected $primaryKey = 'song_id';
	protected $softDelete = true;
	protected $fillable = array(
		'song_primary_artist_id',
		'song_title',
		'song_alias',
		'song_author',
		'song_abstract',
		'song_lyrics',
		'song_influences',
		'song_style',
		'song_written_date',
		'song_revised_date',
		'song_recorded_date',
	);
	protected $guarded = array(
		'song_id',
		'song_deleted',
	);


	public function artist() {
		return $this->belongsTo('ObservantRecords\App\Admin\Models\Artist', 'song_primary_artist_id', 'artist_id');
	}

	public function recordings() {
		return $this->hasMany('ObservantRecords\App\Admin\Models\Recording', 'recording_song_id', 'song_id');
	}

	public function tracks() {
		return $this->hasMany('ObservantRecords\App\Admin\Models\Track', 'track_song_id', 'song_id');
	}

} 
<?php
/**
 * Created by PhpStorm.
 * User: gregbueno
 * Date: 5/28/14
 * Time: 4:43 PM
 */

namespace ObservantRecords\App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Audio extends Model {

	protected $table = 'ep4_audio';
	protected $primaryKey = 'audio_id';
	protected $softDelete = true;
	protected $fillable = array(
		'audio_recording_id',
		'audio_display_label',
		'audio_file_server',
		'audio_file_path',
		'audio_file_name',
		'audio_file_type',
		'audio_isrc_num',
	);
	protected $guarded = array(
		'audio_id',
		'audio_deleted',
	);

	public function recording() {
		return $this->belongsTo('ObservantRecords\App\Admin\Models\Recording', 'audio_recording_id', 'recording_id');
	}

}
<?php
/**
 * Created by PhpStorm.
 * User: gregbueno
 * Date: 5/26/14
 * Time: 5:29 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlbumFormat extends Model {

	protected $table = 'ep4_albums_formats';
	protected $primaryKey = 'format_id';
	protected $softDelete = true;

	public function albums() {
		return $this->hasMany('App\Models\Album', 'album_format_id', 'format_id');
	}

}
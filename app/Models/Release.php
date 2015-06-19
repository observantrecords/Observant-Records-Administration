<?php
/**
 * Created by PhpStorm.
 * User: gregbueno
 * Date: 5/26/14
 * Time: 5:31 PM
 */

namespace App\Models;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class Release extends Model {

	protected $table = 'ep4_albums_releases';
	protected $primaryKey = 'release_id';
	protected $softDelete = true;
	protected $fillable = array(
		'release_album_id',
		'release_upc_num',
		'release_catalog_num',
		'release_format_id',
		'release_alternate_title',
		'release_alias',
		'release_label',
		'release_release_date',
		'release_image',
		'release_is_visible',
	);
	protected $guarded = array(
		'release_id',
		'release_date_modified',
		'release_deleted',
	);
	private $_catalog_stem;

	public function album() {
		return $this->belongsTo('App\Models\Album', 'release_album_id', 'album_id');
	}

	public function tracks() {
		return $this->hasMany('App\Models\Track', 'track_release_id', 'release_id')->orderBy('track_disc_num')->orderBy('track_track_num');
	}

	public function format() {
		return $this->hasOne('App\Models\ReleaseFormat', 'format_id', 'release_format_id');
	}

	public function ecommerce() {
		return $this->hasMany('App\Models\Ecommerce', 'ecommerce_release_id', 'release_id');
	}

	public function generate_catalog_num() {
		$catalog_num = null;

		// Get the most recently generated code for the year.
		$result = $this->_retrieve_last_number();

		// If a result exists, increment the designation code.
		if (!empty($result)) {
			list ($stem, $suffix) = explode('-', $result->release_catalog_num);
			$new_suffix = intval( substr($suffix, 0, 3) );
			$new_suffix++;
			$catalog_num = $stem . '-' . sprintf('%03d', $new_suffix) . 'B';
		} else {
			// If no result exists, create the first code.
			$catalog_num = $this->_catalog_stem . sprintf('%03d', 1) . 'B';
		}

		// Return the code.
		return $catalog_num;
	}

	private function _retrieve_last_number() {
		$result = DB::table($this->table)->where('release_catalog_num', 'LIKE', 'OBRC-%B')->orderBy('release_catalog_num', 'desc')->first();
		return $result;
	}

}
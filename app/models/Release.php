<?php
/**
 * Created by PhpStorm.
 * User: gregbueno
 * Date: 5/26/14
 * Time: 5:31 PM
 */

class Release extends Eloquent {

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

	public function album() {
		return $this->belongsTo('Album', 'release_album_id', 'album_id');
	}

	public function tracks() {
		return $this->hasMany('Track', 'track_release_id', 'release_id');
	}

	public function format() {
		return $this->hasOne('ReleaseFormat', 'format_id', 'release_format_id');
	}

	public function ecommerce() {
		return $this->hasMany('Ecommerce', 'ecommerce_release_id', 'release_id');
	}

} 
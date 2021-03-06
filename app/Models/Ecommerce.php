<?php
/**
 * Created by PhpStorm.
 * User: gbueno
 * Date: 5/28/14
 * Time: 2:59 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ecommerce extends Model {

	protected $table = 'ep4_ecommerce';
	protected $primaryKey = 'ecommerce_id';
	protected $softDelete = true;
	protected $fillable = array(
		'ecommerce_release_id',
		'ecommerce_track_id',
		'ecommerce_label',
		'ecommerce_url',
		'ecommerce_list_order',
	);
	protected $guarded = array(
		'ecomemrce_id',
		'ecommerce_deleted',
	);

	public function track() {
		return $this->belongsTo( 'App\Models\Track', 'ecommerce_track_id', 'track_id' );
	}

	public function release() {
		return $this->belongsTo( 'App\Models\Release', 'ecommerce_release_id', 'release_id' );
	}
}
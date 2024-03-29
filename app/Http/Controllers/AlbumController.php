<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Album;
use App\Models\AlbumFormat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;

class AlbumController extends Controller {

	private $layout_variables = array();

	public function __construct() {
		$format_list = array();
		$formats = AlbumFormat::orderBy('format_alias')->get();
		foreach ($formats as $format) {
			$format_list[$format->format_id] = $format->format_alias;
		}

		$this->layout_variables = array(
			'formats' => $format_list,
			'locales' => array('en', 'jp'),
		);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Contracts\View\View
	 */
	public function index()
	{
		$artist_id = Request::get('artist');
		if (!empty($artist_id)) {
			$albums = Album::where('album_artist_id', $artist_id)->orderBy('album_title')->get();
		} else {
			$albums = Album::orderBy('album_title')->get();
		}
		$albums->load('artist');

		$method_variables = array(
			'albums' => $albums,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('album.index', $data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Contracts\View\View
	 */
	public function create()
	{
		$artist_id = Request::get('artist');

		$album = new Album;
		$album->album_release_date = date('Y-m-d');
		$album->album_ctype_locale = 'en';
		if (!empty($artist_id)) {
			$album->album_artist_id = $artist_id;
			$album->artist = Artist::find($artist_id);
		}

		$artists = Artist::orderBy('artist_last_name')->pluck('artist_display_name', 'artist_id');

		$method_variables = array(
			'album' => $album,
			'artists' => $artists,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('album.create', $data);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return RedirectResponse
	 */
	public function store()
	{
		$id = new Album;

		$fields = $id->getFillable();

		foreach ($fields as $field) {
			$id->{$field} = Request::get($field);
		}

		$result = $id->save();

		if ($result !== false) {
			return Redirect::route('album.show', $id->album_id)->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('artist.show', $id->album_artist_id)->with('error', 'Your changes were not saved.');
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  Album  $id
	 * @return \Illuminate\Contracts\View\View
	 */
	public function show($id)
	{
		$method_variables = array(
			'album' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('album.show', $data);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
     * @return \Illuminate\Contracts\View\View
	 */
	public function edit($id)
	{
		$releases = $id->releases->pluck('release_catalog_num', 'release_id');
		$artists = Artist::orderBy('artist_last_name')->pluck('artist_display_name', 'artist_id');

		$method_variables = array(
			'album' => $id,
			'releases' => $releases,
			'artists' => $artists,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('album.edit', $data);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return RedirectResponse
	 */
	public function update($id)
	{
		$fields = $id->getFillable();

		foreach ($fields as $field) {
			$id->{$field} = Request::get($field);
		}

		$result = $id->save();

		if ($result !== false) {
			return Redirect::route('album.show', $id->album_id)->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('artist.show', $id->album_artist_id)->with('error', 'Your changes were not saved.');
		}
	}


	public function delete($id) {

		$method_variables = array(
			'album' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('album.delete', $data);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return RedirectResponse
	 */
	public function destroy($id)
	{
		$confirm = (boolean) Request::get('confirm');
		$album_title = $id->album_title;
		$artist_id = $id->album_artist_id;

		if ($confirm === true) {
			if (count($id->releases) > 0) {
				foreach ($id->releases as $release) {
					/*
					 * This bit of logic is not yet supported.
					foreach ($release->tracks as $track) {
						$track->ecommerce()->delete();
					}
					 */

					// Remove ecommerce.
					$release->ecommerce()->delete();

					// Remove tracks.
					$release->tracks()->delete();
				}

				// Remove releases.
				$id->releases()->delete();
			}

			// Remove album.
			$id->delete();
			return Redirect::route('artist.show', $artist_id )->with('message', $album_title . ' was deleted.');
		} else {
			return Redirect::route('album.show', $id->album_id)->with('error', $album_title . ' was not deleted.');
		}
	}

	public function save_order() {
		$albums = Request::get('albums');

		$is_success = true;
		if (count($albums) > 0) {
			foreach ($albums as $album) {
				if (false === $this->_update_album($album['album_id'], $album)) {
					$is_success = false;
					$error = 'Album order was not saved.';
					break;
				}
			}
		}

		echo ($is_success == true) ? 'Album order has been saved.' : $error;
	}

	private function _update_album($album_id, $input) {
		$album = Album::find($album_id);

		$album->album_order = $input['album_order'];

		return $album->save();
	}


}

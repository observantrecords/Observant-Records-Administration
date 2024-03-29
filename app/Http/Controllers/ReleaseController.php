<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Release;
use App\Models\ReleaseFormat;
use App\Models\Track;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;

class ReleaseController extends Controller {

	private $layout_variables = array();

	public function __construct() {

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Contracts\View\View
	 */
	public function index()
	{
		$album_id = Request::get('album');
		if (!empty($album_id)) {
			$releases = Release::where('release_album_id', $album_id)->orderBy('release_catalog_num')->get();
		} else {
			$releases = Release::orderBy('release_catalog_num')->get();
		}
		$releases->load('album');

		$method_variables = array(
			'releases' => $releases,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('release.index', $data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Contracts\View\View
	 */
	public function create()
	{

		$release = new Release;
		$release->release_release_date = date('Y-m-d');

		$album_id = Request::get('album');

		if (!empty($album_id)) {
			$release->release_album_id = $album_id;
			$release->album = Album::find($album_id);
			$albums = Album::where('album_artist_id', $release->album->album_artist_id)->orderBy('album_title')->pluck('album_title', 'album_id');
		} else {
			$albums = Album::orderBy('album_title')->pluck('album_title', 'album_id');
		}

		$formats = ReleaseFormat::all()->pluck('format_alias', 'format_id');

		$method_variables = array(
			'release' => $release,
			'albums' => $albums,
			'formats' => $formats,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('release.create', $data);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return RedirectResponse
	 */
	public function store()
	{
		$release = new Release;

		$fields = $release->getFillable();

		foreach ($fields as $field) {
			$release->{$field} = Request::get($field);
		}

		$result = $release->save();

		if ($result !== false) {
			return Redirect::route('release.show', $release->release_id)->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('album.show', $release->release_album_id )->with('error', 'Your changes were not saved.');
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  Release  $id
	 * @return \Illuminate\Contracts\View\View
	 */
	public function show($id)
	{
		$track_model = new Track();
		$id->release_track_list = $track_model->findReleaseTracks($id->release_id);
		$ecommerce = $id->ecommerce->sortBy('ecommerce_list_order');

		$method_variables = array(
			'release' => $id,
			'ecommerce' => $ecommerce,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('release.show', $data);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  Release  $id
	 * @return \Illuminate\Contracts\View\View
	 */
	public function edit($id)
	{
		$albums = Album::where('album_artist_id', $id->album->album_artist_id)->orderBy('album_title')->pluck('album_title', 'album_id');
		$formats = ReleaseFormat::pluck('format_alias', 'format_id');

		$method_variables = array(
			'release' => $id,
			'albums' => $albums,
			'formats' => $formats,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('release.edit', $data);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  Release  $id
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
			return Redirect::route('release.show', $id->release_id)->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('album.show', $id->release_album_id)->with('error', 'Your changes were not saved.');
		}
	}


	public function delete($id) {

		$method_variables = array(
			'release' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('release.delete', $data);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  Release  $id
	 * @return RedirectResponse
	 */
	public function destroy($id)
	{
		$confirm = (boolean) Request::get('confirm');
		$release_catalog_num = $id->release_catalog_num;
		$album_id = $id->release_album_id;

		if ($confirm === true) {
			/*
			 * Tracks are currently not supported, but this bit of logic will be available if/when they are.
			$ecommerce_tracks = Track::with('ecommerce')->where('track_release_id', $id->release_id)->get();
			foreach ($ecommerce_tracks as $ecommerce_track) {
				$ecommerce_track->ecommerce()->delete();
			}
			 */

			// Remove ecommerce.
			$id->ecommerce()->delete();

			// Remove tracks.
			$id->tracks()->delete();

			// Remove releases.
			$id->delete();
			return Redirect::route('album.show', $album_id  )->with('message', 'The record was deleted.');
		} else {
			return Redirect::route('release.show', $id->release_id)->with('error', 'The record was not deleted.');
		}
	}

	public function export_id3($id) {

		$file_lines = array();
		foreach ($id->tracks as $track) {
			$tag = array(
				$track->release->album->artist->artist_display_name,
				$track->release->album->artist->artist_display_name,
				$track->release->album->album_title,
				date('Y', strtotime($track->release->release_release_date)),
				'Other',
				'℗ ' . date('Y', strtotime($track->release->release_release_date)) . ' Observant Records',
				$track->recording->recording_isrc_num,
				sprintf('%02d', $track->track_track_num),
				$track->song->song_title,
			);
			$tag_line = implode('|', $tag);
			$file_lines[] = $tag_line;
		}
		$file = implode("\r\n", $file_lines);

		$file_with_bom = chr(239) . chr(187) . chr(191) . $file;

		$file_name = $id->album->artist->artist_display_name . ' - ' . $id->album->album_title . '.m3u.txt';
		header('Cache-Control: private');
		header('Content-Disposition: attachment; filename="' . $file_name . '"');
		header("Content-Type: text/plain; charset=utf-8");
		echo $file_with_bom;
		die();
	}

	public function generate_catalog_num() {
		$release = new Release;
		$recording_isrc_code = (object) array('catalog_num' => $release->generate_catalog_num());
		echo json_encode($recording_isrc_code);
	}
}

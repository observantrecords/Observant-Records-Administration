<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
	private $layout_variables = array();

	public function __construct()
	{

	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
		$users = User::orderBy('user_name')->get();

		$method_variables = array(
			'users' => $users,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
		$user = new User;

		$method_variables = array(
			'user' => $user,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('user.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
		$user = new User;

		$fields = $user->getFillable();

		foreach ($fields as $field) {
			$user->{$field} = Input::get($field);
		}
		$user->user_password = Hash::make(Input::get('user_password'));

		$result = $user->save();

		if ($result !== false) {
			return Redirect::route('user.show', array('id' => $user->user_id))->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('user.index')->with('error', 'Your changes were not saved.');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
		$method_variables = array(
			'user' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return view('user.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
		$method_variables = array(
			'user' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
		$fields = $id->getFillable();

		foreach ($fields as $field) {
			$id->{$field} = Input::get($field);
		}

		// If users fill out their old password, they want to change it.
		$old_password = Input::get('old_password');
		if (!empty($old_password)) {
			// Verify the old password is correct.
			if (Hash::check($old_password, $id->user_password)) {
				// Change the password.
				$new_password = Input::get('new_password');
				$id->user_password = Hash::make($new_password);
			}
		}

		$result = $id->save();

		if ($result !== false) {
			return Redirect::route('artist.show', array('id' => $id->artist_id))->with('message', 'Your changes were saved.');
		} else {
			return Redirect::route('artist.index')->with('error', 'Your changes were not saved.');
		}
    }

	/**
	 * Show the form for deleting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		$method_variables = array(
			'user' => $id,
		);

		$data = array_merge($method_variables, $this->layout_variables);

		return View::make('user.delete', $data);
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
		$confirm = (boolean) Input::get('confirm');
		$user_name = $id->user_name;

		if ($confirm === true) {
			// Are we deleting ourselves?
			$user = Auth::user();
			$logout_flag = ((int)$user->user_id === (int)$id->user_id);

			$id->delete();

			if ($logout_flag === true) {
				Auth::logout();
				return Redirect::to('/login')->with('message', $user_name . ' was deleted.');
			}

			return Redirect::route('user.index')->with('message', $user_name . ' was deleted.');
		} else {
			return Redirect::route('user.show', array('id' => $id->user_id))->with('error', $user_name . ' was not deleted.');
		}
    }
}

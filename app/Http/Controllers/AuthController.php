<?php
/**
 * Created by PhpStorm.
 * User: gregbueno
 * Date: 5/26/14
 * Time: 2:09 PM
 */

namespace ObservantRecords\App\Admin\Http\Controllers;

use ObservantRecords\App\Admin\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;


class AuthController extends Controller
{
	use AuthenticatesAndRegistersUsers;

	protected $redirectTo = '/';

	public function getLogin() {

		if (Auth::check() === true) {
			return redirect()->intended($this->redirectPath());
		}

		return view('auth.login');
	}

	public function postLogin(Request $request) {
		$this->validate($request, [
			'user_name' => 'required', 'password' => 'required',
		]);

		$credentials = $this->getCredentials($request);

		if (Auth::attempt($credentials, $request->has('remember'))) {
			return redirect()->intended($this->redirectPath());
		}

		return redirect($this->loginPath())
			->withInput($request->only('user_name', 'remember'))
			->withErrors([
				'user_name' => $this->getFailedLoginMessage(),
			]);
	}

	/**
	 * Get the needed authorization credentials from the request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	protected function getCredentials(Request $request)
	{
		return $request->only('user_name', 'password');
	}

	protected function getFailedLoginMessage()
	{
		return "Sorry, we couldn't verify your credentials. Please try again.";
	}

} 
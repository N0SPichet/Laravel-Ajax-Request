<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
	public function userSignUp (Request $request)
	{
		$this->validate($request, [
			'first_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6'
		]);
		$email = $request->email;
		$first_name = $request->first_name;
		$password = bcrypt($request->password);

		$user = new User();
		$user->email = $email;
		$user->first_name = $first_name;
		$user->password = $password;
		$user->save();
		Auth::login($user);
		return redirect()->route('posts.index');
	}

	public function userSignIn (Request $request)
	{
		$this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
		]);
		if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
			return redirect()->route('posts.index');
		} else {
			return redirect()->back();
		}
	}

	public function userLogout ()
	{
		Auth::logout();
		return redirect()->route('home');
	}
}
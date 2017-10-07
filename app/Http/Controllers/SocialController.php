<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
	/**
	 * Redirect the user to the GitHub authentication page.
	 *
	 * @return Response
	 */
	public function redirectToProvider()
	{
		return Socialite::driver('google')->redirect();
	}

	/**
	 * Obtain the user information from GitHub.
	 *
	 * @return Response
	 */
	public function handleProviderCallback()
	{
		$user = Socialite::driver('google')->user();
		return $this->makeUser($user);
	}

	/**
	 * @param $user
	 * // OAuth Two Providers
	 * $token = $user->token;
	 * // OAuth One Providers
	 * $token = $user->token;
	 * $tokenSecret = $user->tokenSecret;
	 * // All Providers
	 * $user->getId();
	 * $user->getNickname();
	 * $user->getName();
	 * $user->getEmail();
	 * $user->getAvatar();
	 */
	public function makeUser($user_data)
	{
		$user = User::whereEmail($user_data->getEmail())->first();

		if($user) Auth::loginUsingId($user->id);
		else
		{
			$user_array = [
				'name'=>($user_data->getName() == NULL) ? $user_data->getNickname() : $user_data->getName(),
				'email'=>$user_data->getEmail(),
				'password'=>bcrypt('123456')
			];
			$user = User::create($user_array);
			$user->syncRoles(4);
			Auth::loginUsingId($user->id);
		}

		return redirect('/');
	}
}

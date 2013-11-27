<?php

use OAuth2\OAuth2;
use OAuth2\Token_Access;
use OAuth2\Exception as OAuth2_Exception;

class UserController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
	}

	/**
	 * The welcome page after a user logs in.
	 * 
	 * @access public
	 * 
	 * @return Response
	 */
	public function welcome()
	{
		// Check to see if the user has a login session.
		if (Auth::check())
		{
			return View::make('user.welcome')
				->with('user', Auth::user());
		} else {
			return Redirect::to('/user/login');
		}
	}
	
	/**
	 * Allows the user to log in via Facebook.
	 * 
	 * @access public
	 * 
	 * @return Response
	 */
	public function login()
	{
		if (Auth::check())
		{
			return Redirect::to('/user/welcome');
		} else {
			return View::make('user.login');
		}
	}
	
	/**
	 * Logs a user out of the system.
	 * 
	 * @access public
	 * 
	 * @return Response
	 */
	public function logout()
	{
		Auth::logout();
		return Redirect::to('user/login');
	}
	
	/**
	 * Elegantly prints an array. For debugging purpses only.
	 * 
	 * @access private
	 * 
	 * @param $arrData (array) - The array of data to be displayed.
	 */
	private function _printArray($arrData)
	{
		echo '<pre>';
		print_r($arrData);
		echo '</pre>';
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Validate the form input using the static method: make(). Also, pass
		// in the validation rules for the form input.
		$arrRules = array('email' => 'required|email');
		$objValidator = Validator::make(Input::all(), $arrRules);
		
		if ($objValidator->fails())
		{
			return Redirect::to('user/login')
				->withErrors($objValidator)
				->withInput(Input::except('password'));
		} else {
			// Validate the user's credentials.
			$strEmail = Input::get('email');
			$objUser = User::where('email', '=', $strEmail)->first();
			
			// Check if the user exists.
			if (!empty($objUser) && isset($objUser->exists) && $objUser->exists)
			{
				Auth::login($objUser);
				return Redirect::to('/user/welcome')->with('message', 'Logged in via login form.');
			} else {
				return Redirect::to('/user/login')
					->withInput(Input::except('password'))
					->with('message', 'Error loggin in');
			}
		}
	}
	
	public function social()
	{
		if (isset($_GET['code']))
		{
			$strCode = trim($_GET['code']);
			
		    try {
				// Grab the facebook App ID and Secret from its config file.
				$objProvider = OAuth2::provider(
					'Facebook',
					array(
						'id'		=> Config::get('facebook.id'),
						'secret'	=> Config::get('facebook.secret')
					)
				);
				
				$objParams = $objProvider->access($strCode);
                $objToken = new Token_Access(array(
                    'access_token' => $objParams->access_token
                ));
                $arrUser = $objProvider->get_user_info($objToken);
				
				// Check if the uid is exists.
				if ($arrUser['uid'] == 0)
				{
					return View::make('user.login')
						->with('message', 'There was an error logging you in.');
				}
				
				// Check to see if the profile exists.
				$objProfile = Profile::where('uid', '=', $arrUser['uid'])->first();
				
				// User does not exist.
				if (empty($objProfile))
				{
					// Create the user.
					$objUser = new User();
					$objUser->first_name = $arrUser['first_name'];
					$objUser->last_name = $arrUser['last_name'];
					$objUser->email = $arrUser['email'];
					$objUser->save();
					
					// Create the user's profile.
					$objProfile = new Profile();
					$objProfile->uid = $arrUser['uid'];
					$objProfile->username = $arrUser['nickname'];
					$objCreateProfile = $objUser->profiles()->save($objProfile);
				}
				
				// Update the user's access token.
				$objProfile->access_token = $objParams->access_token;
				$objProfile->save();
				
				$objUser = $objProfile->user;
				
				// Facebook login is valid.  Authenticate and redirect to the
				// appropriate page.
				Auth::login($objUser);
				
				return Redirect::to('/user/welcome')->with('message', 'Logged in via Facebook.');
		    } catch (OAuth2_Exception $exception) {
		        show_error('That didnt work: '. $exception);
		    }
		} else {
			// Grab the facebook App ID and Secret from its config file.
			$objProvider = OAuth2::provider(
				'Facebook',
				array(
					'id'		=> Config::get('facebook.id'),
					'secret'	=> Config::get('facebook.secret')
				)
			);
			
			return $objProvider->authorize();
		}
	}
}
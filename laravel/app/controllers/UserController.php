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
		// Get all of the users.
		$objUsers = User::all();
		
		// Load the view and pass the users
		return View::make('user.index')
			->with('user', $objUsers);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}
	
	/**
	 * Allows the user to log in via Facebook.
	 * 
	 * @return Response
	 */
	public function login()
	{
		return View::make('user.login');
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
		// Validate the form input.
		$arrRules = array(
			'first_name'	=> 'required|alpha',
			'last_name'		=> 'required|alpha',
			'email'			=> 'required|email'
		);
		
		// Validate the form input using the static method: make(). Also, pass
		// in the validation rules for the form input.
		$objValidator = Validator::make(Input::all(), $arrRules);
		
		if ($objValidator->fails())
		{
			return Redirect::to('user/login')
				->withErrors($objValidator)
				->withInput(Input::except('password'));
		} else {
			// Grab the facebook App ID and Secret from its config file.
			$objProvider = OAuth2::provider(
				'Facebook',
				array(
					'id'		=> Config::get('facebook.id'),
					'secret'	=> Config::get('facebook.secret')
				)
			);
			
			if (!isset($_GET['code']))
			{
			    // By sending no options it'll come back here.
			    return $objProvider->authorize();
			} else {
			    try {
			        $arrParams = $objProvider->access($_GET['code']);
					printArray($arrParams);exit;
					$token = new Token_Access(
						array('access_token' => $params->access_token)
					);
					
					$objUser = $provider->get_user_info($token);
					$this->_printArray($objUser);
			    } catch (OAuth2_Exception $exception) {
			        show_error('That didnt work: '. $exception);
			    }
			}
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
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
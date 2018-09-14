<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/**
 * Microservice Route Group
 */
$router->group(['prefix'=>'v1'],function() use ($router){
	$router->post('otp','UserController@otp');
	$router->post('register','UserController@register');
	$router->post('isEmailVerified','UserController@isEmailVerified');
	$router->post('login','UserController@login');
	$router->post('password','UserController@setpassword');
	/**
	 * AppLication Process routes
	 */
	$router->group(['prefix'=>'process'], function() use ($router) {
		$router->post('create','AppProcessController@createProcess');
		$router->post('update/{id}','AppProcessController@updateProcess');
		$router->post('delete/{id}','AppProcessController@deleteProcess');
		$router->get('/','AppProcessController@getAllProcess');
	});
});
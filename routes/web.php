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
	
	/**  request OTP **/
	$router->post('otp','UserController@otp');
	
	/** * User Registration **/
	$router->post('register','UserController@register');

	/** * validated user email address **/
	$router->post('isEmailVerified','UserController@isEmailVerified');

	/** * User login **/
	$router->post('login','UserController@login');

	/** * create password for user **/
	$router->post('password','UserController@setpassword');
	
	/** Process Routes **/
	$router->group(['prefix'=>'process'], function() use ($router) {
		
		/** Get All the Process **/
		$router->get('/','AppProcessController@getAllMainProcess');

		/** Get all the process: old **/
		// $router->get('/','AppProcessController@getAllProcess');
		
		/** Create process **/
		$router->post('create','AppProcessController@createProcess');
		
		/** Update process **/
		$router->post('update','AppProcessController@updateProcess');
		
		/** Delete a process **/
		$router->delete('delete/{id}','AppProcessController@deleteProcess');
		
		/** get the processlist **/
		// $router->post('/create-task','AppProcessController@createTask');
		$router->get('/list','AppProcessController@processList');
		$router->get('/all','AppProcessController@processAll');
		$router->get('/routes','AppProcessController@routeList');
		
	});
	
	/** Sub Process routes **/
	$router->group(['prefix'=>'sub-process'], function() use ($router) {

		/** Get All Sub Process by process id **/
		$router->get('/{id}','AppProcessController@getAllSubProcess');
		
		/** Get All the field by subprocess id **/
		$router->get('/fields/{id}','AppProcessController@getSubProcessField');

		/** Create a subprocess **/
        $router->post('/create-subprocess', 'AppProcessController@createSubProcess');


		$router->get('/tasks/{sub_process_id}','AppTaskController@subProcessTasks');
	});

	$router->group(['prefix'=>'tasks'], function() use ($router) {
		$router->get('/','AppTaskController@allTasks');
		$router->post('create','AppTaskController@createTask');
		$router->get('get-fields','TaskFieldsController@getAllTaskFields');
		$router->get('task-fields/{id}','AppTaskController@getAllTaskField');
	});
	
	$router->group(['prefix'=>'application'], function() use ($router) {
		$router->post('/create','ApplicationController@createApplication');
		$router->post('/address','ApplicationController@address');
		$router->post('/business-detail','ApplicationController@business');
		// $router->post('/basic-info','ApplicationController@basicInfo');
		// $router->post('/owner-info','ApplicationController@ownerInfo');
		$router->post('/loan-detail','ApplicationController@loanInfo');
		$router->post('/loan-purpose','ApplicationController@loanPurpose');
		$router->post('/required-document','ApplicationController@requiredDocument');
		$router->post('/upload-document','ApplicationController@uploadDocument');

		$router->group(['prefix'=>'coapplicant'], function() use ($router) {
			$router->post('/company-info','ApplicationController@coapplicantCompany');			
			$router->post('/address','ApplicationController@coapplicantAddress');			
			$router->post('/occupation-detail','ApplicationController@coapplicantOccupation');			
		});
		
	});

});
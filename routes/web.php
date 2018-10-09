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
	$router->post('otp',['as'=>'otp_request','uses'=>'UserController@otp']);
	
	/** * User Registration **/
	$router->post('register',['as'=>'create_profile','uses'=>'UserController@register']);

	/** * validated user email address **/
	$router->post('isEmailVerified',['as'=>'verify_email','uses'=>'UserController@isEmailVerified']);

	/** * User login **/
	$router->post('login',['as'=>'login','uses'=>'UserController@login']);

	/** * create password for user **/
	$router->post('password',['as'=>'set_password','uses'=>'UserController@setpassword']);
	
	/** Process Routes **/
	$router->group(['prefix'=>'process'], function() use ($router) {
		
		/** Get All the Process **/
		$router->get('/',['as'=>'get_all_process','uses'=>'AppProcessController@getAllMainProcess']);

		/** Get all the process: old **/
		// $router->get('/',['as'=>'','uses'=>'AppProcessController@getAllProcess']);
		
		/** Create process **/
		$router->post('create',['as'=>'create_process','uses'=>'AppProcessController@createProcess']);
		
		/** Update process **/
		$router->post('update',['as'=>'update_process','uses'=>'AppProcessController@updateProcess']);
		
		/** Delete a process **/
		$router->delete('delete/{id}',['as'=>'delete_process','uses'=>'AppProcessController@deleteProcess']);
		
		/** get the processlist **/
		// $router->post('/create-task',['as'=>'','uses'=>'AppProcessController@createTask']);

		/** Get all the process and subprocess list **/
		$router->get('/list',['as'=>'all_process_sub_process','uses'=>'AppProcessController@processList']);
		
		/** Get all the subprocess and children tasks **/
		$router->get('/all',['as'=>'sub_process_with_tasks','uses'=>'AppProcessController@processAll']);
		
		/** Get all the route lists **/
		$router->get('/routes',['as'=>'routes_list','uses'=>'AppProcessController@routeList']);
		
	});
	
	/** Sub Process routes **/
	$router->group(['prefix'=>'sub-process'], function() use ($router) {

		/** Get All Sub Process by process id **/
		$router->get('/{id}',['as'=>'all_sub_process','uses'=>'AppProcessController@getAllSubProcess']);
		
		/** Get All the field by subprocess id **/
		$router->get('/fields/{id}',['as'=>'sub_process_fields','uses'=>'AppProcessController@getSubProcessField']);

		/** Create a subprocess **/
        $router->post('/create-subprocess', ['as'=>'create_subprocess','uses'=>'AppProcessController@createSubProcess']);

		/** get all the subprocess fields **/
		$router->get('/tasks/{sub_process_id}',['as'=>'sub_process_tasks','uses'=>'AppTaskController@subProcessTasks']);
	});

	$router->group(['prefix'=>'tasks'], function() use ($router) {

		$router->get('/',['as'=>'all_tasks','uses'=>'AppTaskController@allTasks']);
		
		$router->post('create',['as'=>'create_task','uses'=>'AppTaskController@createTask']);
		
		$router->get('get-fields',['as'=>'all_task_fields','uses'=>'TaskFieldsController@getAllTaskFields']);
		
		$router->get('task-fields/{id}',['as'=>'task_field','uses'=>'AppTaskController@getAllTaskField']);
	
	});
	
	$router->group(['prefix'=>'application'], function() use ($router) {

		/**Create Application **/
		$router->post('/create',['as'=>'create_application','uses'=>'ApplicationController@createApplication']);
		
		/**Business structure **/
		$router->post('/business-structure',['as'=>'business_structure','uses'=>'ApplicationController@business']);
		
		/** Loan Purpose **/
		$router->post('/loan-purpose',['as'=>'loan_purpose','uses'=>'ApplicationController@loanPurpose']);
		
		/** Annual Sales **/
		$router->post('/annual-sales',['as'=>'annual_sales','uses'=>'ApplicationController@annualSales']);
		
		/** Loan Amount Request **/
		$router->post('/borrowwer-loan-amount',['as'=>'annual_sales','uses'=>'ApplicationController@LoanAmount']);
		
		/** Business Search **/
		$router->post('/business-search',['as'=>'business_search','uses'=>'ApplicationController@businessSearch']);
		
		/** Business Search **/
		$router->post('/business-info',['as'=>'business_info','uses'=>'ApplicationController@businessInfo']);

		/** Business Search **/
        $router->post('/owner', ['as'=>'owner','uses'=>'ApplicationController@owner']);
		
		/** Owner summary **/
		$router->post('/owner-info',['as'=>'owner_info','uses'=>'ApplicationController@ownerInfo']);

		/** Upload Document **/
		/** select if user want to provide electronic doc or upload it manual **/
		$router->post('/upload-document',['as'=>'upload_document','uses'=>'ApplicationController@uploadDocument']);
		
		// $router->post('/address',['as'=>'','uses'=>'ApplicationController@address']);
		// $router->post('/basic-info',['as'=>'','uses'=>'ApplicationController@basicInfo']);
		// $router->post('/loan-detail',['as'=>'','uses'=>'ApplicationController@loanInfo']);
		// $router->post('/required-document',['as'=>'','uses'=>'ApplicationController@requiredDocument']);

		// $router->group(['prefix'=>'coapplicant'], function() use ($router) {
		// 	$router->post('/company-info',['as'=>'','uses'=>'ApplicationController@coapplicantCompany']);			
		// 	$router->post('/address',['as'=>'','uses'=>'ApplicationController@coapplicantAddress']);			
		// 	$router->post('/occupation-detail',['as'=>'','uses'=>'ApplicationController@coapplicantOccupation']);			
		// });
	});

});
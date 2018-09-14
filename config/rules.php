<?php

/* 
 * Rules for all the api POST, PUT, DELETE etc. methods.
 */
return [
        'v1' => [
                
                'otp_request'=> [
                        'name'  => 'required',
                        'email' => 'required|email|unique:users,email',
                        'phone' => 'required|min:10|unique:users,phone',
                ],
                'register'=> [
                        'name'  => 'required',
                        'email' => 'required|email|unique:users',
                        'phone' => 'required|min:10|unique:users',
                        'otp'   => 'required|numeric'
                ],
                'login'=> [
                        'email' => 'required|emailorphone',
                        'password' => 'required'
                ],
                'isEmailPhone' => [
                        'email' => 'required|emailorphone',
                ],
                'setpassword' => [
                        'password' => 'required|min:8',
                        'hash' => 'required'
                ],
                'process_create' => [
                        'name'  => 'required|min:3',
                        'order' => 'required|numeric|unique:app_process',
                        'action'=> 'required|unique:app_process',
                        'type'  => 'required'
                ],
                'process_update' => [
                        'name'  => 'required|min:3',
                        'order' => 'required|numeric|unique:app_process,order',
                        'action'=> 'required|unique:app_process,action',
                        'type'  => 'required'
                ]
                
        ]
];

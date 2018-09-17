<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\B2c\Repositories\Entities\Application\ApplicationRepository;


class ApplicationController extends Controller
{

    /**
     * @var \App\B2c\Repositories\Models\Application
     */
    protected $ApplicationRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ApplicationRepository $ApplicationRepository)
    {
        $this->ApplicationRepository = $ApplicationRepository;

    }

    /**
     * @param Request $Request
     *
     * @return string
     */
    public function basicInfo(Request $Request) {
        return $this->ApplicationRepository->create($Request->all());
    }

    /**
     * @param Request $Request
     *
     * @return string
     */
    public function ownerInfo(Request $Request) {
        
    }

    /**
     * @param Request $Request
     *
     * @return string
     */
    public function loanInfo(Request $Request) {

    }


}
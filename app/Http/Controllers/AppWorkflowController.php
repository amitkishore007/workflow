<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\B2c\Repositories\Contracts\AppWorkflowInterface;

class AppWorkflowController extends Controller
{
    /**
     * @var \App\B2c\Repositories\Entities\AppWorkflowRepository
     */
    protected $AppWorkflowRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AppWorkflowInterface $AppWorkflowRepository)
    {
        $this->AppWorkflowRepository = $AppWorkflowRepository;
        
    }

    /**
    * @author Amit kishore <amit.kishore@biz2credit.com>
    *
    * @param Request $Request
    *
    * @return string
    */
    public function createWorkflow(Request $Request)
    {
        return $this->AppWorkflowRepository->create($Request->all());
    }

    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\B2c\Repositories\Models\AppProcess;
use App\B2c\Repositories\Entities\AppProcess\AppProcessRepository;

class AppProcessController extends Controller
{
    /**
     * @var \App\B2c\Repositories\Entities\AppProcessRepository
     */
    protected $AppProcessRepository;

    /**
     * @var \App\B2c\Repositories\Models\AppProcess
     */
    protected $AppProcess;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AppProcessRepository $AppProcessRepository, AppProcess $AppProcess)
    {
        $this->AppProcessRepository = $AppProcessRepository;
        $this->AppProcess = $AppProcess;

    }

     /**
     * @author Amit kishore <amit.kishore@biz2credit.com>
     * 
     * @param Request $Request
     * 
     * @return string
     */
    public function createProcess(Request $Request)
    {
        $this->validate($Request, config('rules.v1.process_create'));
        return $this->AppProcessRepository->create($Request->all());
    }

    /**
     * @author Amit kishore <amit.kishore@biz2credit.com>
     * 
     * @param Request $Request
     * 
     * @return string
     */
    public function updateProcess(Request $Request, int $id)
    {
        $this->validate($Request, config('rules.v1.process_update'));
        return $this->AppProcessRepository->update($Request->all(), $id);
    }

    /**
     * @author Amit kishore <amit.kishore@biz2credit.com>
     * 
     * @param Request $Request
     * 
     * @return string
     */
    public function deleteProcess(Request $Request, int $id)
    {
        return $this->AppProcessRepository->delete($id);
    }

    /**
     * @author Amit kishore <amit.kishore@biz2credit.com>
     * 
     * @param Request $Request
     * 
     * @return string
     */
    public function getAllProcess()
    {
        return $this->AppProcessRepository->allWorkflow();
    }

}

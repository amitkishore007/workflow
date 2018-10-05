<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\B2c\Repositories\Models\AppTask;
use App\B2c\Repositories\Entities\AppProcess\AppTaskRepository;

class AppTaskController extends Controller
{
    /**
     * @var \App\B2c\Repositories\Entities\AppTaskRepository
     */
    protected $AppTaskRepository;

    /**
     * @var \App\B2c\Repositories\Models\AppTask
     */
    protected $AppTask;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AppTaskRepository $AppTaskRepository, AppTask $AppTask)
    {
        $this->AppTaskRepository = $AppTaskRepository;
        $this->AppTask = $AppTask;
    }

    /**
    * @author Amit kishore <amit.kishore@biz2credit.com>
    *
    * @param Request $Request
    *
    * @return string
    */
    public function createTask(Request $Request)
    {
        // $this->validate($Request, config('rules.v1.task_create'));
        return $this->AppTaskRepository->create($Request->all());
    }

    /**
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param Request $Request
     *
     * @return string
     */
    public function updateTask(Request $Request, int $id)
    {
        $this->validate($Request, config('rules.v1.task_update'));
        return $this->AppTaskRepository->update($Request->all(), $id);
    }

    /**
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param Request $Request
     *
     * @return string
     */
    public function deleteTask(Request $Request, int $id)
    {
        return $this->AppTaskRepository->delete($id);
    }

    /**
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param Request $Request
     *
     * @return string
     */
    public function getAllTask()
    {
        return $this->AppTaskRepository->allWorkflow();
    }
}

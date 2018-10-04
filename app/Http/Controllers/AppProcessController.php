<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\B2c\Repositories\Exceptions\CustomException;
use App\B2c\Repositories\Exceptions\BlankDataException;
use App\B2c\Repositories\Entities\AppProcess\AppTaskRepository;
use App\B2c\Repositories\Entities\AppProcess\AppProcessRepository;
use App\B2c\Repositories\Entities\AppProcess\AppTaskFieldRepository;

class AppProcessController extends Controller
{
    /**
     * @var \App\B2c\Repositories\Entities\AppProcessRepository
     */
    protected $AppProcessRepository;

    /**
     * @var \App\B2c\Repositories\Entities\AppTaskRepository
     */
    protected $AppTaskRepository;

    /**
     * @var \App\B2c\Repositories\Entities\AppTaskField\AppTaskFieldRepository
     */
    protected $taskField;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AppProcessRepository $AppProcessRepository, AppTaskRepository $AppTaskRepository, AppTaskFieldRepository $taskField)
    {
        $this->AppProcessRepository = $AppProcessRepository;
        $this->AppTaskRepository = $AppTaskRepository;
        $this->taskField = $taskField;
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
    public function updateProcess(Request $Request)
    {
        // $this->validate($Request, config('rules.v1.process_update'));
        return $this->AppTaskRepository->updateTaskOrder($Request->all());
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
     * @return string
     */
    public function getAllProcess()
    {
        return $this->AppProcessRepository->allWorkflow();
    }

    /**
     * @author Amit kishore <amit.kishore@biz2credit.com>
     * 
     * @return string
     */
    public function getAllMainProcess()
    {
        return $this->AppProcessRepository->getAllMainProcess();
    }

    /**
     * @author Amit kishore <amit.kishore@biz2credit.com>
     * 
     * @return string
     */
    public function getAllSubProcess(int $id)
    {
        return $this->AppProcessRepository->getAllSubProcess($id);
    }

    /**
    * @author Amit kishore <amit.kishore@biz2credit.com>
    * 
    * @return string
    */
    public function routeList()
    {
        return $this->AppProcessRepository->route_list();
    }

    /**
     * @author Amit kishore <amit.kishore@biz2credit.com>
     * 
     * @return string
     */
    public function processList()
    {
        return $this->AppProcessRepository->all();
    }

    /**
     * process lists for update page
     * @author Amit kishore <amit.kishore@biz2credit.com>
     * 
     * @return string
     */
    public function processAll()
    {
        return $this->AppProcessRepository->updateList();
    }


    /**
     * process lists for update page
     * @author Amit kishore <amit.kishore@biz2credit.com>
     * 
     * @return string
     */
    public function subProcessAll()
    {
        return $this->AppProcessRepository->getSubprocess();
    }


    /**
     * @author Amit kishore <amit.kishore@biz2credit.com>
     * 
     * @return string
     */
    public function createTask(Request $request)
    {
        if ($request->sub_process_id=='null') {
            // then insert record in app_tasks
            return $this->AppProcessRepository->create(['name'=>$request->title,'order'=>1]);
        } else {
            // insert record in app_process
            return $this->AppTaskRepository->create([
                'name'       => $request->title,
                'slug'       => $request->slug,
                'process_id' => $request->sub_process_id,
                'order'      => 1,
                'action'     => $request->action,
            ]);
        }
    }

    /**
     * @author Amit kishore <amit.kishore@biz2credit.com>
     * 
     * @return string
     */
    public function getSubProcessField($subProcessid)
    {
        return $this->taskField->taskFieldBySubProcessId($subProcessid);
    }
}

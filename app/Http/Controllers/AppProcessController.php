<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\B2c\Repositories\Entities\AppProcess\AppTaskRepository;
use App\B2c\Repositories\Entities\AppProcess\AppProcessRepository;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AppProcessRepository $AppProcessRepository, AppTaskRepository $AppTaskRepository)
    {
        $this->AppProcessRepository = $AppProcessRepository;
        $this->AppTaskRepository = $AppTaskRepository;

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
     * @author Amit kishore <amit.kishore@biz2credit.com>
     * 
     * @return string
     */
    public function createTask(Request $request)
    {
        if ($request->parent_id=='null') {
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

}

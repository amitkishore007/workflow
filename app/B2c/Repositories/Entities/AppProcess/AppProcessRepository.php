<?php

namespace App\B2c\Repositories\Entities\AppProcess;

use Illuminate\Support\Facades\Route;
use App\B2c\Repositories\Models\AppTask;
use \App\B2c\Repositories\Models\AppProcess;
use Symfony\Component\HttpFoundation\Response;
use App\B2c\Repositories\Contracts\ApiInterface;
use App\B2c\Repositories\Entities\Api\ApiRepository;
use App\B2c\Repositories\Contracts\AppProcessInterface;

/**
 * The AppProcessRepository class handles the data send from AppProcess Controller
 * and perform further validation if needed and perform database operation using required Model
 * @author Amit kishore <amit.kishore@biz2credit.com>
 */
class AppProcessRepository extends ApiRepository implements AppProcessInterface
{
    /**
     * @var App\B2c\Repositories\Models\AppProcess
     */
    protected $AppProcess;

    /**
     * @var App\B2c\Repositories\Models\AppTask
     */
    protected $AppTask;

    /**
     * @param AppProcess $AppProcess
     */
    public function __construct(AppProcess $AppProcess, AppTask $AppTask) {
        $this->AppProcess = $AppProcess;
        $this->AppTask  = $AppTask;
    }

     /**
     * Get all records method
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param array $columns
     */
    public function all($columns = array('*'))
    {
        $processList = $this->AppProcess->select($columns)->orderBy('order','asc')->get();
        return $this->createResponseStructure(
            ApiInterface::SUCCESS_STATUS,
            Response::HTTP_OK,
            AppProcessInterface::RESOURCE,
            $processList->toArray()
        );
    }

    /**
     * Find method
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param int $id
     * @param array $columns
     */
    public function find(int $id, $columns = array('*'))
    {

    }

    /**
     * Delete method
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param int $ids
     */
    public function delete(int $id)
    {
        $process = $this->AppProcess->findOrFail($id);
        $deleted = $process->delete();
        if($deleted) {
            $this->AppProcess->resetWorkflowOrder($id);
            return $this->createResponseStructure(
                ApiInterface::SUCCESS_STATUS,
                Response::HTTP_OK,
                AppProcessInterface::RESOURCE,
                $this->transformResponse($process, $process->processTransform)
            );
        }
    }

    /**
    * Create method
    * @author Amit kishore <amit.kishore@biz2credit.com>
    *
    * @param array $attributes
    */
    public function create(array $attributes)
    {
        $process = $this->AppProcess->create($attributes);
        return $this->createResponseStructure(
            ApiInterface::SUCCESS_STATUS,
            Response::HTTP_OK,
            AppProcessInterface::RESOURCE,
            $this->transformResponse($process, $process->processTransform)
        );
    }   

    /**
     * Update method
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param array $attributes
     * @param int $id
     */
    public function update(array $attributes, int $id)
    {
        $process = $this->AppProcess->findOrFail($id);
        $updated = $process->update($attributes);
        if($updated) {
            return $this->createResponseStructure(
                ApiInterface::SUCCESS_STATUS,
                Response::HTTP_OK,
                AppProcessInterface::RESOURCE,
                $this->transformResponse($process, $process->processTransform)
            );
        }
    }

    /**
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @return string 
     */

    public function updateList($columns = ['*']) 
    {
        $appProcesses = $this->AppProcess->select($columns)->orderBy('order', 'asc')->get();

        return $this->createResponseStructure(
            ApiInterface::SUCCESS_STATUS,
            Response::HTTP_OK,
            AppProcessInterface::RESOURCE,
            $this->createProcessChild($appProcesses)
        );

    }


    /**
     * Route Check method
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param string $route
     */
    private function route_exist(string $route)
    {
        $routeList = $this->get_routes();
        if (!in_array($route, $routeList)) {
            return false;
        }
        return true;
    }

    /**
     * Get All Routes Response
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @return array 
     */
    public function route_list()
    {
       return $this->createResponseStructure(
            ApiInterface::SUCCESS_STATUS,
            Response::HTTP_OK,
            AppProcessInterface::RESOURCE,
            $this->get_routes()
        );
    }

    /**
     * Get All Routes
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @return array 
     */
    private function get_routes()
    {
        $output = [];
        $routes = Route::getRoutes();
        foreach($routes as $route)
        {
            $output[] = $route['uri'];
        }
        return $output;
    }

    /**
     * Get all workflow
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param array $columns
     */
    public function allWorkflow($columns = array('*'))
    {
        $appProcesses = $this->AppProcess->select($columns)->orderBy('order','asc')->get();
    
        return $this->createResponseStructure(
            ApiInterface::SUCCESS_STATUS,
            Response::HTTP_OK,
            AppProcessInterface::RESOURCE,
            $this->createProcessOutput($appProcesses)
        );
    }

    /**
     * Merge Workflow array
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param Collection $process
     */
    private function createProcessOutput($processes) {
        $output = [];
        foreach($processes as $process) {
            $tasks = $process->tasks()->orderBy('order','asc')->get();
            foreach($tasks as $key => $task){
                if($key+1 < count($tasks)) {
                    $output[$process->name][] = [
                            'id' => $task->slug,
                            'uri' => $task->action,
                            'view' => $process->name.'/'.$task->slug,
                            'transition'=> $tasks[$key+1]['slug']
                    ];
                } else {
                    $output[$process->name][] = [
                            'id' => $task->slug,
                            'uri' => $task->action,
                            'view' => $process->name.'/'.$task->slug,
                            'transition'=> null
                    ];

                }
            }
        }
        return $output;
    }
     
    /**
     * Merge Workflow array
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param Collection $process
     */
    private function createProcessChild($processes) {
        $output = [];
        foreach($processes as $pkey => $process) {
            $tasks = $process->tasks()->orderBy('order','asc')->get();
            $output[] = ['id'=>$process->id,'name'=>$process->name];
            $children = [];
            if ($tasks) {
                
                foreach ($tasks as $key => $task) {
                    $children[] = [
                            'id' => $task->id,
                            'name' => $task->name,
                    ];
                }
            }
           $output[$pkey] = array_merge($output[$pkey], ['children'=>$children]); 

        }
        return $output;
    }
     


}
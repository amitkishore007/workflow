<?php

namespace App\B2c\Repositories\Entities\AppProcess;

use Illuminate\Support\Facades\Route;
use \App\B2c\Repositories\Models\AppTask;
use Symfony\Component\HttpFoundation\Response;
use App\B2c\Repositories\Contracts\ApiInterface;
use App\B2c\Repositories\Entities\Api\ApiRepository;
use App\B2c\Repositories\Contracts\AppTaskInterface;

/**
 * The AppTasjRepository class handles the data send from AppTask Controller
 * and perform further validation if needed and perform database operation using required Model
 * @author Amit kishore <amit.kishore@biz2credit.com>
 */
class AppTaskRepository extends ApiRepository implements AppTaskInterface
{
    /**
     * @var App\B2c\Repositories\Models\AppTask
     */
    protected $AppTask;

    /**
     * @param AppTask $AppTask
     */
    public function __construct(AppTask $AppTask)
    {
        $this->AppTask = $AppTask;
    }

    /**
    * Get all records method
    * @author Amit kishore <amit.kishore@biz2credit.com>
    *
    * @param array $columns
    */
    public function all($columns = array('*'))
    {
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
        $process = $this->AppTask->findOrFail($id);
        $deleted = $process->delete();
        if ($deleted) {
            $this->AppTask->resetWorkflowOrder($id);
            return $this->createResponseStructure(
                ApiInterface::SUCCESS_STATUS,
                Response::HTTP_OK,
                AppTaskInterface::RESOURCE,
                $this->transformResponse($process, $process->taskTransform)
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
        if (!$this->route_exist($attributes['action'])) {
            return $this->createResponseStructure(
                ApiInterface::FAILED_STATUS,
                Response::HTTP_UNPROCESSABLE_ENTITY,
                AppTaskInterface::RESOURCE,
                [
                    AppTaskInterface::ACTION => AppTaskInterface::ROUTE_FAILED
                ]
            );
        }

        $attributes['name'] = $attributes['title'];
        $attributes['process_id'] = $attributes['sub_process_id'];
        unset($attributes['sub_process_id']);
        unset($attributes['title']);
        $attributes['order'] = 1;
        // return $attributes;
        $task = $this->AppTask->create($attributes);
        // return $task->fields()->get();
        // return $attributes['form_fields'];
        $fields = $task->fields()->sync($attributes['form_fields']);
        return $this->createResponseStructure(
            ApiInterface::SUCCESS_STATUS,
            Response::HTTP_OK,
            AppTaskInterface::RESOURCE,
            $this->transformResponse($task, $task->taskTransform)
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
    
        $process = $this->AppTask->findOrFail($attributes['process_id']);


        $updated = $process->updateTaskOrder($attributes);
        if ($updated) {
            return $this->createResponseStructure(
                ApiInterface::SUCCESS_STATUS,
                Response::HTTP_OK,
                AppTaskInterface::RESOURCE,
                $this->transformResponse($process, $process->taskTransform)
            );
        }
    }

    /**
     * Update method
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param array $attributes
     * @param int $id
     */
    public function updateTaskOrder(array $attributes)
    {
        $updated = $this->AppTask->updateTaskOrder($attributes);
        if ($updated) {
            return $this->createResponseStructure(
                ApiInterface::SUCCESS_STATUS,
                Response::HTTP_OK,
                AppTaskInterface::RESOURCE,
                $updated
            );
        }
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
     * Get All Routes
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @return array
     */
    private function get_routes()
    {
        $output = [];
        $routes = Route::getRoutes();
        foreach ($routes as $route) {
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
        $appTaskes = $this->AppTask->select($columns)->orderBy('order', 'asc')->get();
        
        return $this->createResponseStructure(
            ApiInterface::SUCCESS_STATUS,
            Response::HTTP_OK,
            AppTaskInterface::RESOURCE,
            $this->createProcessOutput($appTaskes)
        );
    }

    /**
     * Merge Workflow array
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param Collection $process
     */
    private function createProcessOutput($processes)
    {
        $output = [];
        foreach ($processes as $process) {
            if (array_key_exists($process['process'], $output)) {
                $output[$process['process']] += [
                        $process['sub_process'] => [
                                        'task'=> $process['task'],
                                        'action'=> $process['action'],
                                        'order'=> $process['order'],
                                    ]
                    ];
            } else {
                $output[$process['process']] = [
                                $process['sub_process'] => [
                                    'task'=> $process['task'],
                                    'action'=> $process['action'],
                                    'order'=> $process['order'],
                                ]
                    ];
            }
        }
        return $output;
    }
}

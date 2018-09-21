<?php

namespace App\B2c\Repositories\Entities\AppProcess;

use Illuminate\Support\Facades\Route;
use App\B2c\Repositories\Models\AppTask;
use Symfony\Component\HttpFoundation\Response;
use App\B2c\Repositories\Contracts\ApiInterface;
use App\B2c\Repositories\Entities\Api\ApiRepository;
use App\B2c\Repositories\Contracts\AppProcessInterface;

/**
 * The AppProcessRepository class handles the data send from AppProcess Controller
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
        $Task = $this->AppTask->findOrFail($id);
        $deleted = $Task->delete();
        if ($deleted) {
            // $this->AppTask->resetWorkflowOrder($id);
            return $this->createResponseStructure(
                ApiInterface::SUCCESS_STATUS,
                Response::HTTP_OK,
                AppProcessInterface::RESOURCE,
                $this->transformResponse($Task, $Task->processTransform)
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
                AppProcessInterface::RESOURCE,
                [
                    AppProcessInterface::ACTION => AppProcessInterface::ROUTE_FAILED
                ]
            );
        }

        $Task = $this->AppTask->create($attributes);
        return $this->createResponseStructure(
            ApiInterface::SUCCESS_STATUS,
            Response::HTTP_OK,
            AppProcessInterface::RESOURCE,
            $this->transformResponse($Task, $Task->processTransform)
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
        $Task = $this->AppTask->findOrFail($id);
        $updated = $Task->update($attributes);
        if ($updated) {
            return $this->createResponseStructure(
                ApiInterface::SUCCESS_STATUS,
                Response::HTTP_OK,
                AppProcessInterface::RESOURCE,
                $this->transformResponse($Task, $Task->processTransform)
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
        $appProcesses = $this->AppTask->select($columns)->orderBy('order', 'asc')->get();
        
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
     * @param Collection $Task
     */
    private function createProcessOutput($Taskes)
    {
        $output = [];
        foreach ($Taskes as $Task) {
            if (array_key_exists($Task['process'], $output)) {
                $output[$Task['process']] += [
                        $Task['sub_process'] => [
                                        'task'=> $Task['task'],
                                        'action'=> $Task['action'],
                                        'order'=> $Task['order'],
                                    ]
                    ];
            } else {
                $output[$Task['process']] = [
                                $Task['sub_process'] => [
                                    'task'=> $Task['task'],
                                    'action'=> $Task['action'],
                                    'order'=> $Task['order'],
                                ]
                    ];
            }
        }
        return $output;
    }
}

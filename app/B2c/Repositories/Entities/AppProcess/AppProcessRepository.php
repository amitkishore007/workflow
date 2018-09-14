<?php

namespace App\B2c\Repositories\Entities\AppProcess;

use Illuminate\Support\Facades\Route;
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
     * @param AppProcess $AppProcess
     */
    public function __construct(AppProcess $AppProcess) {
        $this->AppProcess = $AppProcess;
    }

     /**
     * Get all records method
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param array $columns
     */
    public function all($columns = array('*'))
    {
       $appProcesses = $this->AppProcess->select($columns)->orderBy('order','asc')->get();
       return $this->createResponseStructure(
            ApiInterface::SUCCESS_STATUS,
            Response::HTTP_OK,
            AppProcessInterface::RESOURCE,
            $appProcesses->toArray()
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
        if(!$this->route_exist($attributes['action'])) {
            return $this->createResponseStructure(
                ApiInterface::FAILED_STATUS,
                Response::HTTP_UNPROCESSABLE_ENTITY,
                AppProcessInterface::RESOURCE,
                [
                    AppProcessInterface::ACTION => AppProcessInterface::ROUTE_FAILED
                ]
            );
        }

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
        foreach($routes as $route)
        {
            $output[] = $route['uri'];
        }
        return $output;
    }
}
<?php

namespace App\B2c\Repositories\Entities\workflow;

use \App\B2c\Repositories\Models\AppTask;
use App\B2c\Repositories\Models\AppWorkflow;
use Symfony\Component\HttpFoundation\Response;
use App\B2c\Repositories\Contracts\ApiInterface;
use App\B2c\Repositories\Entities\Api\ApiRepository;
use App\B2c\Repositories\Contracts\AppWorkflowInterface;

/**
 * The AppWorkflowRepository class handles the data relate to workflow
 * @author Amit kishore <amit.kishore@biz2credit.com>
 */
class AppWorkflowRepository extends ApiRepository implements AppWorkflowInterface
{
    /**
     * @var App\B2c\Repositories\Models\AppWorkflow
     */
    protected $AppWorkflow;

    /**
     * @param AppField $AppTaskField
     */
    public function __construct(AppWorkflow $AppWorkflow)
    {
        $this->AppWorkflow = $AppWorkflow;
      
    }

    /**
    * Get all records method
    * @author Amit kishore <amit.kishore@biz2credit.com>
    *
    * @param array $columns
    */
    public function all($columns = array('*'))
    {
        $tasks = $this->AppWorkflow->select($columns)->get();
        return $tasks;
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
        
    }

    /**
    * Create method
    * @author Amit kishore <amit.kishore@biz2credit.com>
    *
    * @param array $attributes
    */
    public function create(array $attributes)
    {
      if(array_key_exists('config_array', $attributes)) {
        $rules = json_encode($attributes['config_array']);
    } else if(array_key_exists('rules', $attributes)) {
        $rules = json_encode($attributes['rules']);
      } 
      $attributes['rules'] = $rules;
      $workflow = $this->AppWorkflow->create($attributes);
      return $this->createResponseStructure(
            ApiInterface::SUCCESS_STATUS,
            Response::HTTP_OK,
            AppWorkflowInterface::RESOURCE,
            $workflow->toArray()
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
       
    }

}
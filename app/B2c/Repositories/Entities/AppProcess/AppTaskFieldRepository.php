<?php

namespace App\B2c\Repositories\Entities\AppProcess;

use Illuminate\Support\Facades\Route;
use App\B2c\Repositories\Models\AppTask;
use \App\B2c\Repositories\Models\AppField;
use Symfony\Component\HttpFoundation\Response;
use App\B2c\Repositories\Contracts\ApiInterface;
use App\B2c\Repositories\Contracts\AppTaskInterface;
use App\B2c\Repositories\Entities\Api\ApiRepository;
use App\B2c\Repositories\Contracts\AppTaskFieldInterface;

/**
 * The AppTasjRepository class handles the data send from AppTask Controller
 * and perform further validation if needed and perform database operation using required Model
 * @author Amit kishore <amit.kishore@biz2credit.com>
 */
class AppTaskFieldRepository extends ApiRepository implements AppTaskFieldInterface
{
    /**
     * @var App\B2c\Repositories\Models\AppField
     */
    protected $AppTaskField;

    /**
     * @var App\B2c\Repositories\Models\AppField
     */
    protected $AppTask;

    /**
     * @param AppField $AppTaskField
     */
    public function __construct(AppField $AppTaskField, AppTask $AppTask)
    {
        $this->AppTaskField = $AppTaskField;
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
        $tasks = $this->AppTask->select($columns)->orderBy('order','asc')->get();
        return $this->generateFieldOutput($tasks);
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

    /**
     * Update method
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param array $attributes
     * @param int $id
     */
    public function updateTaskOrder(array $attributes)
    {

    }

    /**
     * Merge Workflow array
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param Collection $process
     */
    private function generateFieldOutput($tasks)
    {
        $output = [];
        foreach ($tasks as $key => $task) {
            $fields = $task->fields()->orderBy('order','asc')->get();
            $output[] = ['page'=> $task->name];
            $children = [];
            if ($fields) {
                foreach($fields as $field) {

                    $validation_rules = [];

                    if ($field->validation_rule) {
                        $rules = json_decode($field->validation_rule);
                        foreach($rules as $rule) {
                            $validation_rules[] = [
                                'name'=> $rule->rule,
                                'validator'=> $rule->value,
                                'message'=>$rule->message
                            ];
                        }
                    }
                    $children[] = [
                        'name'=>$field->name,
                        'label'=>$field->label,
                        'type'=>$field->type,
                        'validation_rules'=> $validation_rules
                    ];
                }
            }
            $output[$key] =  array_merge($output[$key],$children);
        }
        return $output;
    }

    public function taskFieldBySubProcessId($subProcessid) {
        $fields = $this->AppTaskField->where('process_id', $subProcessid)->orderBy('order','asc')->get();
        return $this->createResponseStructure(
            ApiInterface::SUCCESS_STATUS,
            Response::HTTP_OK,
            AppTaskFieldInterface::RESOURCE,
            $this->fieldsForSubProcess($fields)
        );
    }

    private function fieldsForSubProcess($fields) {
        $output = [];
        foreach($fields as $field) {
            $output[] = [
                'id'=> $field->id,
                'name'=>$field->name,
                'type'=>$field->type,
                'label'=>$field->label,
                'order'=>$field->order,
                'is_used'=>$field->is_used,
            ];
        }
        return $output;
    }

    /**
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param Collection $process
     */
    public function getTaskFieldBySlug(array $attributes)
    {
        $task = $this->AppTask->where('slug',$attributes['slug'])->first();
        if(!$task){
            return $this->createResponseStructure(
                ApiInterface::FAILED_STATUS,
                Response::HTTP_NOT_FOUND,
                AppTaskFieldInterface::RESOURCE,
                ['task'=>'No Task Found']
            );
        }

        if (!$task->fields()->count())  {
            return $this->createResponseStructure(
                ApiInterface::FAILED_STATUS,
                Response::HTTP_NOT_FOUND,
                AppTaskFieldInterface::RESOURCE,
                ['task'=>'No Form Field Found!']
            );
        }

        return $this->createResponseStructure(
            ApiInterface::SUCCESS_STATUS,
            Response::HTTP_OK,
            AppTaskFieldInterface::RESOURCE,
            $this->generateFields($task)
        );
    }


    /**
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param Collection $process
     */
    private function generateFields($task)
    {
        $output = [];
        $fields = $task->fields()->orderBy('order','asc')->get();
        // $output[] = ['page'=> $task->name];
        $children = [];
        if ($fields) {
            foreach($fields as $key => $field) {

                $validation_rules = [];

                if ($field->validation_rule) {
                    $rules = json_decode($field->validation_rule);
                    foreach($rules as $rule) {
                        $validation_rules[] = [
                            'name'=> $rule->rule,
                            'validator'=> $rule->value,
                            'message'=>$rule->message
                        ];
                    }
                }

                if(!is_null($field->relationship)) {
                    $relation = json_decode($field->relationship);
                     $output[] = [
                        'name'=>$field->name,
                        'type'=>$field->type,
                        'label'=>$field->label,
                        'inputType'=>$field->input_type,
                        'value'=> $relation->default,
                        'options'=> $relation->data,
                        'validation_rules'=> $validation_rules
                    ];
                } else {
                     $output[] = [
                        'name'=>$field->name,
                        'type'=>$field->type,
                        'label'=>$field->label,
                        'inputType'=>$field->input_type,
                        'validation_rules'=> $validation_rules
                    ];
                }

            }
        }
        // $output[] =  $children;
        return $output;
    }
}

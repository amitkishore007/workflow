<?php 

namespace App\B2c\Repositories\Transformers;

use App\B2c\Repositories\Models\AppTask;
use League\Fractal\TransformerAbstract;
use App\B2c\Repositories\Contracts\AppTaskInterface;

/**
 * The AppTaskTransformer class transform the response for the API
 * @author Amit kishore <amit.kishore@biz2credit.com>
 */
class AppTaskTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     * @author Amit kishore <amit.kishore@biz2credit.com>
     * 
     * @param App\B2c\Repositories\Models\AppTask $AppTask
     * 
     * @return array
     */
    public function transform(AppTask $AppTask)
    {
        return [
            AppTaskInterface::ID => $AppTask->id,
            AppTaskInterface::NAME=>$AppTask->name,
            AppTaskInterface::ACTION => $AppTask->action,
            AppTaskInterface::ORDER => $AppTask->order,
            AppTaskInterface::SLUG => $AppTask->slug,
            AppTaskInterface::PROCESS => $AppTask->process->name,
            AppTaskInterface::CREATED_AT => (string) $AppTask->created_at,
            AppTaskInterface::UPDATED_AT => (string) $AppTask->updated_at,
        ];
    }
}

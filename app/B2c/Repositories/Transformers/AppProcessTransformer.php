<?php 

namespace App\B2c\Repositories\Transformers;

use App\B2c\Repositories\Models\AppProcess;
use League\Fractal\TransformerAbstract;
use App\B2c\Repositories\Contracts\AppProcessInterface;

/**
 * The AppProcessTransformer class transform the response for the API
 * @author Amit kishore <amit.kishore@biz2credit.com>
 */
class AppProcessTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     * @author Amit kishore <amit.kishore@biz2credit.com>
     * 
     * @param App\B2c\Repositories\Models\AppProcess $AppProcess
     * 
     * @return array
     */
    public function transform(AppProcess $AppProcess)
    {
        return [
            AppProcessInterface::ID => $AppProcess->id,
            AppProcessInterface::NAME=>$AppProcess->name,
            AppProcessInterface::ORDER => $AppProcess->order,
            AppProcessInterface::CREATED_AT => (string) $AppProcess->created_at,
            AppProcessInterface::UPDATED_AT => (string) $AppProcess->updated_at,
        ];
    }
}

<?php 

namespace App\B2c\Repositories\Contracts;

use App\B2c\Repositories\Factory\Contracts\RepositoryInterface;


interface AppProcessInterface extends RepositoryInterface
{
    const ID                = 'id';
    const NAME              = 'process';
    const SUB_PROCESS       = 'sub_process';
    const TASK              = 'task';
    const ORDER             = 'order';
    const ACTION            = 'action';
    const CREATED_AT        = 'created_at';
    const UPDATED_AT        = 'updated_at';
    const DELETED_AT        = 'deleted_at';
    const RESOURCE          = 'workflow';
    const ROUTE_FAILED     = 'Please enter a valid action/route'; 
}
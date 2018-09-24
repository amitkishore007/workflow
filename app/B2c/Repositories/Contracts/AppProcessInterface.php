<?php 

namespace App\B2c\Repositories\Contracts;

use App\B2c\Repositories\Factory\Contracts\RepositoryInterface;


interface AppProcessInterface extends RepositoryInterface
{
    const ID                = 'id';
    const NAME              = 'name';
    const ORDER             = 'process_order';
    const RESOURCE          = 'workflow';
    const CREATED_AT        = 'created_at';
    const UPDATED_AT        = 'updated_at';
}
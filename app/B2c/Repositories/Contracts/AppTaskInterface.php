<?php 

namespace App\B2c\Repositories\Contracts;

use App\B2c\Repositories\Factory\Contracts\RepositoryInterface;


interface AppTaskInterface extends RepositoryInterface
{
    const ID                = 'id';
    const PROCESS_ID        = 'process_id';
    const NAME              = 'name';
    const ORDER             = 'order';
    const ACTION            = 'action';
    const SLUG              = 'slug';
    const CREATED_AT        = 'created_at';
    const UPDATED_AT        = 'updated_at';
}
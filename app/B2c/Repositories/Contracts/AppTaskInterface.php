<?php

namespace App\B2c\Repositories\Contracts;

use App\B2c\Repositories\Factory\Contracts\RepositoryInterface;

interface AppTaskInterface extends RepositoryInterface
{
    const ID                = 'id';
    const NAME              = 'name';
    const PROCESS_ID         = 'parent_id';
    const ORDER             = 'process_order';
    const ACTION            = 'action';
    const SLUG              = 'slug';
    const PROCESS           = 'process';
    const RESOURCE          = 'workflow';
    const CREATED_AT        = 'created_at';
    const UPDATED_AT        = 'updated_at';
}

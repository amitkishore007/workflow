<?php 

namespace App\B2c\Repositories\Contracts;

use App\B2c\Repositories\Factory\Contracts\RepositoryInterface;


interface AppProcessInterface extends RepositoryInterface
{
    const ID                = 'id';
    const NAME              = 'name';
    const PARENT_ID         = 'parent_id';
    const RESOURCE          = 'workflow';
}
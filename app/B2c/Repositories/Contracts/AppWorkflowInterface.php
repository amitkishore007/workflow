<?php

namespace App\B2c\Repositories\Contracts;

use App\B2c\Repositories\Factory\Contracts\RepositoryInterface;

interface AppWorkflowInterface extends RepositoryInterface
{
    const RESOURCE = 'workflow';
}

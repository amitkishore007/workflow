<?php

namespace App\B2c\Repositories\Contracts;

use App\B2c\Repositories\Factory\Contracts\RepositoryInterface;

/**
 * @author Nitesh Kaushik <nitesh.kaushik@biz2credit.com>
 */
interface VerificationHashInterface
{
    const PASSWORD = 'password';
    const HASH = 'hash';
    const RESOURCE = 'user';
}

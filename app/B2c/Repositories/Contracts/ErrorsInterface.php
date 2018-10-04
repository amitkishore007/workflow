<?php

namespace App\B2c\Repositories\Contracts;

/**
 * @author Amit kishore <amit.kishore@biz2credit.com>
 */
interface ErrorsInterface
{
   public static function errorMessage(int $statusCode, $errors);
}

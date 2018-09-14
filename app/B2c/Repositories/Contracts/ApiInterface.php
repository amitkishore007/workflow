<?php

namespace App\B2c\Repositories\Contracts;

/**
 * @author Amit kishore <amit.kishore@biz2credit.com>
 */
interface ApiInterface
{
    const FAILED_STATUS          = 'failed';
    const SUCCESS_STATUS         = 'success';
    const OTP_FAILED             = 'Please check your OTP, and try again';
    const CODE                   = 'code';
    const STATUS                 = 'status';
    const API_RESOURCE           = 'resource';
    const DATA                   = 'data';
    const ERRORS                 = 'errors';
}

<?php 

namespace App\B2c\Repositories\Contracts;

use App\B2c\Repositories\Factory\Contracts\RepositoryInterface;

/**
 * @author Amit kishore <amit.kishore@biz2credit.com>
 */
interface UserInterface extends RepositoryInterface
{
    const ID = 'id';
    const EMAIL = 'email';
    const PHONE = 'phone';
    const OTP = 'otp';
    const PASSWORD = 'password';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const RESOURCE = 'user';
    const NAME = 'name';
    const HASH = 'hash';
    const IS_EMAIL_VERIFIED = 'is_email_verified';
    const IS_PHONE_VERIFIED = 'is_phone_verified';
    const IS_ACTIVE = 'is_active';

}
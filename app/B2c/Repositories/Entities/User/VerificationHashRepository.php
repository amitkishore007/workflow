<?php

namespace App\B2c\Repositories\Entities\User;

use Illuminate\Support\Facades\Hash;
use App\B2c\Repositories\Models\User;
use Symfony\Component\HttpFoundation\Response;
use App\B2c\Repositories\Models\Verificationhash;
use App\B2c\Repositories\Entities\Api\ApiRepository;
use App\B2c\Repositories\Contracts\VerificationHashInterface;

/**
 * The VerificationHashRepository class handles the data send from UserController
 * and perform further validation if needed and perform database operation using required Model
 * @author Nitesh Kaushik <nitesh.kaushik@biz2credit.com>
 */
class VerificationHashRepository extends ApiRepository implements VerificationHashInterface
{
    /**
     * @var App\B2c\Repositories\Models\Verificationhash
     */
    protected $Verificationhash;

    /**
     * @author Nitesh Kauhsik <nitesh.kaushik@biz2credit.com>
     *
     * @param App\B2c\Repositories\Models\Verificationhash $Verificationhash
     */
    public function __construct(Verificationhash $Verificationhash)
    {
        $this->Verificationhash = $Verificationhash;
    }

    /**
     * set user's password and delete hashed string on the corresponding to user
     * @author Nitesh Kaushik <nitesh.kaushik@biz2credit.com>
     *
     * @param array $attributes
     *
     * @return string
     */
    public function setUserPassword(array $attributes)
    {
        $Verificationhash = $this->Verificationhash->where([Verificationhash::HASH => $attributes[self::HASH]])->first();
        if (!$Verificationhash) {
            return $this->createResponseStructure(
                config('messages.FAILED_STATUS'),
                Response::HTTP_UNAUTHORIZED,
                self::RESOURCE,
                [self::HASH => [config('messages.LINK_EXPIRED')]]
            );
        }

        $success = $Verificationhash->user()->update([User::PASSWORD => Hash::make($attributes[VerificationHashInterface::PASSWORD]), User::IS_EMAIL_VERIFIED => User::VERIFIED, User::IS_ACTIVE => User::VERIFIED]);
        if (!$success) {
            return $this->createResponseStructure(
                config('messages.FAILED_STATUS'),
                Response::HTTP_INTERNAL_SERVER_ERROR,
                self::RESOURCE,
                [self::HASH => [config('messages.INTERNAL_SERVER_ERROR')]]
            );
        }

        $Verificationhash->delete();
        return $this->createResponseStructure(
                config('messages.SUCCESS_STATUS'),
                Response::HTTP_OK
            );
    }
}

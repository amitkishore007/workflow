<?php

namespace App\B2c\Repositories\Entities\User;

use Illuminate\Support\Facades\Hash;
use App\B2c\Repositories\Models\User;
use Symfony\Component\HttpFoundation\Response;
use App\B2c\Repositories\Contracts\ApiInterface;
use App\B2c\Repositories\Contracts\UserInterface;
use App\B2c\Repositories\Events\VerifyEmailEvent;
use App\B2c\Repositories\Models\Verificationhash;
use App\B2c\Repositories\Contracts\RedisInterface;
use App\B2c\Repositories\Entities\Api\ApiRepository;

/**
 * The UserRepository class handles the data send from UserController
 * and perform further validation if needed and perform database operation using required Model
 * @author Amit kishore <amit.kishore@biz2credit.com>
 */
class UserRepository extends ApiRepository implements UserInterface
{
    /**
     * @var App\B2c\Repositories\Models\User
     */
    protected $User;

    /**
     * @var App\B2c\Repositories\Models\Verificationhash
     */
    protected $Verificationhash;

    /**
     * @var App\B2c\Repositories\Entities\Redis\RedisRepository
     */
    protected $Redis;

    /**
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param App\B2c\Repositories\Entities\Api\ApiRepository $ApiRepository
     * @param App\B2c\Repositories\Models\User $User
     */
    public function __construct(User $User, RedisInterface $Redis, Verificationhash $Verificationhash)
    {
        $this->User = $User;
        $this->Verificationhash = $Verificationhash;
        $this->Redis = $Redis;
    }

    /**
     * check if user email address is unique or not
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param array $attributes
     *
     * @return string
     */
    public function otp(array $attributes)
    {
        $userDetails = [
            self::EMAIL => $attributes[self::EMAIL],
            self::PHONE => $attributes[self::PHONE],
            self::NAME => $attributes[self::NAME],
        ];
        $userDetails[self::OTP] = generateRandomNumber();
        $this->Redis->setRedisKey($userDetails[self::OTP], json_encode($userDetails), 120);

        return $this->createResponseStructure(
            ApiInterface::SUCCESS_STATUS,
            Response::HTTP_OK,
            self::RESOURCE,
            $userDetails
        );
    }

    /**
     * Create method
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param array $attributes
     *
     * @return string
     */
    public function create(array $attributes)
    {
        $redisKey = $this->Redis->getRedisValue($attributes[UserInterface::OTP]);
        $userDetails = (array) json_decode($redisKey);
        
        if (!$redisKey || $userDetails != $attributes) {
            return $this->createResponseStructure(
                ApiInterface::FAILED_STATUS,
                Response::HTTP_UNPROCESSABLE_ENTITY,
                UserInterface::RESOURCE,
                [UserInterface::OTP => ApiInterface::OTP_FAILED]
            );
        }

        $this->Redis->setRedisExpiration($attributes[self::OTP], 1);
        $attributes[User::IS_PHONE_VERIFIED] = User::VERIFIED;
        unset($attributes[self::OTP]);
        $User = $this->User->create($attributes);

        if ($User instanceof User) {
            // event to send Verification Mail
            $hash = genarateRandomString();
            $User->verificationHash()->create([Verificationhash::HASH => $hash]);
            event(new VerifyEmailEvent($User, $hash));

            return $this->createResponseStructure(
                ApiInterface::SUCCESS_STATUS,
                Response::HTTP_OK,
                self::RESOURCE,
                $this->transformResponse($User, $User->transformer)
            );
        }

        return $this->createResponseStructure(
            ApiInterface::FAILED_STATUS,
            Response::HTTP_UNPROCESSABLE_ENTITY,
            self::RESOURCE,
            [self::EMAIL => [config('messages.HTTP_REQUEST_FIALED')]]
        );
    }

     /**
     * Login method which validate email/phone and password
     * @author Nitesh Kaushik <nitesh.kaushik@biz2credit.com>
     *
     * @param array $attributes
     * 
     * @return string
     */
    public function login(array $attributes)
    {
        $User = $this->authEmailPhone($attributes);
        if (!$User) {
	        return $this->createResponseStructure(
                config('messages.FAILED_STATUS'), 
                Response::HTTP_UNAUTHORIZED, 
                self::RESOURCE, 
                [self::EMAIL => [config('messages.INVALID_EMAIL_PHONE')]]
            );
        }
        if (!Hash::check($attributes[self::PASSWORD], $User->password)) {
	        return $this->createResponseStructure(
                config('messages.FAILED_STATUS'), 
                Response::HTTP_UNAUTHORIZED, 
                self::RESOURCE, 
                [self::PASSWORD => [config('messages.LOGIN_PASSWORD_INVALID')]]
            );
        }
        return $this->createResponseStructure(
                config('messages.SUCCESS_STATUS'), 
                Response::HTTP_OK, 
                self::RESOURCE, 
                $this->transformResponse($User, $User->transformer)
            );
    }

    /**
     * Validate email or phone from the database
     * @author Nitesh Kaushik <nitesh.kaushik@biz2credit.com>
     *
     * @param array $attributes
     * 
     * @return string
     */
    public function isValidEmailPhone(array $attributes)
    {
        $User = $this->authEmailPhone($attributes);
        if (!$User) {
            return $this->createResponseStructure(
                config('messages.FAILED_STATUS'), 
                Response::HTTP_UNAUTHORIZED, 
                self::RESOURCE, 
                [self::EMAIL => [config('messages.INVALID_EMAIL_PHONE')]]
            );
        }
        return $this->createResponseStructure(
                config('messages.SUCCESS_STATUS'), 
                Response::HTTP_OK, 
                self::RESOURCE,
                $attributes
            );
    }

    /**
     * Private function which validate email or phone from the database
     * @author Nitesh Kaushik <nitesh.kaushik@biz2credit.com>
     *
     * @param array $attributes
     * 
     * @return string
     */
    private function authEmailPhone(array $attributes)
    {
        if(preg_match('/^[0-9]*$/', $attributes[self::EMAIL])){
            return $User = $this->User->where([User::PHONE => $attributes[self::EMAIL], User::IS_EMAIL_VERIFIED => User::VERIFIED, User::IS_PHONE_VERIFIED => User::VERIFIED])->first();
        }else{
            return $User = $this->User->where([User::EMAIL => $attributes[self::EMAIL], User::IS_EMAIL_VERIFIED => User::VERIFIED, User::IS_PHONE_VERIFIED => User::VERIFIED])->first();
        }
    }

    /**
     * Update method
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param array $attributes
     * @param int $id
     */
    public function update(array $attributes, int $id)
    {
    }

    /**
     * Delete method
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param array $ids
     */
    protected function destroy(array $ids)
    {
    }

    /**
     * Get all records method
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param array $columns
     */
    public function all($columns = array('*'))
    {
    }

    /**
     * Find method
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param int $id
     * @param array $columns
     */
    public function find(int $id, $columns = array('*'))
    {
    }

    /**
     * Delete method
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param integer $id
     */
    public function delete(int $id)
    {
    }
}

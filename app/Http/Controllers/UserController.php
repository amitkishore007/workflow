<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\B2c\Repositories\Contracts\UserInterface;
use App\B2c\Repositories\Contracts\VerificationHashInterface;

/**
 * @author Amit kishore <amit.kishore@biz2credit.com>
 */
class UserController extends Controller
{
    /**
     * @var App\B2c\Repositories\Contracts\UserInterface
     */
    protected $UserRepository;

    /**
     * @var App\B2c\Repositories\Contracts\VerificationHashInterface
     */
    protected $VerificationHashRepository;

    /**
     * @param App\B2c\Repositories\Contracts\UserInterface $user
     */
    public function __construct(UserInterface $User, VerificationHashInterface $Hash)
    {
        $this->UserRepository = $User;
        $this->VerificationHashRepository = $Hash;
    }

    /**
     * @author Amit kishore <amit.kishore@biz2credit.com>
     * 
     * @param Request $Request
     * 
     * @return string
     */
    public function otp(Request $Request)
    {
        $this->validate($Request, config('rules.v1.otp_request'));
        return $this->UserRepository->otp($Request->only(UserInterface::EMAIL, UserInterface::PHONE, UserInterface::NAME));
    }

    /**
     * @author Amit kishore <amit.kishore@biz2credit.com>
     * 
     * @param  Request $Request
     * 
     * @return string
     */
    public function register(Request $Request)
    {
        $this->validate($Request, config('rules.v1.register'));
        return $this->UserRepository->create($Request->only(UserInterface::EMAIL,UserInterface::PHONE,UserInterface::NAME,UserInterface::OTP));
    }

    /**
     * validate email/phone and password from database
     * @author Nitesh Kaushik <nitesh.kaushik@biz2credit.com>
     * 
     * @param  Request $Request
     * 
     * @return string
     */
    public function login(Request $Request)
    {
        $this->validate($Request, config('rules.v1.login'));
        return $this->UserRepository->login($Request->only(UserInterface::EMAIL,UserInterface::PASSWORD));
    }

    /**
     * vaildate email or phone.
     * @author Nitesh Kaushik <nitesh.kaushik@biz2credit.com>
     * 
     * @param  Request $Request
     * 
     * @return string
     */
    public function isEmailVerified(Request $Request)
    {
        $this->validate($Request, config('rules.v1.isEmailPhone'), [config('messages.INVALID_EMAIL_PHONE')]);
        return $this->UserRepository->isValidEmailPhone($Request->only(UserInterface::EMAIL));
    }

    /**
     * set user's password
     * @author Nitesh Kaushik <nitesh.kaushik@biz2credit.com>
     * 
     * @param  Request $Request
     * 
     * @return string
     */
    public function setpassword(Request $Request)
    {
        $this->validate($Request, config('rules.v1.setpassword'));
        return $this->VerificationHashRepository->setUserPassword($Request->only(VerificationHashInterface::PASSWORD, VerificationHashInterface::HASH));
    }
}

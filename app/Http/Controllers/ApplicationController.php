<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\B2c\Repositories\Contracts\ApplicationInterface;
use App\B2c\Repositories\Contracts\ApplicationLoanInterface;
use App\B2c\Repositories\Contracts\ApplicationOwnerInterface;
use App\B2c\Repositories\Contracts\ApplicationBasicInfoInterface;


class ApplicationController extends Controller
{

    /**
     * @var \App\B2c\Repositories\Entity\Application\ApplicationRepository
     */
    protected $ApplicationRepository;

    /**
     * @var \App\B2c\Repositories\Entity\Application\ApplicationBasicInfoInterface
     */
    protected $ApplicationBasicInfoRepository;

    /**
     * @var \App\B2c\Repositories\Entity\Application\ApplicationOwnerRepository
     */
    protected $ApplicationOwnerRepository;

    /**
     * @var \App\B2c\Repositories\Entity\Application\ApplicationOwnerRepository
     */
    protected $ApplicationLoanRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        ApplicationInterface $ApplicationRepository, 
        ApplicationOwnerInterface $ApplicationOwnerRepository,
        ApplicationLoanInterface $ApplicationLoanRepository,
        ApplicationBasicInfoInterface $ApplicationBasicInfoRepository
        )
    {
        $this->ApplicationRepository = $ApplicationRepository;
        $this->ApplicationOwnerRepository = $ApplicationOwnerRepository;
        $this->ApplicationLoanRepository = $ApplicationLoanRepository;
        $this->ApplicationBasicInfoRepository = $ApplicationBasicInfoRepository;

    }

    /**
     * @param Request $Request
     *
     * @return string
     */
    public function createApplication(Request $Request) {
        return $this->ApplicationRepository->create($Request->all());
    }

    /**
     * @param Request $Request
     *
     * @return string
     */
    public function basicInfo(Request $Request) {
        return $this->ApplicationBasicInfoRepository->create($Request->all());
    }

    /**
     * @param Request $Request
     *
     * @return string
     */
    public function ownerInfo(Request $Request) {
        return $this->ApplicationOwnerRepository->create($Request->all());
    }

    /**
     * @param Request $Request
     *
     * @return string
     */
    public function loanInfo(Request $Request) {
        return $this->ApplicationLoanRepository->create($Request->all());
    }


}
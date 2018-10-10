<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\B2c\Repositories\Contracts\ErrorsInterface;
use App\B2c\Repositories\Exceptions\CustomException;
use App\B2c\Repositories\Contracts\AppTaskFieldInterface;
use App\B2c\Repositories\Entities\Errors\ErrorsRepository;

class TaskFieldsController extends Controller
{
    /**
     * @var \App\B2c\Repositories\Entities\AppTaskRepository
     */
    protected $AppTaskFieldRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AppTaskFieldInterface $AppTaskFieldRepository)
    {
       $this->AppTaskFieldRepository = $AppTaskFieldRepository;
    }

    /**
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param Request $Request
     *
     * @return string
     */
    public function getAllTaskFields()
    {   
        return $this->AppTaskFieldRepository->all();
    }

    /**
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @return string
     */
    public function getTaskFieldBySlug(Request $request) {
        return $this->AppTaskFieldRepository->getTaskFieldBySlug($request->all());
    }

}

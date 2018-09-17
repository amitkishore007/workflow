<?php

namespace App\B2c\Repositories\Entities\Application;

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use App\B2c\Repositories\Contracts\ApiInterface;
use App\B2c\Repositories\Models\ApplicationLoan;
use App\B2c\Repositories\Entities\Api\ApiRepository;
use App\B2c\Repositories\Contracts\ApplicationLoanInterface;

/**
 * The AppProcessRepository class handles the data send from AppProcess Controller
 * and perform further validation if needed and perform database operation using required Model
 * @author Amit kishore <amit.kishore@biz2credit.com>
 */
class ApplicationLoanRepository extends ApiRepository implements ApplicationLoanInterface
{
    /**
     * @var App\B2c\Repositories\Models\ApplicationLoan
     */
    protected $ApplicationLoan;
   
    /**
     * @param AppProcess $Application
     */
    public function __construct(ApplicationLoan $ApplicationLoan)
    {
        $this->ApplicationLoan = $ApplicationLoan;
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
     * @param int $ids
     */
    public function delete(int $id)
    {
    }

    /**
    * Create method
    * @author Amit kishore <amit.kishore@biz2credit.com>
    *
    * @param array $attributes
    */
    public function create(array $attributes)
    {
        $application = $this->ApplicationLoan->create($attributes);
        return $this->createResponseStructure(
            ApiInterface::SUCCESS_STATUS,
            Response::HTTP_OK,
            'application',
            $application->toArray()
        );
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
}

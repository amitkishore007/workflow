<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\QueryException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Access\AuthorizationException;
use App\B2c\Repositories\Entities\Api\ApiRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * API Repository
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @var App\B2c\Repositories\Entities\Api\ApiRepository
     */
    protected $ApiRepository;

    /**
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param App\B2c\Repositories\Entities\Api\ApiRepository $ApiRepository
     */
    public function __construct(ApiRepository $ApiRepository)
    {
        $this->ApiRepository = $ApiRepository;
    }

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $Request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($Request, Exception $Exception)
    {
        if ($Exception instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($Exception);
        }

        if ($Exception instanceof ServerException) {
            return $this->ApiRepository->createResponseStructure('failed', Response::HTTP_INTERNAL_SERVER_ERROR, 'server_exception', config('messages.HTTP_REQUEST_FIALED'));
        }

        if ($Exception instanceof QueryException) {
            return $this->ApiRepository->createResponseStructure('failed', Response::HTTP_BAD_REQUEST, 'query_exception', ['error'=>config('messages.QUERY_ERROR')]);
        }

        return parent::render($Request, $Exception);
    }

    /**
     * Create a response object from the given validation exception.
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param  \Illuminate\Validation\ValidationException  $Exception
     * 
     * @return string
     */
    protected function convertValidationExceptionToResponse(ValidationException $Exception)
    {
        $errors = $Exception->validator->errors()->getMessages();
        return $this->ApiRepository->createResponseStructure('failed', Response::HTTP_UNPROCESSABLE_ENTITY, '', $errors);
    }
}

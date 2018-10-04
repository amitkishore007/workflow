<?php
namespace App\B2c\Repositories\Exceptions;

use Exception;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use App\B2c\Repositories\Entities\Api\ApiRepository;

class CustomException extends ExceptionHandler
{
    
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
        return $Exception->getMessage();
        // return $this->ApiRepository->createResponseStructure('failed', Response::HTTP_BAD_REQUEST, 'query_exception', ['error'=>config('messages.QUERY_ERROR')]);
    }
}

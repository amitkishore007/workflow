<?php

namespace App\B2c\Repositories\Entities\Errors;

use ReflectionClass;
use App\B2c\Repositories\Contracts\ErrorsInterface;
use App\B2c\Repositories\Entities\Api\ApiRepository;


/**
 * @author Amit kishore <amit.kishore@biz2credit.com>
 */
class ErrorsRepository extends ApiRepository implements ErrorsInterface
{
    const HTTP_OK                     = 200;
    const HTTP_CREATED                = 201;
    const HTTP_NO_CONTENT             = 204;
    const HTTP_MOVED_PERMANENTLY      = 301;
    const HTTP_NOT_MODIFIED           = 304;
    const HTTP_BAD_REQUEST            = 400;
    const HTTP_UNAUTHORIZED           = 401;
    const HTTP_FORBIDDEN              = 403;
    const HTTP_NOT_FOUND              = 404;
    const HTTP_METHOD_NOT_ALLOWED     = 405;
    const HTTP_REQUEST_TIMEOUT        = 408;
    const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
    const HTTP_UNPROCESSABLE_ENTITY   = 422;
    const HTTP_TOO_MANY_REQUESTS      = 429;
    const HTTP_INTERNAL_SERVER_ERROR  = 500;
    const HTTP_BAD_GATEWAY            = 502;
    const HTTP_SERVICE_UNAVAILABLE    = 503;
    const HTTP_GATEWAY_TIMEOUT        = 504;

    public static $statusTexts = array(
        200 => 'OK',
        201 => 'Created',
        204 => 'No Content',
        301 => 'Moved Permanently',
        304 => 'Not Modified',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        408 => 'Request Timeout',
        415 => 'Unsupported Media Type',
        422 => 'Unprocessable Entity',
        429 => 'Too Many Requests',
        500 => 'Internal Server Error',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout'
    );

    public static function errorMessage(int $statusCode, $errors) {
        $response = [
            'status' => $statusCode 
        ];
        if (array_key_exists($statusCode,self::$statusTexts)) {
            $response['errors']['code'] = self::getClassConstantName($statusCode);
        }

        if  (!empty($errors)) {
            $response['errors']['message'] = $errors;
        }
        return response()->json($response, $statusCode);
    }

    private static function getClassConstantName($code) {
        $errorsClass = new ReflectionClass(__CLASS__);
        $constants = $errorsClass->getConstants();

        $constName = null;
        foreach ($constants as $name => $value) {
            if ($value == $code) {
                $constName = $name;
                break;
            }
        }
        return $constName;
    }
}
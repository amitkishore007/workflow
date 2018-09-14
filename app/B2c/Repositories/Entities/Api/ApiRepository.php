<?php

namespace App\B2c\Repositories\Entities\Api;

use Exception;
use Illuminate\Database\Eloquent\Model;
use App\B2c\Repositories\Contracts\ApiInterface;
use App\B2c\Repositories\Entities\Api\ApiRepository;
use App\B2c\Repositories\Transformers\UserTransformer;
use App\B2c\Repositories\Exceptions\BlankDataException;

/**
 * The ApiRepository class creates and sends the Api Response
 * @author Amit kishore <amit.kishore@biz2credit.com>
 */
class ApiRepository implements ApiInterface
{
    /**
     * Set the response data.
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param string $status
     * @param int $code
     * @param string $key
     * @param array $messages
     *
     * @return string
     */
    public function createResponseStructure(string $status, int $code, string $key = '', array $messages = [])
    {
        $response = [
            ApiRepository::STATUS => $status,
            ApiRepository::CODE => $code,
        ];
        if ($code === 200 || $code === 201) {
            $response[ApiRepository::API_RESOURCE] = $key;
            $response[ApiRepository::DATA] = $messages;
        } else {
            unset($response[ApiRepository::DATA]);
            unset($response[ApiRepository::API_RESOURCE]);
            $response[ApiRepository::ERRORS] = $messages;
        }
        return response()->json(array_filter($response), $code);
    }

    /**
     * Transform the api response
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param Illuminate\Database\Eloquent\Model $Data
     * @param string $transformer
     *
     * @return array
     */
    public function transformResponse(Model $Data, string $transformer)
    {
        if (!$Data->count()) {
            return new BlankDataException('Data is empty');
        }
        
        return current(fractal($Data, $transformer)->toArray());
    }
}

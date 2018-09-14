<?php 

namespace App\B2c\Repositories\Entities\Redis;

use App\B2c\Repositories\Contracts\RedisInterface;

/**
 * The RedisRepository class implements methods to set, get and update the redis data
 * @author Amit kishore <amit.kishore@biz2credit.com>
 */
class RedisRepository implements RedisInterface
{
    /**
     * set the key:value in redis
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param  string  $key
     * @param  string  $value
    */
    public function setRedisKey(string $key, string $value, $expiration = null)
    {
        app('redis')->set($key,$value);

        if (!is_null($expiration)) {
            $this->setRedisExpiration($key, $expiration);
        }
    }

    /**
     * Get the value in redis
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param string $key
     * 
     * @return string
     */
    public function getRedisValue(string $key)
    {
        if (app('redis')->exists($key)) {
            return app('redis')->get($key);
        }

        return;
    }

    /**
     * destroy Redis Key:value
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param string $key
     * @param int $expiration
     * 
     * @return int
     */
    public function setRedisExpiration(string $key, int $expiration)
    {
        if (app('redis')->exists($key)) {
            return app('redis')->expire($key, $expiration);
        }

        return;
    }

}
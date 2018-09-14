<?php 

namespace App\B2c\Repositories\Contracts;

/**
 * @author Amit kihore <amit.kishore@biz2credit.com>
 */
interface RedisInterface 
{
    /**
     * set the key:value in redis
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param  string  $key
     * @param  string  $value
    */
    public function setRedisKey(string $key, string $value, $expiration = null);

    /**
     * Get the value in redis
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param string $key
     * 
     * @return string
     */
    public function getRedisValue(string $key);

    /**
     * destroy Redis Key:value
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param string $key
     * @param int $expiration
     * 
     * @return boolean
     */
    public function setRedisExpiration(string $key, int $expiration);
} 
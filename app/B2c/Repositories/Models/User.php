<?php

namespace App\B2c\Repositories\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use App\B2c\Repositories\Transformers\UserTransformer;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;
    const TABLE = 'users';
    const ID = 'id';
    const EMAIL = 'email';
    const PASSWORD = 'password';
    const PHONE = 'phone';
    const IS_EMAIL_VERIFIED = 'is_email_verified';
    const IS_PHONE_VERIFIED = 'is_phone_verified';
    const NAME = 'name';
    const IS_ACTIVE = 'is_active';
    
    /** Check whether user is verified or not */
    const VERIFIED = 1;
    const UNVERIFIED = 0;

    /**
     * The attribute for table name
     * 
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::NAME,
        self::PHONE, 
        self::EMAIL, 
        self::PASSWORD, 
        self::IS_EMAIL_VERIFIED,
        self::IS_PHONE_VERIFIED,
        self::IS_ACTIVE
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        self::PASSWORD,
    ];

    /**
     * @var App\B2c\Repositories\Transformers\UserTransformer
     */
    public $transformer = UserTransformer::class; 

    /**
     * Accessor Method to convert created_at timestamp into ISO8601
     * @author Amit kishore <amit.kishore@biz2credit.com>
     *
     * @param timestamp $value
     * 
     * @return string
     */
    public function getCreatedAtAttribute($value) 
    {
        $date = new \Carbon\Carbon($value);
        return $date->toIso8601String();
    }

    /**
    * Accessor Method to convert updated_at timestamp into ISO8601
    * @author Amit kishore <amit.kishore@biz2credit.com>
    *
    * @param timestamp $value
    *
    * @return string
    */
    public function getUpdatedAtAttribute($value) 
    {
        $date = new \Carbon\Carbon($value);
        return $date->toIso8601String();
    }  
    
    /**
    * Relationaship with verificationHash
    * @author Nitesh Kaushik <nitesh.kaushik@biz2credit.com>
    *
    * @return string
    */
    public function verificationHash()
    {
        return $this->hasOne('App\B2c\Repositories\Models\Verificationhash');
    }
}

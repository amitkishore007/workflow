<?php

namespace App\B2c\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use App\B2c\Repositories\Transformers\UserTransformer;

class Verificationhash extends Model
{
    const ID = 'id';
    const USERID = 'user_id';
    const HASH = 'hash';
    
    protected $table = 'verification_hashes';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::USERID, self::HASH
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
    * Set relation to user model
    * @author Nitesh Kaushik <nitesh.kaushik@biz2credit.com>
    *
    * @return string
    */
    public function user()
    {
        return $this->belongsTo('App\B2c\Repositories\Models\User');
    }
}

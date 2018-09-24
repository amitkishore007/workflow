<?php 

namespace App\B2c\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use App\B2c\Repositories\Transformers\AppProcessTransformer;

class AppProcess extends Model {
    

    const TABLE       = "app_process";
    const NAME        = "name";
    const CREATED_AT  = "created_at";
    const UPDATED_AT  = 'updated_at';
    const ORDER       = 'order';  

    protected $table = self::TABLE;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::NAME,
        self::ORDER
    ];

    /**
     * @var App\B2c\Repositories\Transformers\AppProcessTransformer
     */
    public $processTransform = AppProcessTransformer::class; 

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
    * Relation with app Task
    * @author Amit kishore <amit.kishore@biz2credit.com>
    */
    public function tasks()
    {
        return $this->hasMany('App\B2c\Repositories\Models\AppTask','process_id');
    }
    
}
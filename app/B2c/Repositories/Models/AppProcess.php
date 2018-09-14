<?php 

namespace App\B2c\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\B2c\Repositories\Transformers\AppProcessTransformer;

class AppProcess extends Model {
    
    use SoftDeletes;

    const TABLE       = "app_process";
    const PROCESS     = "process";
    const SUB_PROCESS = "sub_process";
    const TASK        = "task";
    const ORDER       = "order";
    const ACTION      = "action";
    const DELETED_AT  = "deleted_at";
    const UPDATED_AT  = "updated_at";
    const CREATED_AT  = "created_at";

    protected $table = self::TABLE;

    protected $dated = [self::DELETED_AT];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::PROCESS,
        self::ORDER, 
        self::ACTION, 
        self::SUB_PROCESS,
        self::TASK
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
}
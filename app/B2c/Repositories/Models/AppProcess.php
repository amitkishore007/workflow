<?php 

namespace App\B2c\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use App\B2c\Repositories\Transformers\AppProcessTransformer;

class AppProcess extends Model {
    

    const TABLE       = "app_process";
    const NAME        = "name";
    const PARENT_ID   = "parent_id";
    const CREATED_AT  = "created_at";

    protected $table = self::TABLE;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::NAME,
        self::PARENT_ID
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
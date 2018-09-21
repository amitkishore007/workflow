<?php

namespace App\B2c\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\B2c\Repositories\Transformers\AppProcessTransformer;

class AppTask extends Model
{
    const TABLE       = "app_tasks";

    const PROCESS_ID  = "process_id";
    const NAME        = "name";
    const ORDER       = "order";
    const ACTION      = "action";
    const PAGE        = "page"; 
    const SLUG        = "slug"; 
    const DELETED_AT  = "deleted_at";
    const UPDATED_AT  = "updated_at";
    const CREATED_AT  = "created_at";

    protected $table = self::TABLE;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::PROCESS_ID,
        self::NAME,
        self::ORDER,
        self::ACTION,
        self::PAGE,
        self::SLUG
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

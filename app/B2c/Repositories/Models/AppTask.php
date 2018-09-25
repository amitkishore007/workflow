<?php

namespace App\B2c\Repositories\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\B2c\Repositories\Transformers\AppTaskTransformer;
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
     * @var App\B2c\Repositories\Transformers\AppTaskTransformer
     */
    public $taskTransform = AppTaskTransformer::class;

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
    * Relation with app processs
    * @author Amit kishore <amit.kishore@biz2credit.com>
    */
    public function process()
    {
        return $this->belongsTo('App\B2c\Repositories\Models\AppProcess');
    }
    
    public function updateTaskOrder($attributes) {
        // $attributes = [
        //     'process_id'=>3,
        //     'data'=> [
        //         ['id'=>5, 'order'=>1],
        //         ['id'=>6, 'order'=>2]
        //     ]
        // ];
        $updated = [];
        if (!empty($attributes['data'])) {
            foreach($attributes['data'] as $attribute) {
                $updated['task_id'] = self::where('id',$attribute['id'])->update(['order'=>$attribute['order']]);
            }
        }
        return $updated;
    }
}

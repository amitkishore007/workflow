<?php

namespace App\B2c\Repositories\Models;

use Illuminate\Database\Eloquent\Model;

class AppField extends Model
{
    protected $table = 'data_rows';

    public function tasks() {
        return $this->belongsToMany('App\B2c\Repositories\Models\AppTask','data_row_app_task','data_row_id','app_task_id');
    }
}

<?php

namespace App\B2c\Repositories\Models;

use Illuminate\Database\Eloquent\Model;

class AppField extends Model
{
    protected $table = 'data_rows';

    public function task() {
        return $this->belongsTo('App\B2c\Repositories\Models\AppTask');
    }
}

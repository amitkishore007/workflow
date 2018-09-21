<?php

namespace App\B2c\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationBasicInfo extends Model
{
    protected $table = 'app_basic_info';

    protected $fillable = [
        'app_id',
        'company_name',
        'pan_number',
        'itr_income',
        'business_year',
        'company_address',
        'state',
        'city'
    ];
}

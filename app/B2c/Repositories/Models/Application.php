<?php 

namespace App\B2c\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model {
   
    protected $table = 'applications';

    protected $fillable = [
        'company_name',
        'pan_number',
        'itr_income',
        'business_year',
        'company_address',
        'state',
        'city'
    ];

}
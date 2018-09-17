<?php 

namespace App\B2c\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationOwner extends Model {
   
    protected $table = 'app_owners';

    protected $fillable = [
        "app_id",
        "name",
        "gender",
        "designation",
        "marital_status",
        "dob",
        "category",
        "nyc",// number of years in city
        "nycr"//number of years in currrent residence
    ];

}
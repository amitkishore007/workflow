<?php 

namespace App\B2c\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model {
   
    protected $table = 'applications';

    protected $fillable = [
        'user_id',
        'status'
    ];

}
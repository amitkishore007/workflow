<?php

namespace App\B2c\Repositories\Models;

use Illuminate\Database\Eloquent\Model;

class AppWorkflow extends Model
{
    protected $table = 'workflow';
    
    
    protected $fillable = [
        'task_id',
        'next_task',
        'rules'
    ];
}

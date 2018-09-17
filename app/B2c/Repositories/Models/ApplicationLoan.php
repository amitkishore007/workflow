<?php 

namespace App\B2c\Repositories\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationLoan extends Model {
   
    protected $table = 'application_loans';

    protected $fillable = [
        'app_id',
        'min_loan_amount',
        'max_loan_amount',
        'loan_tenor',
        'loan_purpose'
    ];

}
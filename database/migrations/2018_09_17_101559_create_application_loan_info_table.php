<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationLoanInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_loans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('app_id')->unsigned();
            $table->integer('min_loan_amount');
            $table->integer('max_loan_amount');
            $table->integer('loan_tenor');
            $table->string('loan_purpose');
            $table->timestamps();

            $table->foreign('app_id')->references('id')->on('applications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_loans');
    }
}

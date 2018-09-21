<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBasicInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_basic_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('app_id')->unsigned();
            $table->string('company_name');
            $table->string('pan_number');
            $table->string('itr_income');
            $table->integer('business_year');
            $table->string('company_address');
            $table->string('state');
            $table->string('city');
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
        Schema::dropIfExists('app_basic_info');
    }
}

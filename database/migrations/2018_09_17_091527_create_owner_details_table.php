<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwnerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_owners', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('app_id')->unsigned();
            $table->string('name');
            $table->string('gender');
            $table->string('designation');
            $table->string('marital_status');
            $table->string('dob');
            $table->string('category');
            $table->integer('nyc');// number of years in city
            $table->integer('nycr');//number of years in currrent residence
            
            $table->timestamps();
            
            $table->foreign('app_id')->references('id')->on('applications') ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_owners');
    }
}

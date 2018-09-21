<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppProcessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('process_id');
            $table->string('name');
            $table->integer('order');
            $table->string('action');
            $table->string('page');
            $table->string('slug');
            $table->timestamps();

            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_tasks');
    }
}

<?php

use App\B2c\Repositories\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments(User::ID)->unsigned();
            $table->string(User::NAME);
            $table->string(User::EMAIL);
            $table->string(User::PHONE,20);
            $table->string(User::PASSWORD)->nullable();
            $table->tinyInteger(User::IS_PHONE_VERIFIED)->default(User::UNVERIFIED);
            $table->tinyInteger(User::IS_EMAIL_VERIFIED)->default(User::UNVERIFIED);
            $table->tinyInteger(User::IS_ACTIVE)->default(User::UNVERIFIED);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

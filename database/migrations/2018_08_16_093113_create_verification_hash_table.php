<?php

use App\B2c\Repositories\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\B2c\Repositories\Models\Verificationhash;

class CreateVerificationHashTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verification_hashes', function (Blueprint $table) {
            $table->increments(Verificationhash::ID);
            $table->integer(Verificationhash::USERID)->unsigned();
            $table->string(Verificationhash::HASH);
            $table->timestamps();

            $table->foreign(Verificationhash::USERID)->references(User::ID)->on(User::TABLE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verification_hash');
    }
}

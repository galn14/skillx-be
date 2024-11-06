<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('followings', function (Blueprint $table) {
            $table->id('IdFollow');
            $table->unsignedBigInteger('IdFollower');
            $table->unsignedBigInteger('IdSeller');
            $table->timestamps();

            $table->foreign('IdFollower')
                  ->references('Id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('IdSeller')
                  ->references('IdSeller')
                  ->on('sellers')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('followings');
    }
};

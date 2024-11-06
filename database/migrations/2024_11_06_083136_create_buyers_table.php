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
        Schema::create('buyers', function (Blueprint $table) {
            $table->id('IdBuyer');
            $table->string('PhotoProfile', 255)->nullable();
            $table->unsignedBigInteger('UserId');
            $table->string('Universitas', 100)->nullable();
            $table->unsignedBigInteger('IdMajor')->nullable();
            $table->string('Language', 100);
            $table->timestamps();

            $table->foreign('UserId')
                  ->references('Id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('IdMajor')
                  ->references('IdMajor')
                  ->on('majors')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buyers');
    }
};

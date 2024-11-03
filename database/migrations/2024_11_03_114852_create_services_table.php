<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id('IdServices');
            $table->string('NamaServices', 100);
            $table->unsignedBigInteger('IdMajor');
            $table->string('LogoServices', 255)->nullable();
            $table->timestamps();

            $table->foreign('IdMajor')
                  ->references('IdMajor') // Corrected column reference here
                  ->on('majors')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('services');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('IdProduct');
            $table->string('NamaProduct', 100);
            $table->text('DeskripsiProduct');
            $table->string('FotoProduct', 255)->nullable();
            $table->decimal('Price', 10, 2);
            $table->unsignedBigInteger('IdMajor')->nullable();
            $table->unsignedBigInteger('ServicesId');
            $table->unsignedBigInteger('IdSeller');
            $table->timestamp('CreatedAt')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('UpdatedAt')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->foreign('IdMajor')
                  ->references('IdMajor')
                  ->on('majors')
                  ->onDelete('set null');

            $table->foreign('ServicesId')
                  ->references('IdServices')
                  ->on('services')
                  ->onDelete('cascade');

            $table->foreign('IdSeller')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};

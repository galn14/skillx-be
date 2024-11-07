<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keranjangs', function (Blueprint $table) {
            $table->id('IdKeranjang');
            $table->unsignedBigInteger('IdProduct');
            $table->unsignedBigInteger('UserId');
            $table->integer('Quantity')->check('Quantity > 0');
            $table->timestamp('AddedAt')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();

            $table->foreign('IdProduct')
                  ->references('IdProduct')
                  ->on('products')
                  ->onDelete('cascade');

            $table->foreign('UserId')
                  ->references('Id')
                  ->on('users')
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
        Schema::dropIfExists('keranjangs');
    }
};

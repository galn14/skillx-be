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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('IdReview');
            $table->unsignedBigInteger('UserId');
            $table->unsignedBigInteger('IdTransaction');
            $table->decimal('Rating', 3, 2)->checkBetween(0, 5);
            $table->text('Comment')->nullable();
            $table->timestamp('CreatedAt')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('UserId')
                  ->references('Id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('IdTransaction')
                  ->references('IdTransaction')
                  ->on('transactions')
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
        Schema::dropIfExists('reviews');
    }
};

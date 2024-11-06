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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('IdTransaction');
            $table->unsignedBigInteger('IdSeller');
            $table->unsignedBigInteger('IdSellerFeat')->nullable();
            $table->unsignedBigInteger('IdBuyer');
            $table->unsignedBigInteger('IdProduct');
            $table->decimal('Price', 10, 2);
            $table->decimal('TotalPrice', 10, 2);
            $table->enum('TransactionStatus', ['Pending', 'In Progress', 'Complete', 'Refunded'])->default('Pending');
            $table->timestamp('CreatedAt')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('UpdatedAt')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->foreign('IdSeller')
                  ->references('IdSeller')
                  ->on('sellers')
                  ->onDelete('cascade');

            $table->foreign('IdBuyer')
                  ->references('IdBuyer')
                  ->on('buyers')
                  ->onDelete('cascade');

            $table->foreign('IdProduct')
                  ->references('IdProduct')
                  ->on('products')
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
        Schema::dropIfExists('transactions');
    }
};

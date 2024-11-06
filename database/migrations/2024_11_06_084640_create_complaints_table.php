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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id('IdComplaint');
            $table->unsignedBigInteger('IdTransaction');
            $table->text('ComplaintText');
            $table->enum('Status', ['Pending', 'Resolved'])->default('Pending');
            $table->timestamp('CreatedAt')->default(DB::raw('CURRENT_TIMESTAMP'));

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
        Schema::dropIfExists('complaints');
    }
};

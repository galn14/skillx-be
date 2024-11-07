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
        Schema::create('messages', function (Blueprint $table) {
            $table->id('IdMessage');
            $table->unsignedBigInteger('SenderId');
            $table->unsignedBigInteger('ReceiverId');
            $table->string('MessageTitle')->nullable();
            $table->text('MessageContent')->nullable();
            $table->timestamp('SentAt')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();

            $table->foreign('SenderId')
                  ->references('Id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('ReceiverId')
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
        Schema::dropIfExists('messages');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLogoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_logouts', function (Blueprint $table) {
            $table->id(); // Primary key (auto-increment)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users table
            $table->timestamp('logout_time')->nullable(); // Logout time
            $table->string('ip_address')->nullable(); // Store the IP address
            $table->string('user_agent')->nullable(); // Store the User-Agent string
            $table->timestamps(); // Created at and updated at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_logouts');
    }
}

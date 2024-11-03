<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileSellerTable extends Migration
{
    public function up(): void
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id('IdSeller');
            $table->string('PhotoProfile', 255)->nullable();
            $table->foreignId('UserId')->constrained('users')->onDelete('cascade');
            $table->string('Universitas', 100);
            $table->foreignId('IdMajor')->constrained('majors', 'IdMajor')->onDelete('cascade');
            $table->string('Language', 100)->nullable();
            $table->decimal('Rating')->nullable()->check('Rating BETWEEN 0 AND 5');
            $table->integer('YearSince')->check('YearSince > = 0');
            $table->integer('Orders')->default(0);
            $table->string('Level', 50);
            $table->text('Description')->nullable();
            $table->integer('GraduationMonth')->nullable()->check('GraduationMonth BETWEEN 1 AND 12');
            $table->integer('GraduationYear');
            $table->date('GraduationValidUntil')->virtualAs('DATE_ADD(MAKEDATE(GraduationYear, 1), INTERVAL (GraduationMonth - 1) MONTH) + INTERVAL 2 YEAR');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
}

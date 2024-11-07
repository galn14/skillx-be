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
        Schema::create('portofolios', function (Blueprint $table) {
            $table->id('IdPortofolio');
            $table->unsignedBigInteger('UserId');
            $table->string('TitlePortofolio', 255);
            $table->string('DescriptionPortofolio', 255);
            $table->string('LinkPortofolio', 255);
            $table->string('PhotoPortofolio', 255);
            $table->string('TypePortofolio', 100);
            $table->string('StatusPortofolio', 100);
            $table->date('DateCreatedPortofolio');
            $table->date('DateEndPortofolio')->nullable();
            $table->boolean('IsPresentPortofolio')->default(false);
            $table->timestamps();

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
        Schema::dropIfExists('portofolios');
    }
};

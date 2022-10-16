<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_messages', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('image', 200)->nullable();
            $table->string('shortdescription', 500);
            $table->text('fulldescription')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_messages');
    }
};

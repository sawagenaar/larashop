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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->string('shortdescription', 200);
            $table->text('fulldescription')->nullable();
            $table->integer('discount')->default(0);
            $table->decimal('price', 10, 2, true)->default(0);
            $table->string('weight', 50);
            $table->string('image', 200)->nullable();
            $table->string('subcategory_slug')->nullable();
            $table->timestamps();

            $table->foreign('subcategory_slug')
                ->references('slug')
                ->on('sub_categories')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('image', 255)->nullable();
            $table->float('price', 2);
            $table->text('short_description')->nullable();
            $table->integer('qty');
            $table->string('shipping', 255)->nullable();
            $table->float('weight')->nullable();
            $table->text('description')->nullable();
            $table->text('information')->nullable();
            $table->text('reviews')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->string('slug', 255)->nullable();

            //B1:
            $table->unsignedBigInteger('product_category_id')->nullable();

            //B2:
            $table->foreign('product_category_id')->references('id')->on('product_category')
            ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};

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
        Schema::table('order_item', function (Blueprint $table) {
            // Xóa các khóa ngoại hiện tại
            $table->dropForeign(['order_id']);
            $table->dropForeign(['product_id']);

            // Thêm lại khóa ngoại với onDelete('cascade')
            $table->foreign('order_id')->references('id')->on('order')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_item', function (Blueprint $table) {
            // Xóa các khóa ngoại với cascade
            $table->dropForeign(['order_id']);
            $table->dropForeign(['product_id']);

            // Thêm lại khóa ngoại ban đầu mà không có cascade
            $table->foreign('order_id')->references('id')->on('order');
            $table->foreign('product_id')->references('id')->on('product');
        });
    }
};

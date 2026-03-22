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
        Schema::create('multi_point_detail_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('multi_point_detail_id');
            $table->unsignedBigInteger('category_id');
            $table->foreign('multi_point_detail_id')
                ->references('id')
                ->on('order_multi_point_details')
                ->onDelete('cascade');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
            $table->index(['multi_point_detail_id', 'category_id'],
                'multi_point_category_index');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('multi_point_detail_category');
    }
};

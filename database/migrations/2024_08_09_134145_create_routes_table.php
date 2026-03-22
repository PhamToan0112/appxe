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
    public function up(): void
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('driver_id');
            $table->string('start_address');
            $table->double('start_lat',10, 6);
            $table->double('start_lng',10, 6);
            $table->string('end_address');
            $table->double('end_lat',10, 6);
            $table->double('end_lng',10, 6);
            $table->decimal('price', 10, 0);
            $table->decimal('return_price', 10, 0)->nullable();
            $table->time('departure_time')->nullable();

            $table->timestamps();

            $table->foreign('driver_id')
                ->references('id')
                ->on('drivers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};

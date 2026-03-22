<?php

use App\Enums\Order\OrderType;
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
        Schema::create('recent_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->double('start_latitude', 10, 6)->nullable();
            $table->double('start_longitude', 10, 6)->nullable();
            $table->string('start_address')->nullable();
            $table->double('end_latitude', 10, 6)->nullable();
            $table->double('end_longitude', 10, 6)->nullable();
            $table->string('end_address')->nullable();
            $table->string('order_type')->default(OrderType::C_RIDE->value);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recent_locations');
    }
};

<?php

use App\Enums\OpenStatus;
use App\Enums\Shipment\OrderMultiDetailStatus;
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
        Schema::create('order_multi_point_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('weight_range_id')->nullable();
            $table->double('start_latitude', 10, 6)->nullable();
            $table->double('start_longitude', 10, 6)->nullable();
            $table->string('start_address', 255)->nullable();
            $table->double('end_latitude', 10, 6)->nullable();
            $table->double('end_longitude', 10, 6)->nullable();
            $table->string('end_address', 255)->nullable();
            $table->string('recipient_name', 255)->nullable();
            $table->string('recipient_phone', 20)->nullable();
            $table->enum('collection_from_sender_status', OpenStatus::getValues())->default(OpenStatus::OFF->value);
            $table->decimal('collect_on_delivery_amount', 10, 0)->nullable();
            $table->enum('delivery_status', OrderMultiDetailStatus::getValues())->default(OrderMultiDetailStatus::Pending->value);

            $table->timestamps();

            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
            $table->foreign('weight_range_id')
                ->references('id')
                ->on('shipping_weight_ranges')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_multi_point_details');
    }
};

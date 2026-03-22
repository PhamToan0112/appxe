<?php

use App\Enums\DeleteStatus;
use App\Enums\OpenStatus;
use App\Enums\Shipment\OrderMultiDetailStatus;
use App\Enums\Shipment\ShipmentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('sender_name', 255)->nullable();
            $table->string('sender_phone', 20)->nullable();
            $table->unsignedBigInteger('weight_range_id')->nullable();
            $table->double('start_latitude', 10, 6)->nullable();
            $table->double('start_longitude', 10, 6)->nullable();
            $table->string('start_address', 255)->nullable();
            $table->double('end_latitude', 10, 6)->nullable();
            $table->double('end_longitude', 10, 6)->nullable();
            $table->string('end_address', 255)->nullable();
            $table->string('recipient_name', 255)->nullable();
            $table->double('sender_longitude', 10, 6)->nullable();
            $table->double('sender_latitude', 10, 6)->nullable();
            $table->string('recipient_phone', 20)->nullable();
            $table->enum('collection_from_sender_status', OpenStatus::getValues())->default(OpenStatus::OFF->value);
            $table->double('distance', 8, 2)->nullable();
            $table->enum('shipment_status', ShipmentStatus::getValues())->default('unsorted');
            $table->decimal('collect_on_delivery_amount', 10, 0)->nullable();
            $table->enum('is_deleted', DeleteStatus::getValues())->default(DeleteStatus::NotDeleted->value);

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};

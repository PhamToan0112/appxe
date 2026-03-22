<?php

use App\Enums\DeleteStatus;
use App\Enums\Order\OrderType;
use App\Enums\Vehicle\LicensePlateColor;
use App\Enums\Vehicle\VehicleStatus;
use App\Enums\Vehicle\VehicleType;
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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('name');
            $table->string('color');
            $table->double('price')->nullable();
            $table->string('type')->default(VehicleType::Car4->value);
            $table->integer('seat_number')->nullable();
            $table->string('license_plate');
            $table->tinyInteger('license_plate_color')->default(LicensePlateColor::Yellow->value);
            $table->string('license_plate_image')->nullable();
            $table->string('vehicle_company')->nullable();
            $table->string('avatar')->nullable();
            $table->string('vehicle_registration_front')->nullable();
            $table->string('vehicle_registration_back')->nullable();
            $table->string('vehicle_front_image')->nullable();
            $table->string('vehicle_back_image')->nullable();
            $table->string('vehicle_side_image')->nullable();
            $table->string('vehicle_interior_image')->nullable();
            $table->string('insurance_front_image')->nullable();
            $table->string('insurance_back_image')->nullable();
            $table->text('amenities')->nullable();
            $table->text('description')->nullable();
            $table->integer('production_year')->nullable();
            $table->enum('service_type', OrderType::getValues())->default(OrderType::C_RIDE->value);
            $table->tinyInteger('status')->default(VehicleStatus::Active->value);
            $table->enum('is_deleted', DeleteStatus::getValues())->default(DeleteStatus::NotDeleted->value);
            $table->timestamps();

            $table->unsignedBigInteger('vehicle_line_id')->nullable();
            $table->foreign('vehicle_line_id')->references('id')->on('vehicle_lines')->onDelete('set null');

            $table->unsignedBigInteger('driver_id');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};

<?php

use App\Enums\Driver\AutoAccept;
use App\Enums\Driver\DriverOrderStatus;
use App\Enums\Driver\VerificationStatus;
use App\Enums\Service\ServiceStatus;
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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('area_id')->nullable();
            $table->char('id_card', 50)->unique();
            $table->string('id_card_front')->nullable();
            $table->string('id_card_back')->nullable();
            $table->string('driver_license_front')->nullable();
            $table->string('driver_license_back')->nullable();
            $table->decimal('booking_price',10, 0)->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_address')->nullable();
            $table->char('emergency_contact_phone')->nullable();
            $table->time('service_start_time')->nullable();
            $table->time('service_end_time')->nullable();
            $table->tinyInteger('auto_accept')->default(AutoAccept::Auto->value);
            $table->double('current_lat', 10, 6)->nullable();
            $table->double('current_lng', 10, 6)->nullable();
            $table->string('current_address')->nullable();
            $table->tinyInteger('order_status')->default(DriverOrderStatus::NotReceived->value);
            $table->tinyInteger('service_ride')->default(ServiceStatus::Off->value);
            $table->decimal('service_ride_price', 10, 0)->nullable();
            $table->tinyInteger('service_car')->default(ServiceStatus::Off->value);
            $table->decimal('service_car_price', 10, 0)->nullable();
            $table->tinyInteger('service_delivery_now')->default(ServiceStatus::Off->value);
            $table->decimal('service_delivery_now_price', 10, 0)->nullable();
            $table->tinyInteger('service_delivery_later')->default(ServiceStatus::Off->value);
            $table->decimal('delivery_later_fee_per_stop', 10, 0)->nullable();
            $table->tinyInteger('service_intercity')->default(ServiceStatus::Off->value);
            $table->decimal('service_intercity_price', 10, 0)->nullable();
            $table->time('service_intercity_start_time')->nullable();
            $table->time('service_intercity_end_time')->nullable();
            $table->decimal('min_earning',10, 0)->default(0);
            $table->decimal('max_earning',10, 0)->default(0);
            $table->decimal('peak_hour_price', 10, 0)->default(0);
            $table->decimal('night_time_price', 10, 0)->default(0);
            $table->decimal('holiday_price', 10, 0)->default(0);
            $table->boolean('is_verified')->default(VerificationStatus::Unverified->value);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};

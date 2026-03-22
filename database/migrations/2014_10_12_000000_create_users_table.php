<?php

use App\Enums\OpenStatus;
use App\Enums\User\AutoNotification;
use App\Enums\User\CostStatus;
use App\Enums\User\DiscountSortStatus;
use App\Enums\User\DistanceStatus;
use App\Enums\User\RatingSortStatus;
use App\Enums\User\TimeStatus;
use App\Enums\User\UserStatus;
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
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->char('code', 50);
            $table->char('username', 100)->unique()->nullable();
            $table->string('slug')->unique();
            $table->string('fullname');
            $table->char('email', 100)->unique()->nullable();
            $table->char('phone', 20)->unique()->nullable();
            $table->text('avatar')->nullable();
            $table->date('birthday')->nullable();
            $table->string('device_token')->nullable();
            $table->tinyInteger('gender');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('token_get_password')->nullable();
            $table->string('password');
            $table->tinyInteger('status')->default(UserStatus::Active->value);
            $table->integer('notification_preference')->default(AutoNotification::Auto->value);
            $table->string('bank_account_number', 50)->nullable();
            $table->enum('car_life', TimeStatus::getValues())->default(TimeStatus::Newest->value);
            $table->enum('cost_preference', CostStatus::getValues())->default(CostStatus::Lowest->value);
            $table->enum('rating_preference', RatingSortStatus::getValues())->default(RatingSortStatus::Highest->value);
            $table->enum('discount_preference', DiscountSortStatus::getValues())->default(DiscountSortStatus::Most->value);
            $table->enum('distance_preference', DistanceStatus::getValues())->default(DistanceStatus::Nearest->value);
            $table->enum('vehicle_type', VehicleType::getValues())->default(VehicleType::Motorcycle->value);
            $table->decimal('price_setting_c_car', 10, 0)->nullable();
            $table->enum('active', OpenStatus::getValues())->default(OpenStatus::OFF->value);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('area_id')->references('id')->on('areas')->onDelete('SET NULL');
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

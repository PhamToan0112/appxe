<?php

use App\Enums\DefaultStatus;
use App\Enums\OpenStatus;
use App\Enums\Order\DeliveryStatus;
use App\Enums\Order\OrderStatus;
use App\Enums\Order\OrderType;
use App\Enums\Order\PaymentRole;
use App\Enums\Order\TripType;
use App\Enums\Payment\PaymentMethod;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->decimal('discount_amount', 10, 0)->nullable();
            $table->string('code', 20);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->double('sub_total')->nullable();
            $table->decimal('platform_fee', 10, 0);
            $table->decimal('multi_point_fee', 10, 0)->nullable();
            $table->string('payment_code')->nullable();
            $table->tinyInteger('shipping_method')->nullable();
            $table->tinyInteger('payment_method')->default(PaymentMethod::Wallet->value);
            $table->text('shipping_address')->nullable();
            $table->string('order_type')->default(OrderType::C_RIDE->value);
            $table->double('total');
            $table->decimal('reference_price', 10, 0)->nullable();
            $table->dateTime('departure_time')->nullable();
            $table->dateTime('return_time')->nullable();
            $table->integer('passenger_count')->nullable();
            $table->date('delivery_date')->nullable();
            $table->time('delivery_time')->nullable();
            $table->decimal('collect_on_delivery_amount', 10, 0)->nullable();
            $table->string('status')->default(OrderStatus::Pending->value);
            $table->decimal('desired_price', 10, 0)->nullable();
            $table->decimal('high_point_area_fee', 10, 0)->default(0);
            $table->decimal('holiday_fee', 10, 0)->default(0);
            $table->decimal('night_time_fee', 10, 0)->default(0);
            $table->decimal('price_item', 10, 0)->nullable();
            $table->decimal('advance_payment_amount', 10, 0)->nullable();
            $table->enum('payment_role', PaymentRole::getValues())
                ->nullable()
                ->default(null);
            $table->enum('delivery_status', DeliveryStatus::getValues())
                ->nullable();
            $table->enum('advance_payment_status', OpenStatus::getValues())
                ->nullable();
            $table->enum('trip_type', TripType::getValues())
                ->nullable()
                ->default(null);
            $table->text('note')->nullable();
            $table->string('order_confirmation_image')->nullable();
            $table->string('return_image')->nullable();
            $table->double('current_lat', 10, 6)->nullable();
            $table->double('current_lng', 10, 6)->nullable();
            $table->string('current_address', 255)->nullable();
            $table->string('reason_cancel')->nullable();
            $table->tinyInteger('is_deleted')->default(DefaultStatus::Published->value);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('driver_id')
                ->references('id')
                ->on('drivers')
                ->onDelete('set null');
            $table->foreign('vehicle_id')
                ->references('id')
                ->on('vehicles')
                ->onDelete('set null');
            $table->foreign('discount_id')
                ->references('id')
                ->on('discounts')
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
        Schema::dropIfExists('orders');
    }
};

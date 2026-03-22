<?php

use App\Enums\Discount\DiscountSource;
use App\Enums\Discount\DiscountStatus;
use App\Enums\Discount\DiscountType;
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
        Schema::create('discounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('code', 50)->nullable();
            $table->dateTime('date_start');
            $table->dateTime('date_end');
            $table->integer('max_usage')->nullable();
            $table->double('min_order_amount')->nullable();
            $table->tinyInteger('type')->default(DiscountType::Money->value);
            $table->double('discount_value')->nullable();
            $table->double('percent_value')->nullable();
            $table->string('source')->default(DiscountSource::Admin->value);
            $table->tinyInteger('status')->default(DiscountStatus::Published->value);
            $table->tinyInteger('user_option')->nullable();
            $table->tinyInteger('driver_option')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
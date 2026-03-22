<?php

use App\Enums\ActiveStatus;
use App\Enums\Currency\Currency;
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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->double('balance', 15, 0)->default(0);
            $table->enum('currency', Currency::getValues())->default(Currency::VND->value);
            $table->enum('status', ActiveStatus::getValues())->default(ActiveStatus::Active->value);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};

<?php

use App\Enums\DefaultStatus;
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
        Schema::create('shipping_weight_ranges', function (Blueprint $table) {
            $table->id();
            $table->decimal('min_weight', 10, 0);
            $table->decimal('max_weight', 10, 0);
            $table->tinyInteger('status')->default(DefaultStatus::Published->value);
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
        Schema::dropIfExists('shipping_weight_ranges');
    }
};

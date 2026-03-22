<?php

use App\Enums\Order\TripType;
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
        Schema::create('route_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('route_id');
            $table->string('name')->nullable();
            $table->time('departure_time')->nullable();
            $table->decimal('price', 10,0);
            $table->string('start_address');
            $table->string('end_address');
            $table->enum('trip_type', TripType::getValues())
                ->default(TripType::ONE_WAY->value);

            $table->timestamps();

            $table->foreign('route_id')
                ->references('id')
                ->on('routes')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('route_variants');
    }
};

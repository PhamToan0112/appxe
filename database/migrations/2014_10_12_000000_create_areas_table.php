<?php

use App\Enums\Area\AreaStatus;
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
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('status')->default(AreaStatus::On->value);
            $table->integer('position')->default(0);
            $table->text('address')->nullable();
            $table->double('lng');
            $table->double('lat');
            $table->json('boundaries')->nullable();
            $table->decimal('fee', 10, 0)->nullable();
            $table->tinyInteger('peak_status')->default(AreaStatus::Off->value);
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
        Schema::dropIfExists('areas');
    }
};

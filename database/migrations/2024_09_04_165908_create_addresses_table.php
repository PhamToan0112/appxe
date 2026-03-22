<?php

use App\Enums\Address\AddressDefaultStatus;
use App\Enums\Address\AddressType;
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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('address');
            $table->double('latitude', 15, 10);
            $table->double('longitude', 15, 10);
            $table->enum('type', AddressType::getValues())->default(AddressType::HOME->value);
            $table->enum('default_status', AddressDefaultStatus::getValues())->default(AddressDefaultStatus::NOT_DEFAULT->value);

            $table->timestamps();

            $table->foreign('user_id')->references('id')
                ->on('users')
                ->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
};

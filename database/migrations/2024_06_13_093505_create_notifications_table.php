<?php

use App\Enums\Notification\MessageType;
use App\Enums\Notification\NotificationStatus;
use App\Enums\VerifiedStatus;
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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();


            $table->string('title');
            $table->text('message');
            $table->tinyInteger('status')->default(NotificationStatus::NOT_READ->value);
            $table->timestamp('read_at')->nullable();
            $table->enum('type', MessageType::getValues())->default(MessageType::UNCLASSIFIED->value);
            $table->text('confirmation_image')->nullable();
            $table->enum('is_verified', VerifiedStatus::getValues())->default(VerifiedStatus::Pending->value);
            $table->string('bank_account_number', 50)->nullable();
            $table->decimal('amount', 10, 0)->nullable();


            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('SET NULL');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};

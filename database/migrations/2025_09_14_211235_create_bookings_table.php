<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('car_id')->index()->nullable();
            $table->unsignedBigInteger('category_id')->index()->nullable();
            $table->unsignedBigInteger('driver_id')->index()->nullable();
            $table->string('reference_number')->unique();
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone');
            $table->string('pickup_location');
            $table->string('destination');
            $table->string('region')->nullable();
            $table->string('color')->nullable();
            $table->string('organization')->nullable();
            $table->enum('id_type', ['nida', 'passport']);
            $table->string('id_number');
            $table->datetime('pickup_date');
            $table->datetime('return_date');
            $table->text('special_requests')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed', 'taken'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};

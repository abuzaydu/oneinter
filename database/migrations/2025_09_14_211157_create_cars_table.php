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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->index();
            $table->string('name');
            $table->string('plate_number');
            $table->string('chassis_number')->nullable();
            $table->string('color')->nullable();
            $table->integer('seats')->nullable()->default(2);
            $table->decimal('daily_rate', 10, 2)->nullable();
            $table->integer('doors')->nullable()->default(2);
            $table->boolean('is_available')->default(true);
            $table->text('description')->nullable();
            $table->string('picture')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};

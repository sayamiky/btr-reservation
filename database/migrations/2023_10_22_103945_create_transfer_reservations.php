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
        Schema::create('transfer_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('reservation_code', 12)->index();
            $table->foreign('reservation_code')->references('reservation_code')->on('reservations');
            $table->unsignedBigInteger('driver_id');
            $table->foreign('driver_id')->references('id')->on('drivers');
            $table->text('pickup_location');
            $table->string('pickup_time');
            $table->text('dropoff_location');
            $table->string('dropoff_time');
            $table->integer('distance')->nullable();
            $table->integer('price')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_reservations');
    }
};

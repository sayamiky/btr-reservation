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
        Schema::create('detail_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('reservation_code', 12)->index();
            $table->foreign('reservation_code')->references('reservation_code')->on('reservations');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->enum('pax_type', ['adult', 'child']);
            $table->integer('price');
            $table->integer('discount')->default(0); //foc
            $table->integer('qty');
            $table->integer('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_reservations');
    }
};

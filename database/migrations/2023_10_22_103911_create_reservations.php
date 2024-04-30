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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('reservation_code', 12)->index()->unique();
            $table->date('reservation_date');
            $table->string('invoice_code')->nullable();
            $table->string('voucher_code')->nullable();
            $table->enum('payment_type', ['cash', 'cc']);
            $table->integer('total');
            $table->enum('status', ['not paid', 'paid', 'down payment']);
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->foreign('partner_id')->references('id')->on('partners');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};

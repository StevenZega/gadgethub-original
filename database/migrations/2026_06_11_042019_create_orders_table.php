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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('invoice_number');
            
            // Kolom pengiriman yang ditambahkan
            $table->string('receiver_name');
            $table->string('phone');
            $table->text('address');
            $table->text('notes')->nullable();

            $table->integer('subtotal');
            $table->integer('discount')->default(0);
            $table->integer('total');
            $table->string('status')->default('pending'); // pending -> paid -> shipped -> dll
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

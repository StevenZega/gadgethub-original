<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Contoh: BCAULTAH5, IPHONE20
            $table->string('name'); // Nama Event Promo
            $table->integer('discount_percent'); // Potongan dalam %
            
            // Kolom penentu Konsep Promo
            $table->string('scope')->default('all'); // Pilihan: 'all' (universal), 'category', atau 'specific'
            $table->string('category')->nullable(); // Diisi jika scope = 'category'
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade'); // Diisi jika scope = 'specific'
            
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('promos', function (Blueprint $table) {
            // Mengubah product_id menjadi nullable (bisa dikosongkan)
            $table->foreignId('product_id')->nullable()->change();
            
            // Menambahkan tipe cakupan promo: 'all', 'category', atau 'specific'
            $table->string('scope')->default('all')->after('discount_percent');
            
            // Menambahkan kolom kategori jika scope-nya adalah 'category'
            $table->string('category')->nullable()->after('scope');
        });
    }

    public function down(): void
    {
        Schema::table('promos', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable(false)->change();
            $table->dropColumn(['scope', 'category']);
        });
    }
};
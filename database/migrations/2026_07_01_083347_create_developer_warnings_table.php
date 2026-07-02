<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('developer_warnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade'); // Admin penerima
            $table->text('message'); // Isi pesan peringatan dari owner
            $table->boolean('is_read')->default(false); // Status baca admin
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('developer_warnings');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('promos', function (Blueprint $table) {
            // Menambahkan kolom admin_id setelah kolom id dan menghubungkannya ke tabel users
            $table->foreignId('admin_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('promos', function (Blueprint $table) {
            // Menghapus foreign key dan kolom jika melakukan rollback
            $table->dropForeign(['admin_id']);
            $table->dropColumn('admin_id');
        });
    }
};
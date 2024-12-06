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
        Schema::table('comments', function (Blueprint $table) {
            $table->string('image_path')->nullable(); // Adiciona a coluna image_path para armazenar o caminho da imagem
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('image_path'); // Remove a coluna image_path caso seja necessário reverter a migração
        });
    }

};

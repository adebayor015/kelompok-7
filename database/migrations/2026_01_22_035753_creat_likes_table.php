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
        Schema::create('likes', function (Blueprint $table) {
        $table->id();
        $table->integer('user_id'); // Sesuaikan dengan tipe ID di tabel users Anda
        $table->integer('question_id'); // Sesuaikan dengan tipe ID di tabel questions
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

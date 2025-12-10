<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('pertanyaans', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('question');
        $table->text('answers')->nullable();
        $table->timestamps();
    });
}

};h6e6df
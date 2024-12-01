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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('width');
            $table->integer('height');
            $table->integer('length');
            $table->text('amenities')->nullable();
            $table->integer('price_per_day');
            $table->string('images')->nullable(); // путь к фоткам номера
            $table->boolean('display_on_homepage')->nullable()->default(false); // отображать ли его на гл. стр
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};

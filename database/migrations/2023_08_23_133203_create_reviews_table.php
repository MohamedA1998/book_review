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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            $table->text('review');
            $table->unsignedTinyInteger('rating');

            // Relationship Shorter
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            
            $table->timestamps();

            // Relationship
            // $table->unsignedBigInteger('book_id');
            // $table->foreign('book_id')->references('id')->on('book')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};

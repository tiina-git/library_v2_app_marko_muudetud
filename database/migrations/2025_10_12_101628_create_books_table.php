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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('author_id')->constrained()->cascadeOnDelete(); # Seos teise mudeliga
            $table->string('title'); # Raanmatu pealkiri
            $table->year('published_year')->nullable(); # Avaldamise aasta
            $table->string('isbn')->nullable()->unique(); # ISBN kood unikaalne
            $table->unsignedInteger('pages')->nullable(); # Lehekülgede arv
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};

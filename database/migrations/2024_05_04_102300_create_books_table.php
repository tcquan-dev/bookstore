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
            $table->integer('sale_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('author_id')->nullable();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->string('image_path')->nullable();
            $table->boolean('featured')->default(false);
            $table->float('rate')->nullable();
            $table->float('price', 11, 0)->default(0);
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

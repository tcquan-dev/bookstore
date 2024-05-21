<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('book_id');
            $table->string('content')->nullable();
            $table->string('image_path')->nullable();
            $table->integer('rate');
            $table->timestamps();
        });

        DB::unprepared('
            CREATE TRIGGER update_rate_after_insert_trigger
            AFTER INSERT ON reviews
            FOR EACH ROW
            BEGIN
                DECLARE totalStars INT;
                DECLARE reviewCount INT;
                DECLARE averageRating FLOAT;

                SELECT SUM(rate), COUNT(*)
                INTO totalStars, reviewCount
                FROM reviews
                WHERE book_id = NEW.book_id;

                SET averageRating = totalStars / reviewCount;
                SET averageRating = ROUND(averageRating * 2) / 2;

                UPDATE books
                SET rate = averageRating
                WHERE id = NEW.book_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};

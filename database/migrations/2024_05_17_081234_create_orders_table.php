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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->integer('payment_method')->default(1);
            $table->boolean('payment_status')->default(false);
            $table->integer('address_id');
            $table->integer('status_id')->default(1);
            $table->integer('voucher_id')->nullable();
            $table->integer('total_price');
            $table->boolean('reviewed')->default(false);
            $table->timestamps();
        });

        DB::unprepared('
        CREATE TRIGGER delete_book_order_trigger
        AFTER DELETE ON orders
        FOR EACH ROW
        BEGIN
            DELETE FROM book_order WHERE order_id = OLD.id;
        END;'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

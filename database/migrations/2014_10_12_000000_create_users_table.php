<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('role_id')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->boolean('active')->default(false);
            $table->timestamps();
        });

        DB::unprepared('
            CREATE TRIGGER create_profile_trigger AFTER INSERT ON users FOR EACH ROW
            BEGIN
                INSERT INTO profiles (user_id, name, created_at, updated_at) VALUES (NEW.id, NEW.name, now(), now());
            END
        ');

        DB::unprepared('
        CREATE TRIGGER update_user_role_trigger BEFORE INSERT ON users FOR EACH ROW
        BEGIN
            DECLARE role_id INT;
            SELECT id INTO role_id FROM roles WHERE name = \'customer\';
            SET NEW.role_id = role_id;
        END
    ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        DB::unprepared('DROP TRIGGER IF EXISTS create_profile_trigger');
        DB::unprepared('DROP TRIGGER IF EXISTS update_user_role_trigger');
    }
};

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
        // Create `user` table to match existing database schema
        Schema::create('user', function (Blueprint $table) {
            // UUID primary key as in your screenshots
            $table->uuid('user_id')->primary();
            $table->string('user_name');
            $table->string('user_nametag')->nullable();
            $table->string('user_password_hash');
            $table->string('user_number')->nullable();
            $table->binary('user_profile_pic')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->string('user_email')->nullable()->unique();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

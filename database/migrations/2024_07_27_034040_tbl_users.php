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
        Schema::create('tbl_users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('usertype');
            $table->string('username');
            $table->string('password');
            $table->string('status')->default('active');
            $table->string('otp')->nullable();
            $table->time('otp_added_at')->nullable();
            $table->string('otp_token')->nullable();
            $table->boolean('verified')->default(false);
            $table->string('gender');
            $table->string('address');
            $table->date('bday');
            $table->string('contact');
            $table->string('team')->default('undefined');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_users');
    }
};

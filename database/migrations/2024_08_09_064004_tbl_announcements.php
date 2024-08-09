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
        Schema::create('tbl_announcements', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('announcement_name');
            $table->string('announcement_description');
            $table->string('announcement_link');
            $table->string('announcement_image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_announcements');
    }
};

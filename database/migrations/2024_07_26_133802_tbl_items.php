<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_items', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->string('item_name');
            $table->string('item_description')->nullable();
            $table->string('item_category');
            $table->integer('item_quantity');
            $table->string('item_status')->nullable();
            $table->date('expired_at')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('tbl_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_items');
    }
};

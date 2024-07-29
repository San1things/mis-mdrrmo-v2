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
        // Schema::create('tbl_inventory', function (Blueprint $table){
        //     $table->bigIncrements('id');
        //     $table->string('inventory_name');
        //     $table->string('inventory_category');
        //     $table->string('inventory_quantity');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('tbl_inventory');
    }
};

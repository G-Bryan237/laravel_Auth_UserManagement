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
        Schema::create('regions', function (Blueprint $table) {
            $table->id('RegionID');
            $table->string('RegionName', 100);
            $table->string('CountryCode', 10);
            $table->timestamp('CreatedAt')->useCurrent();
            
            // Foreign key constraint
            $table->foreign('CountryCode')->references('CountryCode')->on('Country')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regions');
    }
};

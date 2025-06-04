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
        Schema::create('schools', function (Blueprint $table) {
            $table->id('SchoolID');
            $table->string('SchoolName', 200);
            $table->string('SchoolCounty', 100)->nullable();
            $table->unsignedBigInteger('RegionID');
            $table->unsignedBigInteger('CategoryID');
            $table->string('Location', 200)->nullable();
            $table->unsignedBigInteger('ManagerID')->nullable();
            $table->timestamp('CreatedAt')->useCurrent();
        });

        // Add foreign key constraints separately to avoid ordering issues
        Schema::table('schools', function (Blueprint $table) {
            // Only add foreign keys if the referenced tables exist
            if (Schema::hasTable('regions')) {
                $table->foreign('RegionID')->references('RegionID')->on('regions')->onDelete('cascade');
            }
            if (Schema::hasTable('categories')) {
                $table->foreign('CategoryID')->references('CategoryID')->on('categories')->onDelete('cascade');
            }
            if (Schema::hasTable('managers')) {
                $table->foreign('ManagerID')->references('id')->on('managers')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};

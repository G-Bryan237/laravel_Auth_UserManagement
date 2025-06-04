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
        Schema::create('specialties', function (Blueprint $table) {
            $table->id('SpecialtyID');
            $table->string('SpecialtyName', 100);
            $table->text('Description')->nullable();
            $table->unsignedBigInteger('SchoolID');
            $table->unsignedBigInteger('ClassID');
            $table->timestamp('CreatedAt')->useCurrent();
            
            // Foreign key constraints
            if (Schema::hasTable('schools')) {
                $table->foreign('SchoolID')->references('SchoolID')->on('schools')->onDelete('cascade');
            }
            if (Schema::hasTable('school_classes')) {
                $table->foreign('ClassID')->references('id')->on('school_classes')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specialties');
    }
};

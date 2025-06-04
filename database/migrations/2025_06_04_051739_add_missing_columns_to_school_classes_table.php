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
        Schema::table('school_classes', function (Blueprint $table) {
            // Don't add ClassID since 'id' already exists as primary key
            if (!Schema::hasColumn('school_classes', 'ClassName')) {
                $table->string('ClassName', 100)->after('id');
            }
            if (!Schema::hasColumn('school_classes', 'SchoolID')) {
                $table->unsignedBigInteger('SchoolID')->after('ClassName');
            }
            // Don't add CreatedAt since created_at already exists
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_classes', function (Blueprint $table) {
            $table->dropColumn(['ClassName', 'SchoolID']);
        });
    }
};

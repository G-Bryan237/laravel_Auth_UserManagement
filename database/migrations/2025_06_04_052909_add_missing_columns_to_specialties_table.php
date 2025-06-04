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
        Schema::table('specialties', function (Blueprint $table) {
            if (!Schema::hasColumn('specialties', 'SpecialtyName')) {
                $table->string('SpecialtyName', 100)->after('id');
            }
            if (!Schema::hasColumn('specialties', 'Description')) {
                $table->text('Description')->nullable()->after('SpecialtyName');
            }
            if (!Schema::hasColumn('specialties', 'SchoolID')) {
                $table->unsignedBigInteger('SchoolID')->after('Description');
            }
            if (!Schema::hasColumn('specialties', 'ClassID')) {
                $table->unsignedBigInteger('ClassID')->after('SchoolID');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('specialties', function (Blueprint $table) {
            $table->dropColumn(['SpecialtyName', 'Description', 'SchoolID', 'ClassID']);
        });
    }
};

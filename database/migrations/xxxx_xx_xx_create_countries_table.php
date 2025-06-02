<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Check if table doesn't exist before creating
        if (!Schema::hasTable('countries')) {
            Schema::create('countries', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->string('code');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('countries');
    }
};

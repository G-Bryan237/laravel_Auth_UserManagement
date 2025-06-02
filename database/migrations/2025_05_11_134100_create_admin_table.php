<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminTable extends Migration
{
    public function up()
    {
        Schema::create('Admin', function (Blueprint $table) {
            $table->increments('AdminID');
            $table->string('FullName', 100)->nullable();
            $table->string('Email', 100)->unique();
            $table->string('PhoneNumber', 20)->nullable();
            $table->string('Whatsapp', 20)->nullable();
            $table->text('AcademicRecord')->nullable();
            $table->string('Language', 50)->nullable();
            $table->string('Gender', 10)->nullable();
            $table->string('MaritalStatus', 20)->nullable();
            $table->string('Location', 100)->nullable();
            $table->text('WorkExperience')->nullable();
            $table->string('Password', 255);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Admin');
    }
}

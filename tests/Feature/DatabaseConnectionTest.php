<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DatabaseConnectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_connection()
    {
        $this->assertTrue(DB::connection()->getPdo() !== null);
    }

    public function test_admins_table_exists()
    {
        $this->assertTrue(Schema::hasTable('admins'));
    }

    public function test_admins_table_has_required_columns()
    {
        $this->assertTrue(Schema::hasColumns('admins', [
            'id',
            'email',
            'fullname',
            'phone_number',
            'academic_record',
            'registration_completed'
        ]));
    }

    public function test_can_create_admin()
    {
        $admin = DB::table('admins')->insert([
            'email' => 'test@example.com',
            'fullname' => 'Test Admin',
            'phone_number' => '1234567890',
            'academic_record' => 'PhD',
            'registration_completed' => false
        ]);

        $this->assertTrue($admin);
        $this->assertDatabaseHas('admins', ['email' => 'test@example.com']);
    }
}

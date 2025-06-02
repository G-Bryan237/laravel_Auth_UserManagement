<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_first_step_registration()
    {
        $adminData = [
            'fullname' => 'Test Admin',
            'email' => 'test@example.com',
            'phone_number' => '1234567890',
            'whatsapp_number' => '1234567890',
            'academic_record' => 'Bachelor Degree'
        ];

        $response = $this->postJson('/api/admin/register/start', $adminData);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'token',
                    'admin'
                ]);
    }

    public function test_second_step_registration()
    {
        // Create and authenticate admin first
        $admin = Admin::factory()->create(['registration_completed' => false]);
        $token = $admin->createToken('auth_token')->plainTextToken;

        $registrationData = [
            'language' => 'English',
            'gender' => 'Male',
            'marital_status' => 'Single',
            'location' => 'New York',
            'work_experience' => '5 years'
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                        ->postJson('/api/admin/register/next', $registrationData);

        $response->assertStatus(200)
                ->assertJson(['success' => true]);
    }

    public function test_get_dropdown_data()
    {
        $response = $this->getJson('/api/admin/dropdown-data');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        'languages',
                        'genders',
                        'marital_statuses'
                    ]
                ]);
    }

    public function test_validation_error_first_step()
    {
        $response = $this->postJson('/api/admin/register/start', []);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['fullname', 'email', 'phone_number', 'academic_record']);
    }
}

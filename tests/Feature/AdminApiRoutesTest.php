<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminApiRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_start_route_exists()
    {
        $response = $this->postJson('/api/admin/register/start', []);
        $this->assertNotEquals(404, $response->status());
    }

    public function test_register_next_route_exists()
    {
        $admin = Admin::factory()->create(['registration_completed' => false]);
        $token = $admin->createToken('auth_token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                        ->postJson('/api/admin/register/next', []);
        
        $this->assertNotEquals(404, $response->status());
    }

    public function test_dropdown_data_route_exists()
    {
        $response = $this->getJson('/api/admin/dropdown-data');
        $this->assertNotEquals(404, $response->status());
    }

    public function test_unauthenticated_access_to_protected_routes()
    {
        $response = $this->postJson('/api/admin/register/next', []);
        $response->assertStatus(401);
    }

    public function test_invalid_token_access()
    {
        $response = $this->withHeader('Authorization', 'Bearer invalid_token')
                        ->postJson('/api/admin/register/next', []);
        
        $response->assertStatus(401);
    }

    public function test_register_next_requires_auth()
    {
        $data = [
            'language' => 'English',
            'gender' => 'Male',
            'marital_status' => 'Single',
            'location' => 'New York',
            'work_experience' => '5 years'
        ];

        // Test without token
        $responseWithoutToken = $this->postJson('/api/admin/register/next', $data);
        $responseWithoutToken->assertStatus(401);

        // Test with valid token
        $admin = Admin::factory()->create(['registration_completed' => false]);
        $token = $admin->createToken('auth_token')->plainTextToken;

        $responseWithToken = $this->withHeader('Authorization', 'Bearer ' . $token)
                                ->postJson('/api/admin/register/next', $data);
        
        $responseWithToken->assertStatus(200);
    }

    public function test_routes_return_correct_json_structure()
    {
        // Test dropdown data structure
        $dropdownResponse = $this->getJson('/api/admin/dropdown-data');
        $dropdownResponse->assertJsonStructure([
            'success',
            'data' => [
                'languages',
                'genders',
                'marital_statuses'
            ]
        ]);

        // Test register start structure
        $registerData = [
            'fullname' => 'Test Admin',
            'email' => 'test@example.com',
            'phone_number' => '1234567890',
            'academic_record' => 'PhD'
        ];
        
        $registerResponse = $this->postJson('/api/admin/register/start', $registerData);
        $registerResponse->assertJsonStructure([
            'success',
            'message',
            'token',
            'admin'
        ]);
    }
}

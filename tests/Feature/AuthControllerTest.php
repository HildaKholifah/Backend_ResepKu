<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_auth_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Latip',
            'email' => 'latip@test.com',
            'password' => 'Latip123',
            'password_confirmation' => 'Latip123'
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'email' => 'latip@test.com'
        ]);
    }

    public function test_auth_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123')
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password123'
        ]);

        $response->assertStatus(200);
    }

    public function test_auth_logout()
    {
        $user = User::factory()->create();

        $token = $user->createToken('test-token');

        $response = $this
            ->withHeader(
                'Authorization',
                'Bearer '.$token->plainTextToken
            )
            ->postJson('/api/logout');

        $response->assertStatus(200);
    }
}
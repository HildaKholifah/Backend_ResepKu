<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_update()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->postJson('/api/profile/update', [
                'name' => 'Latip Baru',
                'email' => 'latip@test.com'
            ]);

        $response->assertStatus(200);
    }

    public function test_profile_change_password()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123')
        ]);

        $response = $this
            ->actingAs($user)
            ->postJson('/api/change-password', [
                'current_password' => 'password123',
                'new_password' => 'password456',
                'new_password_confirmation' => 'password456'
            ]);

        $response->assertStatus(200);
    }

    public function test_profile_get()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->getJson('/api/profile');

        $response->assertStatus(200);
    }
}
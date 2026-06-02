<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoriteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_favorite()
    {
        $user = User::factory()->create();

        $recipe = Recipe::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this
            ->actingAs($user)
            ->postJson(
                "/api/favorites/{$recipe->id}"
            );

        $response->assertStatus(201);
    }

    public function test_remove_favorite()
    {
        $user = User::factory()->create();

        $recipe = Recipe::factory()->create([
            'user_id' => $user->id
        ]);

        $user->favorites()->attach($recipe->id);

        $response = $this
            ->actingAs($user)
            ->deleteJson(
                "/api/favorites/{$recipe->id}"
            );

        $response->assertStatus(200);
    }
}
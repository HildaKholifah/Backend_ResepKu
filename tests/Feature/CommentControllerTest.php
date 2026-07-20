<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_comment()
    {
        $user = User::factory()->create();

        $recipe = Recipe::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this
            ->actingAs($user)
            ->postJson(
                "/api/recipes/{$recipe->id}/comments",
                [
                    'comment' => 'Resep sangat enak'
                ]
            );

        $response->assertStatus(200);
    }
}
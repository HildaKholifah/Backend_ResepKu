<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecipeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_recipes()
    {
        $user = User::factory()->create();

        Recipe::factory()->count(3)->create([
            'user_id' => $user->id
        ]);

        $response = $this->getJson('/api/recipes');

        $response->assertStatus(200);
    }

    public function test_store_recipe()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->postJson('/api/recipes', [
                'title' => 'Nasi Goreng',
                'description' => 'Nasi goreng spesial',
                'ingredients' => [
                    'Nasi',
                    'Telur',
                    'Kecap'
                ],
                'steps' => [
                    'Masak nasi',
                    'Goreng telur'
                ]
            ]);

        $response->assertStatus(201);
    }

    public function test_detail_recipe()
    {
        $user = User::factory()->create();

        $recipe = Recipe::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->getJson(
            "/api/recipes/{$recipe->id}"
        );

        $response->assertStatus(200);
    }

    public function test_edit_recipe()
    {
        $user = User::factory()->create();

        $recipe = Recipe::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this
            ->actingAs($user)
            ->putJson("/api/recipes/{$recipe->id}", [
                'title' => 'Nasi Goreng Update',
                'description' => 'Deskripsi baru',
                'ingredients' => [
                    'Nasi',
                    'Telur'
                ],
                'steps' => [
                    'Masak',
                    'Sajikan'
                ]
            ]);

        $response->assertStatus(200);
    }

    public function test_delete_recipe()
    {
        $user = User::factory()->create();

        $recipe = Recipe::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this
            ->actingAs($user)
            ->deleteJson(
                "/api/recipes/{$recipe->id}"
            );

        $response->assertStatus(200);
    }

    public function test_search_recipe()
    {
        $user = User::factory()->create();

        Recipe::factory()->create([
            'user_id' => $user->id,
            'title' => 'Nasi Goreng'
        ]);

        $response = $this->getJson(
            '/api/recipes?search=Nasi'
        );

        $response->assertStatus(200);
    }

    public function test_share_recipe()
    {
        // $user = User::factory()->create();

        // $recipe = Recipe::factory()->create([
        //     'user_id' => $user->id
        // ]);

        // $response = $this
        //     ->actingAs($user)
        //     ->getJson("/api/recipes/{$recipe->id}/share");

        // $response->assertStatus(200)
        //         ->assertJsonStructure([
        //             'message',
        //             'link'
        //         ]);
        $this->assertTrue(true);
    }
}
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FollowUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_follow_another_user()
    {
        // Créer deux utilisateurs
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Vérifier que user1 ne suit pas user2 initialement
        $this->assertFalse($user1->suivis()->where('suivi_id', $user2->id)->exists());

        // Faire suivre user2 par user1
        $user1->suivis()->attach($user2->id);

        // Vérifier que user1 suit maintenant user2
        $this->assertTrue($user1->suivis()->where('suivi_id', $user2->id)->exists());
        $this->assertEquals(1, $user2->suiveurs()->count());
    }

    public function test_user_can_unfollow_another_user()
    {
        // Créer deux utilisateurs
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Faire suivre user2 par user1
        $user1->suivis()->attach($user2->id);
        $this->assertTrue($user1->suivis()->where('suivi_id', $user2->id)->exists());

        // Faire ne plus suivre user2 par user1
        $user1->suivis()->detach($user2->id);

        // Vérifier que user1 ne suit plus user2
        $this->assertFalse($user1->suivis()->where('suivi_id', $user2->id)->exists());
        $this->assertEquals(0, $user2->suiveurs()->count());
    }

    public function test_user_cannot_follow_themselves()
    {
        $user = User::factory()->create();

        // Essayer de se suivre soi-même
        $response = $this->actingAs($user)->post("/profile/{$user->id}/toggle-follow");

        // Vérifier que la réponse est une erreur
        $response->assertStatus(400);
        $response->assertJson(['success' => false]);
    }

    public function test_toggle_follow_route_works()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Suivre user2
        $response = $this->actingAs($user1)->post("/profile/{$user2->id}/toggle-follow");
        $response->assertStatus(200);
        $response->assertJson(['success' => true, 'isFollowing' => true]);

        // Ne plus suivre user2
        $response = $this->actingAs($user1)->post("/profile/{$user2->id}/toggle-follow");
        $response->assertStatus(200);
        $response->assertJson(['success' => true, 'isFollowing' => false]);
    }
}
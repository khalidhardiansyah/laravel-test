<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCRUDTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_user()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'age' => 30,
            'password' => 'Sdffdgfg343@2ecret123', 
        ];

        $response = $this->postJson('/api/users', $data);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     "message"=>"berhasil dibuat"
                 ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
        ]);
    }

    public function test_can_get_user_list()
    {
        User::factory()->count(3)->create();

        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_can_get_single_user()
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'name' => $user->name,
                     'email' => $user->email,
                     'age' => $user->age,
                 ]);
    }

    public function test_can_update_user()
    {
        $user = User::factory()->create();

        $updateData = [
            'name' => 'Updated Name',
            'age' => 35,
        ];

        $response = $this->putJson("/api/users/{$user->id}", $updateData);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     "message"=>"berhasil diupdate"
                 ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'age' => 35,
        ]);
    }

    public function test_can_delete_user()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}

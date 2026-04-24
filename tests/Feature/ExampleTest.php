<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_root_redirects_to_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    public function test_home_redirects_guest_to_login(): void
    {
        $response = $this->get('/home');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_home(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/home');

        $response->assertOk();
    }

    public function test_multiple_users_can_login_with_their_own_credentials(): void
    {
        $userOne = User::factory()->create([
            'email' => 'user1@example.com',
            'password' => Hash::make('secret123'),
        ]);

        $userTwo = User::factory()->create([
            'email' => 'user2@example.com',
            'password' => Hash::make('secret456'),
        ]);

        $this->post('/login', [
            'email' => 'user1@example.com',
            'password' => 'secret123',
        ])->assertRedirect('/todos');

        $this->assertAuthenticatedAs($userOne);

        $this->post('/logout')->assertRedirect('/login');

        $this->post('/login', [
            'email' => 'user2@example.com',
            'password' => 'secret456',
        ])->assertRedirect('/todos');

        $this->assertAuthenticatedAs($userTwo);
    }
}

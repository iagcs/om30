<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_success(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => $user->password,
        ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'email',
                'access_token',
                'expires_in',
                'created_at',
                'updated_at',
            ]);
    }

    public function test_login_fail_email_required(): void
    {
        $this->post('/login', [
            'email' => '',
            'password' => fake()->password(8),
        ])
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'email' => 'The email field is required.',
            ]);
    }

    public function test_login_email_invalid(): void
    {
        $this->post('/login', [
            'email' => fake()->name,
            'password' => fake()->password(8),
        ])
            ->assertSessionHasErrors([
                'email' => 'The email field must be a valid email address.',
            ]);
    }

    public function test_login_fail_password_required(): void
    {
        $this->post('/login', [
            'email' => fake()->email,
            'password' => '',
        ])
            ->assertSessionHasErrors([
                'password' => 'The password field is required.',
            ]);
    }

    public function login_fail_password_min_characteres(): void
    {
        $this->post('/login', [
            'email' => fake()->email,
            'password' => fake()->password(5, 7),
        ])
            ->assertSessionHasErrors([
                'password' => 'The password must be at least 8 characters.',
            ]);
    }

    public function test_logout(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $this->get('/logout')->assertStatus(204);
    }
}

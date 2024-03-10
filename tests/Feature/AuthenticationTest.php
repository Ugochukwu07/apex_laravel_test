<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Enums\UserRoleEnum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    // use RefreshDatabase;

    /** @test */
    public function test_user_can_register()
    {
        $rand = rand(1,100);
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Test User',
            'email' => "test{$rand}@example.com",
            'password' => 'password',
        ]);

        $response->assertStatus(201);
    }

    /** @test */
    public function user_can_login()
    {
        User::factory()->create([
            "email" => "testx@example.com",
            'password' => bcrypt('password'),
            'roles' => UserRoleEnum::User->value
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'testx@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'email',
                'token',
                'role',
                'token_type'
            ],
            'status'
        ]);
    }

    public function testUserCanLoginWithCorrectCredentials()
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response
        ->assertStatus(200)
        ->assertJson([
            'success' => true,
        ]);
    }
}

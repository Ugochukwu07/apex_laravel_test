<?php

namespace Tests\Feature;

use App\Enums\UserRoleEnum;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserManagementTest extends TestCase
{
    /** @test */
    public function test_can_list_all_users()
    {
        $this->actingAsAdmin();
        $id = rand(1,9999);
        $user = User::factory()->create([
            'email' => "email{$id}@gmail.com"
        ]);
        $token = $user->createToken('TestToken')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', '/api/v1/user/users', [], $headers);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'email',
                            'role',
                            'created_at'
                        ]
                    ],
                    'status'
                 ]);
    }

    /** @test */
    public function can_view_a_user()
    {
        $this->actingAsAdmin();
        $id = rand(1,9999);
        $user = User::factory()->create([
            'email' => "email{$id}@gmail.com",
            'roles' => UserRoleEnum::Admin->value
        ]);
        $token = $user->createToken('TestToken')->plainTextToken;
        $headers = ['Authorization' => "Bearer $token"];
        $user_id = User::all()->first()->id;

        $response = $this->json('GET', "api/v1/admin/user/one/{$user_id}", [], $headers);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'id',
                        'name',
                        'email',
                        'role',
                        'created_at'
                    ],
                    'status'
                ]);
    }


}

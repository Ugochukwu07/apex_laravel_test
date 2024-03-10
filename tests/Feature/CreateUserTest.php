<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateUserTest extends TestCase
{
    public function setUp(): void{
        parent::setUp();

        // Refresh the database before each test
        Artisan::call('migrate:refresh');
    }
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    public function test_api_can_register(): void{
        $response = $this->post('/api/v1/user/users', [
            'name' => 'John Doe',
            'email' => 'jonhdoe.1@gmail.com',
            'password' => 'password123'
        ], [
            'Accept' => 'application/json'
        ]);
        $response->assertStatus(201);
    }
}

<?php

namespace Tests;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function actingAsUser()
    {
        // $user = User::find(1); // Or create a user
        $user = User::factory()->create([
            'password' => bcrypt('i-love-laravel'),
            'roles' => UserRoleEnum::User->value
        ]);
        $this->actingAs($user, 'api');
    }

    protected function actingAsAdmin()
    {
        $user = User::factory()->create([
            'password' => bcrypt('i-love-laravel'),
            'roles' => UserRoleEnum::Admin->value
        ]);
        $admin = User::where('roles', UserRoleEnum::Admin->value)->first();
        $this->actingAs($admin, 'api');
    }
}

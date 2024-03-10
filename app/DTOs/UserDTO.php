<?php
namespace App\DTOs;

use App\Enums\UserRoleEnum;

class UserDTO{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string|null $password,
        public readonly bool $is_admin = false,
    )
    {}

    public function toArray(){
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'roles' => $this->is_admin ? UserRoleEnum::Admin->value : UserRoleEnum::User->value
        ];
    }
}

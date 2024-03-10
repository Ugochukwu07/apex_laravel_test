<?php
namespace App\Actions;

use App\Models\User;
use App\Enums\UserRoleEnum;

class CreateUserAction{
    public array $data;
    public bool $is_admin;

    public function __construct(){
        $this->is_admin = false;
    }

    //set user information
    public function setData(array $data){
        $this->data = $data;
        return $this;
    }

    public function asAdmin(){
        $this->is_admin = true;
        return $this;
    }

    public function execute(){
        return User::create([
            'name' => $this->data['name'],
            'email' => $this->data['email'],
            'password' => $this->data['password'],
            'roles' => $this->is_admin ? UserRoleEnum::Admin->value : UserRoleEnum::User->value
        ]);
    }
}

<?php
namespace App\Actions;

use App\Models\User;
use App\Enums\UserRoleEnum;
use Exception;

class UpdateUserAction{
    public array $data;
    public bool $is_admin;
    public int $user_id;

    public function __construct()
    {
        $this->is_admin = false;
    }

    public function setUserId(int $id){
        $this->user_id = $id;
        return $this;
    }

    //set user information
    public function setData(array $data){
        $this->data = $data;
        return $this;
    }

    public function markAsAdmin(){
        $this->is_admin = true;
        return $this;
    }

    private function setPassword(User $user){
        if(isset($this->data['password'])){
            return $this->data['password'];
        }

        return $user->password;
    }

    public function execute(){
        $user = User::find($this->user_id);

        $updated = $user->update([
            'name' => $this->data['name'],
            'email' => $this->data['email'],
            'password' => $this->setPassword($user),
            'role' => $this->is_admin ? UserRoleEnum::Admin->value : $user->role
        ]);


        if($updated){
            $user->refresh();

            return $user;
        }

        throw new \Exception('Something Went wrong');
    }
}

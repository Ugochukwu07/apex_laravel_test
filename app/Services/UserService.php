<?php
namespace App\Services;

use App\Actions\UpdateUserAction;
use App\Models\User;

class UserService{
    public function updateUser(int $user_id, array $data, bool $is_admin = false): User{
        $user = (new UpdateUserAction())->setUserId($user_id)->setData($data);
        if($is_admin){
            $user = $user->markAsAdmin();
        }

        return $user->execute();
    }
}

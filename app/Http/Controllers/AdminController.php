<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\DTOs\UserDTO;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Helper\ResponseHelper;
use App\Actions\CreateUserAction;
use App\Http\Resources\UserResource;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;

class AdminController extends Controller
{
    public function __construct(
        protected CreateUserAction $createUserAction,
        protected UserService $userService
    ){}

    public function allUsers(){
        $users = User::all();

        return ResponseHelper::dataResponse(UserResource::collection($users), "List All Users");
    }

    public function getOneUser(User $user){
        return ResponseHelper::dataResponse(UserResource::make($user), "User {$user->name}'s profile");
    }

    public function createUser(CreateUserRequest $request){
        $data = (new UserDTO(
            $request->validated('name'),
            $request->validated('email'),
            $request->validated('password'),
        ))->toArray();

        $user = $this->createUserAction->setData($data);

        if(isset($request->admin) && $request->admin == "on"){
            $user = $user->asAdmin();
        }
        $user = $user->execute();

        return ResponseHelper::dataResponse(data:UserResource::make($user), message:"User: {$user->name}'s Created", status:201, code: 201);
    }

    public function updateUser(UpdateUserRequest $request, User $user){
        $data = (new UserDTO(
            $request->validated('name'),
            $request->validated('email'),
            $request->validated('password'),
        ))->toArray();

        $user = $this->userService->updateUser($user->id, $data, (isset($request->admin) && $request->admin == "on"));

        return ResponseHelper::dataResponse(UserResource::make($user), 'User Updated', status: 201, code: 201);
    }

    public function deleteUser(User $user){
        $user->delete();

        return ResponseHelper::response(message:'User Deleted', status:201, code:201);
    }
}

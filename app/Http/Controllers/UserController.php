<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\DTOs\UserDTO;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;
use App\Actions\CreateUserAction;
use App\Actions\UpdateUserAction;
use App\Http\Resources\UserResource;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(
        protected CreateUserAction $createUserAction,
        protected UpdateUserAction $updateUserAction,
        protected UserService $userService
    ){}

    public function index()
    {
        // Get all users: Services can be used when a lot of business logic is required
        $users = User::all();

        $user_data = UserResource::collection($users);

        return ResponseHelper::dataResponse($user_data, "All Users");
    }

    // Get a specific user by ID
    public function show($id){
        $user = User::find($id);
        if (!$user) return ResponseHelper::response404("User");

        return ResponseHelper::dataResponse(UserResource::make($user), "{$user->name}'s Information");
    }

    // Create a new user
    public function store(CreateUserRequest $request)
    {
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

        return ResponseHelper::dataResponse(UserResource::make($user), "{$user->name}'s Created", 201, code: 201);
    }

    // Update a specific user
    public function update(UpdateUserRequest $request, User $user){
        $data = (new UserDTO(
            $request->validated('name'),
            $request->validated('email'),
            $request->validated('password'),
        ))->toArray();

        $user = $this->userService->updateUser($user->id, $data);

        return ResponseHelper::dataResponse(UserResource::make($user), 'Your Profile is Updated', status: 201, code: 201);
    }

    // Delete a specific user
    public function destroy($id){
        $user = User::find($id);
        if (!$user) return ResponseHelper::response404("User");

        $user->delete();

        return ResponseHelper::response('User Deleted', 204, code:204);
    }
}

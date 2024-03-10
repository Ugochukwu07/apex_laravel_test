<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\DTOs\UserDTO;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;
use App\Actions\CreateUserAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\CreateUserRequest;

class AuthenticateController extends Controller
{
    public function __construct(
        protected CreateUserAction $createUserAction
    ){}


    public function login(LoginRequest $request){
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return ResponseHelper::response('Invalid Login Credentials', 401, false, 401);
        }

        $user = Auth::user();
        $token = $user->createToken('MyApp')->plainTextToken;

        return ResponseHelper::dataResponse([
            'id' => $user->id,
            'email' => $user->email,
            'token' => $token,
            'role' => $user->roles,
            'token_type' => "Bearer"
        ]);
    }

    public function register(CreateUserRequest $request){
        $data = (new UserDTO(
            $request->validated('name'),
            $request->validated('email'),
            $request->validated('password'),
        ))->toArray();

        $user = $this->createUserAction->setData($data)->execute();

        return ResponseHelper::dataResponse(UserResource::make($user), "{$user->name}'s Registered", 201, code: 201);
    }
}

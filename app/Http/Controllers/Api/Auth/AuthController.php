<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @OA\Post (
     *     path="/api/auth/register",
     *     tags={"auth"},
     *     @OA\Parameter(
     *          name="name",
     *          description="Name",
     *          required=true,
     *          in="query",
     *      ),
     *     @OA\Parameter(
     *          name="email",
     *          description="Email",
     *          required=true,
     *          in="query",
     *      ),
     *     @OA\Parameter(
     *          name="password",
     *          description="Password",
     *          required=true,
     *          in="query",
     *      ),
     *     @OA\Parameter(
     *          name="password_confirmation",
     *          description="Password Confirmation",
     *          required=true,
     *          in="query",
     *      ),
     *      @OA\Response(response="200", description="Register a user.", @OA\JsonContent()),
     * )
     */
    public function register(AuthRegisterRequest $request)
    {
        User::create($request->validated());
        return response()->json(['message' => 'Successfully created']);
    }
    /**
     * @OA\Post (
     *     path="/api/auth/login",
     *     tags={"auth"},
     *     @OA\Parameter(
     *          name="email",
     *          description="Email address",
     *          required=true,
     *          in="query",
     *      ),
     *     @OA\Parameter(
     *          name="password",
     *          description="Password",
     *          required=true,
     *          in="query",
     *      ),
     *     @OA\Response(response="200", description="Login a user.", @OA\JsonContent()),
     * )
     */
    public function login(AuthLoginRequest $request)
    {
        $credentials = request(['email', 'password']);
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $tokenResult = $user->createToken('MyApp')->accessToken;
            return response(['user' => $user, 'tokenResult' =>  $tokenResult->token]);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }

    }
    /**
     * @OA\Post (path="/api/auth/logout",
     *   tags={"auth"},
     *   summary="Logs out current logged in user session",
     *   description="",
     *   operationId="logoutUser",
     *   parameters={},
     *     @OA\Response(
     *         response=200,
     *         description="Success with some route data"
     *     ),
     *   security={
     *     {"bearerAuth": {}},
     *   },
     * )
     */
    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }


}

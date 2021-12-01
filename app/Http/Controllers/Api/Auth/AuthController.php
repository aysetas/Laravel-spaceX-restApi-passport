<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    /**
     * @OA\Post (
     *     path="/api/register",
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
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>$request->password
        ]);

        $token = $user->createToken('LaravelAuthApp')->accessToken;

        return response()->json(['token' => $token], 200);
    }
    /**
     * @OA\Post (
     *     path="/api/login",
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
    public function login(Request $request)
    {
        $validator = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
//        dd(auth()->attempt(['email' => request('email'), 'password' => \request('password')]));
        if (!auth()->attempt($validator)) {
            return response()->json(['error' => 'Unauthorised'], 401);
        } else {
            $success['token'] = auth()->user()->createToken('authToken')->accessToken;
            $success['user'] = auth()->user();
            return response()->json(['success' => $success])->setStatusCode(200);
        }

    }
    /**
     * @OA\Post (path="/api/logout",
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
        if (Auth::check()) {
             Auth::user()->AauthAcessToken()->delete();
        }
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

}

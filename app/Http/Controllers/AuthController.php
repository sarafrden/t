<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use GuzzleHttp\Client;

class AuthController extends Controller
{

    /**
     * @OA\Post(
     *      path="api/register",
     *      operationId="Insert Users",
     *      tags={"Auth"},
     *      summary="Insert new User",
     *      description="Returns User data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     * )
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone_number' => 'required|string|unique:users',
            'password' => 'required|string',
            'email' => 'required|string',
            'type' => 'required|string',
        ]);
        $user = new User([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'password' => bcrypt($request->password),
            'email' => $request->email,
            'type' => $request->type,
        ]);
        $user->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    /**
         * @OA\Post(
         *      path="api/login",
         *      operationId="Login User",
         *      tags={"Auth"},
         *      summary="Login User",
         *      description="Returns Access token",
         *      @OA\RequestBody(
         *          required=true,
         *          @OA\JsonContent(ref="#/components/schemas/User")
         *      ),
         *      @OA\Response(
         *          response=201,
         *          description="Successful operation",
         *          @OA\JsonContent(ref="#/components/schemas/User")
         *       ),
         *      @OA\Response(
         *          response=400,
         *          description="Bad Request"
         *      ),
         * )
         */

    public function login(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['phone_number', 'password']);
        if(!Auth::attempt(['phone_number' => request('phone_number'), 'password' => request('password')]))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Logout user (Revoke the token)

        */
        /**
         * @OA\Get(
         *      path="api/auth/logout",
         *      operationId="logoutUser",
         *      tags={"Auth"},
         *      summary="logout User",
         *      description="Returns logout",
         *      @OA\Response(
         *          response=200,
         *          description="Successful operation",
         *          @OA\JsonContent(ref="#/components/schemas/User")
         *       ),
         *      @OA\Response(
         *          response=400,
         *          description="Bad Request"
         *      ),
         *   security={
         *         {
         *             "api_key": {},
         *         }
         *     },
         * )
         */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User

     */
    /**
         * @OA\Get(
         *      path="api/auth/user",
         *      operationId="authenticatedUser",
         *      tags={"Auth"},
         *      summary="Get the authenticated User",
         *      description="Returns user info",
         *      @OA\RequestBody(
         *          required=true,
         *          @OA\JsonContent(ref="#/components/schemas/User")
         *      ),
         *      @OA\Response(
         *          response=200,
         *          description="Successful operation",
         *          @OA\JsonContent(ref="#/components/schemas/User")
         *       ),
         *      @OA\Response(
         *          response=400,
         *          description="Bad Request"
         *      ),
         *   security={
        *         {
        *             "api_key": {},
        *         }
        *     },
         * )
         */

    public function user(Request $request)
    {
        return response()->json($request->user());
    }


}

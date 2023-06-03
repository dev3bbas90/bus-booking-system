<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\API\ApiBaseController;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends ApiBaseController
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * @OA\Post(
     * path="/api/auth/login",
     * description="Authenticate User and return bearer Token",
     * tags={"Authentication"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass User data(email , password)",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email"   , type="email"   , format="email", example="user@user.com"),
     *       @OA\Property(property="password", type="password", format="email", example="123456"),
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\Property(property="message"   , type="string" , example="success" ),
     *    @OA\Property(property="data"      , type="array",
     *       @OA\Items(
     *          @OA\Property(property="access_token", type="string"  , format="text", description="bearer token used to authenticate apis"),
     *          @OA\Property(property="token_type"  , type="string"  , format="text", description="Token type"),
     *          @OA\Property(property="expires_in"  , type="integer"                , description="expires after these minutes"),
     *       )
     *    )
     * ),
     * @OA\Response(
     *    response=400,
     *    description="if any error happened",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="error"),
     *       @OA\Property(property="errors", type="string" , example="Ann error occured" ),
     *    )
     * )
     * )
    */
    public function login(LoginRequest $request)
    {
        try {

            $credentials = request(['email', 'password']);
            if (! $token = auth('api')->attempt($credentials)) {
                return $this->error('Wrong Email Or Password' , 'error' , 401);
            }
            return $this->success( $this->tokenRespond($token) );
        }
        catch (JWTException $e)
        {
            return $this->error('Ann Error Occured. please, try again later' , 'error' , Response::HTTP_BAD_REQUEST );
        }
    }

    /**
     * @OA\Get(
     *     path="/api/auth/profile",
     *     description="retrieve authed user profile",
     *     tags={"Authentication"},
     *     security={{ "jwt": {} }} ,
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\Property(property="message"   , type="string" ,  example="success" ),
     *    @OA\Property(property="data"      , type="object" ,  ref="#/components/schemas/User" )
     * ),
     * @OA\Response(
     *    response=400,
     *    description="If any error happened",
     *    @OA\JsonContent(
     *       @OA\Property(property="message" , type="string" , example="error"),
     *       @OA\Property(property="errors"  , type="string" , example="Not Authenticated" ),
     *    )
     * )
     * )
    */
    public function profile()
    {
        $user = new UserResource(auth('api')->user());
        return $this->success($user);
    }

    /**
     * @OA\Post(
     * path="/api/auth/logout",
     * description="logout Authenticated User",
     * tags={"Authentication"},
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\Property(property="message"   , type="string" , example="Logged out Suuccessfully" ),
     *    @OA\Property(property="data"      , type="string"   )
     * ),
     * @OA\Response(
     *    response=400,
     *    description="if any error happened",
     *    @OA\JsonContent(
     *       @OA\Property(property="message" , type="string" , example="error"),
     *       @OA\Property(property="errors"  , type="string" , example="Not Authenticated" ),
     *    )
     * )
     * )
    */
    public function logout()
    {
        try {
            auth('api')->logout();
            return $this->success('Successfully logged out');
        }
        catch (JWTException $e)
        {
    return $this->error('Ann Error Occured. please, try again later', 'error', Response::HTTP_BAD_REQUEST);
}
    }

    /**
     * @OA\Post(
     * path="/api/auth/refresh",
     * description="refresh Authenticated User token.",
     * tags={"Authentication"},
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\Property(property="message"   , type="string" , example="success" ),
     *    @OA\Property(property="data"      , type="array",
     *       @OA\Items(
     *          @OA\Property(property="access_token", type="string"  , format="text", description="bearer token used to authenticate apis"),
     *          @OA\Property(property="token_type"  , type="string"  , format="text", description="Token type"),
     *          @OA\Property(property="expires_in"  , type="integer"                , description="expires after these minutes"),
     *       )
     *    )
     * ),
     * @OA\Response(
     *    response=400,
     *    description="if any error happened",
     *    @OA\JsonContent(
     *       @OA\Property(property="message" , type="string" , example="error"),
     *       @OA\Property(property="errors"  , type="string" , example="Not Authenticated" ),
     *    )
     * )
     * )
    */
    public function refresh()
    {
        try {
            $token = auth()->guard('api')->refresh();
            return $this->success( $this->tokenRespond($token) );
        }
        catch (JWTException $e)
        {
            return $this->error('Ann Error Occured. please, try again later' , 'error' , Response::HTTP_BAD_REQUEST );
        }
    }

    /**
     * Get the token array structure used only in this class.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
    */
    private function tokenRespond($token)
    {
        return [
            'access_token'  => $token,
            'token_type'    => 'bearer',
            'expires_in'    => auth('api')->factory()->getTTL() * 60 * 24
        ];
    }

}

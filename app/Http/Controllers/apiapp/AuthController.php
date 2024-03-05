<?php

namespace App\Http\Controllers\apiapp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\RegisterRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Userapp;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function register(RegisterRequest $request): JsonResponse{
        $data = $request->validated();

        Userapp::create($data);
        if (! $token= auth()->guard('api')->attempt(['email'=>$data['email'],'password'=>$data['password']])){
            return $this->ApiResponse(['error'=>'Unauthorized'],'error',401);
        }
        return $this->ApiResponse($this->respondWithToken($token),'Successfully registertion !');
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->guard('api')->attempt($credentials)) {
            return $this->ApiResponse(null,'Unauthorized', 401);
        }

        return $this->ApiResponse($this->respondWithToken($token),'Successfully !');
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->ApiResponse(auth()->guard('api')->user(),'Succefully !');
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->guard('api')->logout();

        return $this->ApiResponse( null,'Successfully logged out');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->ApiResponse($this->respondWithToken(auth()->guard('api')->refresh()),"Successed !");
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token): Array
    {
        return [
            'Username'=> auth()->guard('api')->user()->name,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard('api')->factory()->getTTL() * 60
        ];
    }

    Protected function ApiResponse($data=null,$msg=null,$status=200): JsonResponse{
        if ($data){
            return response()->json([
                "Data"=>$data,
                "MSG"=>$msg,
                "Status"=>$status
            ],$status);
        }
        
        return response()->json([
            "Msg"=>$msg,
            'Status'=>$status
        ],$status);
    }
}

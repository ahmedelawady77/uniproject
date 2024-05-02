<?php

namespace App\Http\Controllers\apiapp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
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
        $user = Userapp::create($data);
        $credentials = ["email" => $request->email,'password'=>$request->password];
        if ($user){
            $token = auth()->guard('api')->attempt($credentials);
            return $this->ApiResponse($this->respondWithToken($token));
        }
        return $this->ApiResponse();
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        $token = auth()->guard('api')->attempt($credentials);
        if ($token) {
            return $this->ApiResponse($this->respondWithToken($token));
        }
        
        return $this->ApiResponse(['Msg'=>'failled','errors' => 'Wrong in Credentials']);
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

        return $this->ApiResponse( ['Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->ApiResponse($this->respondWithToken(auth()->guard('api')->refresh()));
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
            'id'=>auth()->guard('api')->user()->id,
            'Username'=> auth()->guard('api')->user()->name,
            'email'=>auth()->guard('api')->user()->email,
            'access_token' => $token,
            'Msg' => 'Success'
            // 'token_type' => 'bearer',
            // 'expires_in' => auth()->guard('api')->factory()->getTTL() /60/24/365 ." year"
        ];
    }

    protected function attempt ($email,$password): bool | array| Userapp {
        $user = Userapp::where('email',$email)->first();
        if ($user && hash::check($password,$user->password)){
            $data = [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'Msg' => 'Sucess'
            ];

            // dd($data);
            return $data;
        }
        return false;
    }

    protected function apiwithresponse (){}

    Protected function ApiResponse($data=null): JsonResponse{
      return response()->json($data);
    }
}

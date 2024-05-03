<?php

namespace App\Http\Controllers\apiapp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ForgetPasswordReqest;
use App\Http\Requests\Api\OtpvalidateRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Models\Userapp;
use App\Notifications\ResetPasswordVerficationNotifaction;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class ForgetPassword extends Controller
{
    private $otp;

    public function __construct(){
        $this->otp = new Otp;
    }

    public function forgetpassword(ForgetPasswordReqest $request){
        $email = $request->validated();
        $userapp = Userapp::where('email',$email['email'])->first();

        if (!$userapp){
            $this->ApiResponse(null,'Not Found',404);
        }
        // try {
        //     $userapp->notify(new ResetPasswordVerficationNotifaction());
        // } catch (\Throwable $th) {
        //     return $this->ApiResponse($th,'error');
        // }
        $otp = $this->otp->generate($email['email'],"numeric");
        
        return $this->ApiResponse(null,'success');
    }

    public function validateotp(OtpvalidateRequest $request):JsonResponse{
        $data = $request->validated();
        return $this->check($data['email'],$data['Otp']);
    }

    public function resetpassword(ResetPasswordRequest $request){
        $data = $request->validated();
        return $this->check($data['email'],null,$data['password']);

    }

    protected function ApiResponse($data,$msg): JsonResponse{
        if (!$data){
            
            return response()->json([
              'Msg' => $msg,  
            ]);

        }

        return response()->json([
            'data' => $data,
            'Msg' => $msg,
        ]);
    }

    protected function check ($email,string $userapp_otp=null,$password=null){
        $user = Userapp::where('email',$email)->first();
        
        if(!$user){
            return $this->ApiResponse(null,'Not found',404);
        }

        if ($userapp_otp && !$password){
            $check = $this->otp->validate($email,$userapp_otp);
            if ($check->status){
                return $this->ApiResponse(null,'success');
            }
            return $this->ApiResponse(null,'failled');
        }

        if ($password){
            $otp=$this->otp;
            $status = $otp->testvalidate($email);

            if ($status){
                $user->update(['password' => Hash::make($password)]);
                $user->tokens()->delete();
                $otp->deletetoken($email);
                return $this->ApiResponse(null,'success change password');
            }
            return $this->ApiResponse(null,'faillled');

        }
        return $this->ApiResponse(null,'Success');
    }
}

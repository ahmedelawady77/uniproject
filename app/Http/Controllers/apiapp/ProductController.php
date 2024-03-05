<?php

namespace App\Http\Controllers\apiapp;

use App\Http\Controllers\Controller;
use App\Models\products;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth:api');
    }

    protected function ApiResponse($data=null,$msg=null,$status=200): JsonResponse{
        if ($data){

            return response()->json([
                'Data'=>$data,
                'Message'=>$msg,
                'Status'=>$status
            ],$status);
        }

        return response()->json([
            'Message'=>$msg,
            'Status'=>$status
        ],$status);
    }

    public function index(){
        $data = products::get();

        if ($data){
            return $this->ApiResponse($data,'Successed');
        }

        return $this->ApiResponse(null,'No Data',401);
    }


    public function show($id): JsonResponse{
        $data = products::find($id);
        if ($data){
            return $this->ApiResponse($data,'Successed !');
        }
        return $this->ApiResponse(null,'Not found',404);
    }
}

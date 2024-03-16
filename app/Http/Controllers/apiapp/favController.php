<?php

namespace App\Http\Controllers\apiapp;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Favorite_item;
use App\Models\products;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class favController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    protected function ApiResponse($data = null, $msg = null, $status = 200): JsonResponse
    {
        if ($data) {
            return response()->json([
                'Data' => $data,
                'Message' => $msg,
                'Status' => $status,
            ]);
        }

        return response()->json(['Message' => $msg, "status" => $status]);
    }

    public function makefavitem(Request $request): JsonResponse
    {
        $userapp_id = auth()->guard('api')->user()->id;
        $fav_id = $this->fav_id($userapp_id);
        $data = ($request->validate(['product_id'=>'required'],[],['product_id'=>'product_id']));
        $pro_id = (int) ($data['product_id']);
        $check = products::find($data)->toArray();
        $check2 = $this->check($fav_id,$pro_id);
        if ($check && $check2) {
            $input = ['favorite_id' => $fav_id, 'product_id' => $pro_id];

            $result = Favorite_item::create($input);
            return $this->ApiResponse($result,"Successed !");
        }
        return $this->ApiResponse(null,"Not Found",404);
    }

    public function delfavitem($id): JsonResponse{
        $userapp_id = auth()->guard('api')->user()->id;
        $fav_id = $this->fav_id($userapp_id);
        $pro_id = (int) ($id);
        $check = products::find($pro_id)->toArray();
        $check2 = $this->check($fav_id,$pro_id);

        if($check && !$check2){

            $result = Favorite_item::where('favorite_id',$fav_id)->where('product_id',$pro_id)->delete();
            return $this->ApiResponse($result,'succeded');
        }
        return $this-> ApiResponse(null,'faild',401);
    }

    public function getfavitem(): JsonResponse{
        $userapp_id = auth()->guard("api")->user()->id;

        $fav_id = $this->fav_id($userapp_id);
        // to get all things about fav_items and products
            $result = Favorite_item::where('favorite_id',$fav_id)->with('products')->get(); 
        // to get all specifc columns about the 2 table [products,favorite_items]
            // $result = Favorite_item::where('favorite_id',$fav_id)->with('products:id,name,price,description')->get(['id','favorite_id','product_id']);
        if ($result){

            return $this->ApiResponse($result,"Successed");
        }
        else{
            return $this->ApiResponse(null,'No Favorite Items');
        }

    }

    protected function fav_id($userapp_id=null): int{
        $data = Favorite::where("userapp_id",$userapp_id)->get("id")->toArray(); 
        if($data){
            return (int)($data[0]['id']);
        }
        else{
            $data = Favorite::create(['userapp_id'=>$userapp_id]);
            return (int) $data['id'];
        }
    }

    protected function check(int $fav_id, int $pro_id): bool{
        $data = Favorite_item::where('favorite_id',$fav_id)->where('product_id',$pro_id)->get()->toArray();

        if($data){
            return false;
        }
        return true;
    }
}

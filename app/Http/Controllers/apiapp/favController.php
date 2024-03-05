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
        $pro_id = $request->validate(['product_id'=>'required|numeric|unique:favorite_items,product_id'],[],['product_id'=>'product_id']);
        $check = products::find($pro_id)->toArray();

        if ($check) {
            $input = ['favorite_id' => $fav_id, 'product_id' => (int) $pro_id["product_id"]];

            $result = Favorite_item::create($input);
            return $this->ApiResponse($result,"Successed !");
        }
        return $this->ApiResponse(null,"Not Found",404);
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
            return $data['id'];
        }
    }
}

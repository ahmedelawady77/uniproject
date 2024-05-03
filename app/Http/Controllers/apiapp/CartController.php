<?php

namespace App\Http\Controllers\apiapp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddtocardRequest;
use App\Models\Cart;
use App\Models\Cart_item;
use App\Models\products;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api');
    }

    public function Addtocart(AddtocardRequest $request){
        $data = $request->validated();
        $userapp_id = auth()->guard('api')->user()->id;
        $cartid = $this->cartid($userapp_id);
        $product_id = products::find($data['product_id']);
        $check = $this->check($cartid,$product_id);
        if ($check && $product_id){
            $input = ['cart_id' => $cartid,'product_id' => $product_id['id'] ,'quantity' => $data['quantity']];
            $result = Cart_item::create($input);
            return $this->ApiResponse($result,'Succeded');
        }
        return $this->ApiResponse(null,'Not Found',404);
    }

    public function GetCartitems(){
        $userapp_id = auth()->guard('api')->user()->id;
        $cart_id = ($this->cartid($userapp_id));
        if ($cart_id){
            $items = Cart_item::where('cart_id',$cart_id)->get();
            $items = $items->map(function($item){
                $newItem = [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'product_name' => $item->products->name,
                    'product_price' => $item->products->price,
                    'product_image' => $item->products->image->file_name
                ];
                return $newItem;
            });
            
            if ($items){

                return $this->ApiResponse($items,'Succeced'); 
            }
            return $this->ApiResponse(null,'NO Items Here');

        }
        return $this->ApiResponse(null,'Not Found',404);
    }

    public function Deletefromcart($id){
        $userapp_id = auth()->guard('api')->user()->id;
        $cartid = $this->cartid($userapp_id);
        
        if($item = Cart_item::find((int)$id)){
            $item->delete();
            return $this->ApiResponse(null,'success');
        }
        return $this->ApiResponse(null,"failled");
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

    protected function cartid($userapp_id): int{
        $check = Cart::where('userapp_id',$userapp_id)->first();
        
        if ($check){
            return (int) $check['id'];
        }
        
        $cartid = Cart::create(['userapp_id' => $userapp_id]);
        return (int) $cartid['id'];
    }

    protected function check ($cartid,$pro_id): bool{
        $check = Cart_item::where('cart_id',$cartid)->where('product_id',$pro_id)->first();
        
        if (!$check){
            return true;
        }
        return false;
    }
}

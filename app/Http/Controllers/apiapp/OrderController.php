<?php

namespace App\Http\Controllers\apiapp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OrderRequest;
use App\Models\Cart_item;
use App\Models\orders as Order;
use App\Models\orders_details as Order_item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth:api');
    }

    public function show(): JsonResponse{
        $order = Order::get();

        return $this->ApiResponse($order,'Success !');
    }

    public function makeorder(): JsonResponse{
        $user_app_id = auth()->guard('api')->user()->id;
        $cartitems = CartController::GetCartitems1($user_app_id);
        if(!$cartitems->isEmpty()){
            $totalorder = 0;
            foreach($cartitems as $item){
                $totalorder+= $item['product_price'] * $item['quantity'];
            }
            $data = [
                'userapp_id' => auth()->guard('api')->user()->id,
                'order_total' => $totalorder,
            ];

            $order = Order::create($data);

            foreach($cartitems as $item){
                $items = [
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_price' => $item['product_price'],
                    'product_qty' => $item['quantity'],
                    'subtotal' => $item['product_price'] * $item['quantity']
                ];
                Order_item::create($items);
                CartController::removefromcart($item['product_id'],$user_app_id);
            }

            return $this->ApiResponse(null,'Order Added :)');
        }
        return $this->ApiResponse(null,'No Items In Cart');
        
    }

    protected function ApiResponse($data = null, $Msg = null, $status = 200): JsonResponse{
        if ($data){
            return response()->json([
                'Data' => $data,
                'Message' => $Msg,
                'Status' => $status
            ],$status);
        }
        return response()->json([
            'Message' => $Msg,
            'Status' => $status
        ],$status);
    }
}

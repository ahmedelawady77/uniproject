<?php

namespace App\Http\Controllers\apiapp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OrderRequest;
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

    public function makeorder(OrderRequest $request): JsonResponse{
        $data = [
            'userapp_id' => auth()->guard('api')->user()->id,
            'order_total' => $request->input('order_total'),
        ];

        $order = Order::create($data);

        foreach($request->order_items as $order_item){
            $items = [
                'order_id' => $order->id,
                'product_id' => $order_item['product_id'],
                'product_price' => $order_item['price'],
                'product_qty' => $order_item['amount'],
                'subtotal' => $order_item['subtotal']
            ];
            Order_item::create($items);
        }

        return $this->ApiResponse(null,'Order Added :)');
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

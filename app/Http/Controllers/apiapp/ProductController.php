<?php

namespace App\Http\Controllers\apiapp;

use App\Http\Controllers\Controller;
use App\Models\categories;
use App\Models\products;
use App\Models\Favorite;
use App\Models\Favorite_item;
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
        $userapp_id = auth()->id();
        $fav_id = favController::fav_id($userapp_id);
        $favorites = favController::favorites($fav_id);

        // dd($favorites);
        $products = products::getProducts($favorites);

        // $products = $products->map(function ($product) use ($favorites){
                
            //     $item = [
            //         'id' => $product->id,
            //         'product_name' => $product->name,
            //         'product_price' => $product->price,
            //         'descerption' => $product->description,
            //         'maincategory' => $product->maincategoryi->maincategory,
            //         'category' => $product->category->categoryname,
            //         'namebrand' => $product->user->namebrand,
            //         'Product_image' => $product->image->file_name,
            //         'is_favorite' => in_array($product->id,$favorites) 
            //     ];
            //     return $item;
            // });

        if ($products){
            return $this->ApiResponse($products,'Successed');
        }

        return $this->ApiResponse(null,'No Data',401);
    }


    public function show($id): JsonResponse{
        $userapp_id = auth()->id();
        $fav_id = favController::fav_id($userapp_id);
        $favorites = favController::favorites($fav_id, $id);
        $product = products::getProduct($id,$favorites);
        
        if ($product){
            return $this->ApiResponse($product,'Successed !');
        }
        return $this->ApiResponse(null,'Not found',404);
    }

    public function categorie(string $categ): JsonResponse{
        $array = categories::where('categoryname',$categ)->get('id')->pluck('id')->toArray();
        if ($array){
            $cate_id = $array[0];
            $userapp_id = auth()->id();
            $fav_id = favController::fav_id($userapp_id);
            $favorites = favController::favorites($fav_id);
            $result = products::getCateProducts($cate_id,$favorites);
            // $result = $result->map(function ($product) use ($favorites){
                
                //     $item = [
                //         'id' => $product->id,
                //         'product_name' => $product->name,
                //         'product_price' => $product->price,
                //         'descerption' => $product->description,
                //         'maincategory' => $product->maincategoryi->maincategory,
                //         'category' => $product->category->categoryname,
                //         'namebrand' => $product->user->namebrand,
                //         'Product_image' => $product->image->file_name,
                //         'is_favorite' => in_array($product->id,$favorites) 
                //     ];
                //     return $item;
                // });
            return $this ->ApiResponse($result,'Succeded !');
        }

        return $this->ApiResponse(null,'Not found :(');

    }



}

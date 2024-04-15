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
        $fav_id = $this-> fav_id($userapp_id);
        $favorites = $this->favorites($fav_id);
        $products = products::inRandomOrder()->get();

        $products = $products->map(function ($product) use ($favorites){
            
            $item = [
                'id' => $product->id,
                'product_name' => $product->name,
                'product_price' => $product->price,
                'descerption' => $product->description,
                'maincategory' => $product->maincategoryi->maincategory,
                'category' => $product->category->categoryname,
                'namebrand' => $product->user->namebrand,
                'Product_image' => $product->image->file_name,
                'is_favorite' => in_array($product->id,$favorites) 
            ];
            return $item;
        });

        if ($products){
            return $this->ApiResponse($products,'Successed');
        }

        return $this->ApiResponse(null,'No Data',401);
    }


    public function show($id): JsonResponse{
        $userapp_id = auth()->id();
        $fav_id = $this->fav_id($userapp_id);
        $favorites = $this->favorites($fav_id, $id);
        $product = products::find($id);
        
        if ($product){
                $newitem = [
                    'id' => $product->id,
                    'product_name' => $product->name,
                    'product_price' => $product->price,
                    'descerption' => $product->description,
                    'maincategory' => $product->maincategoryi->maincategory,
                    'category' => $product->category->categoryname,
                    'namebrand' => $product->user->namebrand,
                    'Product_image' => $product->image->file_name,
                    'is_favorite' => $favorites
                ];
            return $this->ApiResponse($newitem,'Successed !');
        }
        return $this->ApiResponse(null,'Not found',404);
    }

    public function categorie(string $categ): JsonResponse{
        $array = categories::where('categoryname',$categ)->get('id')->pluck('id')->toArray();
        if ($array){
            $cate_id = $array[0];
            $userapp_id = auth()->id();
            $fav_id = $this-> fav_id($userapp_id);
            $favorites = $this->favorites($fav_id);
            $result = products::where('category_id',$cate_id)->get();
            $result = $result->map(function ($product) use ($favorites){
            
                $item = [
                    'id' => $product->id,
                    'product_name' => $product->name,
                    'product_price' => $product->price,
                    'descerption' => $product->description,
                    'maincategory' => $product->maincategoryi->maincategory,
                    'category' => $product->category->categoryname,
                    'namebrand' => $product->user->namebrand,
                    'Product_image' => $product->image->file_name,
                    'is_favorite' => in_array($product->id,$favorites) 
                ];
                return $item;
            });
            return $this ->ApiResponse($result,'Succeded !');
        }

        return $this->ApiResponse(null,'Not found :(');

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

    protected function favorites(int $fav_id=null,int $pro_id=null): array|bool{
        if ($pro_id === null)
        {
            return Favorite_item::where('favorite_id',$fav_id)->get('product_id')->pluck('product_id')->toArray();
        }
        else
        {
            $status = Favorite_item::where('favorite_id',$fav_id)->where('product_id',$pro_id)->get('product_id')->pluck('product_id')->toArray();
            if ($status)
            {
                return true;
            }
            return false;
        }
    }
}

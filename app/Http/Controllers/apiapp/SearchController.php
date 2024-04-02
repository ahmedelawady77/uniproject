<?php

namespace App\Http\Controllers\apiapp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SearchRequest;
use App\Models\maincategories;
use App\Models\products;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(SearchRequest $request){
        $query = $request->input('query');
        $maxprice = $request->input('maxprice');
        $minprice = $request->input('minprice');
        $gander = $request->input('gander');
        $products = products::query();

        if($query){

            $products->where(function($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', '%'.$query.'%')
                             ->orWhere('description', 'like', '%'.$query.'%');
            });
        }  

        if($gander) {
            $array = maincategories::where('maincategory',$gander)->get('id')->pluck('id')->toArray();
            if($array){
                $maincat_id = $array[0];
                $products->where('maincategory_id',$maincat_id);
            }   
        }

        if($maxprice && $minprice){
            $products->whereBetween('price',[$minprice,$maxprice]);
        }

        $result = $products->get();
        return $this-> ApiResponse($result,'Succeded');

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
    
}

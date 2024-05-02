<?php

namespace App\Models;

use App\Models\User;
use App\Models\categories;
use App\Models\ProductImage;
use App\Models\maincategories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class products extends Model
{
    use HasFactory;
    protected $fillable =
    [
    'name' ,
    'price' ,
    'category_id' ,
    'maincategory_id' ,
    'description' ,
    'namebrand' ,
    ];
      // One To One get category of product
    public function category()
    {
        return $this->belongsTo(categories::class,'category_id');
    }
    public function maincategoryi()
    {
    return $this->belongsto(maincategories::class,'maincategory_id');
    } 
    public function image()
    {
    return $this->hasOne(ProductImage::class, 'product_id', 'id'); 
    }
    public function user(){
      return $this->belongsTo(User::class,'namebrand');
    }

    public static function getProducts($favorites){
      return self::inRandomOrder()
      ->select([
          'products.id',
          'products.name as product_name',
          'products.price as product_price',
          'products.description as description',
          'maincategory_id as maincategory_id',
          'maincategories.maincategory as maincategory',
          'category_id',
          'categories.categoryname as category',
          'products.namebrand',
          'users.namebrand as Name Of Brand',
          'product_images.file_name as product_image',
          \DB::raw('IF(products.id IN (' . implode(',', $favorites) . '), 1, 0) as is_favorite')
      ])
      ->leftJoin('maincategories', 'maincategory_id', '=', 'maincategories.id')
      ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
      ->leftJoin('users', 'products.namebrand', '=', 'users.id')
      ->leftJoin('product_images', 'products.id', '=', 'product_images.id')
      // ->with(['user', 'maincategoryi', 'category', 'image']) // Eager load related models
      ->get();

    }

    public static function getProduct($pro_id,$favorites){
      return self::find($pro_id)
                  ->select([
                      'products.id',
                      'products.name as product_name',
                      'products.price as product_price',
                      'products.description as description',
                      'maincategory_id as maincategory_id',
                      'maincategories.maincategory as maincategory',
                      'category_id',
                      'categories.categoryname as category',
                      'products.namebrand',
                      'users.namebrand as Name Of Brand',
                      'product_images.file_name as product_image',
                      // \DB::raw('IF(products.id IN (' . implode(',', $favorites) . '), 1, 0) as is_favorite')
                  ])
                  ->leftJoin('maincategories', 'maincategory_id', '=', 'maincategories.id')
                  ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                  ->leftJoin('users', 'products.namebrand', '=', 'users.id')
                  ->leftJoin('product_images', 'products.id', '=', 'product_images.id')
                  // ->with(['user', 'maincategoryi', 'category', 'image']) // Eager load related models
                  ->get()->map(function ($item) use($favorites){
                    $item->is_favorite = $favorites;
                    return $item;}
                  );

    }
    public static function getCateProducts($cate_id,$favorites){
      return self::where('category_id',$cate_id)
                  ->select([
                      'products.id',
                      'products.name as product_name',
                      'products.price as product_price',
                      'products.description as description',
                      'maincategory_id as maincategory_id',
                      'maincategories.maincategory as maincategory',
                      'category_id',
                      'categories.categoryname as category',
                      'products.namebrand',
                      'users.namebrand as Name Of Brand',
                      'product_images.file_name as product_image',
                      \DB::raw('IF(products.id IN (' . implode(',', $favorites) . '), 1, 0) as is_favorite')
                  ])
                  ->leftJoin('maincategories', 'maincategory_id', '=', 'maincategories.id')
                  ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                  ->leftJoin('users', 'products.namebrand', '=', 'users.id')
                  ->leftJoin('product_images', 'products.id', '=', 'product_images.id')
                  // ->with(['user', 'maincategoryi', 'category', 'image']) // Eager load related models
                  ->get();

    }


} 

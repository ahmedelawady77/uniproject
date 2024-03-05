<?php

namespace App\Models;

use App\Models\User;
use App\Models\products;
use App\Models\categories;
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
    // public function namebrand()
    // {
    // return $this->hasOne(User::class,'namebrand');
    // }
} 

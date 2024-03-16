<?php

namespace App\Models;

use App\Models\products;
use App\Models\Favorite;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite_item extends Model
{
    use HasFactory;

    
    protected $fillable=[
        'favorite_id',
        'product_id'
    ];

    public function favorite(){
        return $this->belongsTo(Favorite::class,'favorite_id');
    }

    public function products(){
        return $this->belongsTo(products::class,'product_id');
    }


}

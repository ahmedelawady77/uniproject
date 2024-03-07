<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart_item extends Model
{
    use HasFactory;

    protected $fillable = ['cart_id','product_id','quantity'];

    public function cart(){
        return $this->belongsTo(Cart::class,'cart_id');
    }

    public function products(){
        return $this->belongsTo(products::class,'product_id');
    }
}

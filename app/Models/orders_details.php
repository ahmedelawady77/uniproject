<?php

namespace App\Models;

use App\Models\products;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class orders_details extends Model
{
    use HasFactory;
    protected $fillable =
    [ 
    'order_id' ,  // 3
    'product_id' , // 1 2 
    'product_qty' , // 2 2 
    'product_price' , // 100 200
    'subtotal' , // 200 100  300
    ];
// public function productid()
//  {
//  return $this->belongsTo(products::class, 'userapp_id'); 
//  }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Foundation\Auth\Userapp;
use App\Models\Userapp;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class orders extends Model
{
    use HasFactory;
    protected $fillable =
    [
    'userapp_id' ,
    'date' ,
    'order_total' ,
    'is_delivered' ,
    ];

 public function userappid()
 {
 return $this->belongsTo(Userapp::class,'userapp_id'); 
 }
//  public function item()
//  {
//   return $this->hasMany(orders_details::class,'order_id');
//  }

}

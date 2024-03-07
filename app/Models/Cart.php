<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['userapp_id'];

    

    public function userapps(){
        return $this->belongsTo(Userapp::class,'userapp_id');
    }
}

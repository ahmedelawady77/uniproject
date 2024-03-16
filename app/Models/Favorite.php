<?php

namespace App\Models;
use App\Models\Userapp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable=[
        'userapp_id',
    ];

    public function userapp(){
        return $this->belongsTo(Userapp::class,'userapp_id');
    }
}

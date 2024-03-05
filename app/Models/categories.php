<?php

namespace App\Models;

use App\Models\products;
use App\Models\maincategories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class categories extends Model
{
    use HasFactory;
    protected $fillable =
    [
    'categoryname' ,
    ];
    
    public function categoriy()
    {
        return $this->hasMany(products::class);
    }

}

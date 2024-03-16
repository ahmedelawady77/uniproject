<?php

namespace App\Models;

use App\Models\products;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'product_name',
        'created_by',
        'product_id',
    ];

    // public function productphoto()
    // {
    //     return $this->belongsTo(products::class);
    // }
}

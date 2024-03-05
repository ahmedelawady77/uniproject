<?php

namespace App\Models;

use App\Models\categories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class maincategories extends Model
{
    use HasFactory;
    protected $fillable =
    [
    'maincategory' ,
    ];

    public function maincategoryi()
    {
    return $this->hasMany(products::class);
    }
}

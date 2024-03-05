<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class regsterUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'namebrand',
        'phone',
    ];
}

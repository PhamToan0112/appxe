<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorySystem extends Model
{
    use HasFactory;
    protected $table = 'category_systems'; // Kết nối đến bảng category_systems trong Database
    protected $guarded = [];
    protected $casts = [];
}



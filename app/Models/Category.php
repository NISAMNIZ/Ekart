<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded =[];

    function subcategory(){
        return $this->hasMany(Subcategory::class,'category_id');
    }

    function productCategory(){
        return $this->hasMany(Product::class,'category_id');
    }
}

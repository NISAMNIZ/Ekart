<?php

use App\Models\Category;

function getCategories(){
    $categories = Category::orderBy('id','desc')->with('subcategory')->where('show_home','yes')->get();
    return $categories;
}
?>
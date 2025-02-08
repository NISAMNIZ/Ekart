<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ShopController 
{
    public function shopIndex(Request $request,$categorySlug = null,$subcategorySlug = null)
    {
        // dd($request->all());
        $categorySelected = '';
        $subCategorySelected = '';
        $product = Product::where('status',true);
        //apply filter
        if(!empty($categorySlug))
        {
            $category = Category::where('slug',$categorySlug)->first();
            $product = Product::where('category_id',$category->id);
            $categorySelected = $category->id;
        }
        if(!empty($subcategorySlug))
        {
            $subcategory = SubCategory::where('slug',$subcategorySlug)->first();
            $product = Product::where('sub_category_id',$subcategory->id);
            $subCategorySelected = $subcategory->id;
        }

        $brandsArray = [];
        if(!empty($request->get('brand'))) {
        $brandsArray = explode(',',$request->get('brand'));
        $product = Product::whereIn('brand_id',$brandsArray);
        }
        if($request->get('price_min') != '' && $request->get('price_max') != '' ){
            if($request->get('price_max') == 1000){
                $product = $product->whereBetween('price',[intval($request->get('price_min')), 1000000]);
            }
            else
            $product = $product->whereBetween('price',[intval($request->get('price_min')), intval($request->get('price_max'))]);
        }
        if($request->get('sort') != '' ){
            if($request->get('sort') == 'latest'){
                $product = $product->orderBy('id','desc');
            }elseif($request->get('sort') == 'price_low'){
                $product = $product->orderBy('price','asc');
            }elseif($request->get('sort') == 'price_high'){
                $product = $product->orderBy('price','desc');
            }else{
                $product = $product->orderBy('id','desc');
            }
        }
        $data = [
            'categories' => Category::orderBy('id','desc')->with('subcategory')->get(),
            'brands' => Brand::orderBy('id','desc')->where('status',true)->get(),
            'products' => $product->orderBy('id','desc')->paginate(6),
            'categorySelected' => $categorySelected,
            'subCategorySelected' =>$subCategorySelected,
            'brandsArray' => $brandsArray,
            'priceMax' => (intval($request->get('price_max'))== 0 ? 1000 : $request->get('price_max') ),
            'priceMin' => intval($request->get('price_min')),
            'sort' => $request->get('sort')
        ];
        return view('users.shop',$data);
    }

    public function products($id){
        $product = Product::where('id',$id)->first();

        $relatedProducts = [];
    if ($product->related_products != '') {
    $productArray = explode(',', $product->related_products);
    $relatedProducts = Product::whereIn('id', $productArray)->get();
    }

        $data = [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ];

        return view('users.product',$data);
    }
}

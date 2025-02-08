<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductSaveRequest;
use App\Models\Attachment;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use File;
use Illuminate\Http\Request;
use Storage;
use Validator;

class ProductController
{
    public function list(){
        $products = Product::latest()->paginate(10);
        return view('admin.products.list',compact('products'));
    }

    public function create(){
        $categories=Category::all();
        $brands = Brand::get();
        return view('admin.products.create',compact('categories','brands'));
    }

    public function save(ProductSaveRequest $request){
        // dd($request->all(),);
        $data =$request->validated();
        if($request->image != null){
            $extension = $request->image->extension();
            $filename ="product_".time().".".$extension;
            $request->image->storeAs('images',$filename);
            $data['image'] = $filename;
        }
        $data['sub_category_id'] = $request->input('sub_category_id');
        $data['brand_id'] = $request->input('brand_id');
        $data['compare_price'] = $request->input('compare_price');
        $data['short_description'] = $request->input('short_description');
        $data['shipping_returns'] = $request->input('shipping_returns');
        $data['related_products'] = $request->input('related_products') ? implode(',',$request->input('related_products')) : null;
        $product = Product::updateOrCreate(
            ['id' => $request->product_id],
            $data
        );
        // $product = Product::create($data);
        return redirect()->route('admin.product.list')->with('success','Product created successfully');
    }

    public function delete(Request $request){
        $product = Product::where('id',$request->id)->first();
        if(!empty($product->image))
        Storage::delete($product->image);
        $product->delete();

        return response()->json('Product Deleted Successfully');
    }

    public function edit($id){
        $product = Product::find($id);
        $categories=Category::all();
        $brands = Brand::get();
        $relatedProducts = [];
// fetch related products
    if ($product->related_products != '') {
    $productArray = explode(',', $product->related_products);
    $relatedProducts = Product::whereIn('id', $productArray)->get();
    }
        $subCategories = SubCategory::where('category_id',$product->category_id)->get();
        return view('admin.products.create',compact('categories','product','brands','subCategories','relatedProducts'));
    }

    public function fetchSubCategory(Request $request)
    {
        if($request->input('category_id')){
            $subCategories = SubCategory::where('category_id',$request->input('category_id'))->get();
        }else{
            $subCategories = [];
        }

        return response()->json([
            'subCategories' => $subCategories
        ]);
    }


    public function categoryList(){
        $categories = Category::latest()->paginate(10);
        return view('admin.category.list',compact('categories'));
    }

    public function categoryCreate(){
        return view('admin.category.create');
    }

    public function categoryEdit($id){
        $category = Category::find($id);
        return view('admin.category.create',compact('category'));
    }

    public function categorySave(Request $request){
        $validator =Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required',
        ]);

        if($validator->fails())
        return response()->json([ 'errors' => $validator->errors()], 422);

        if($request->image != null){
            $extension = $request->image->extension();
            $filename ="product_".time().".".$extension;
            $request->image->storeAs('images',$filename);
        }

        // Save Image Here

        // dd($request->all());
        $category = Category::updateOrCreate(
            ['id' => $request->input('category_id')],
            [
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
                'image' => $request->image != null ? $filename :null ,
                'show_home' => $request->input('show_home'),
            ]
        );

        if (!empty($request->image_id)) {
            $tempImage = Attachment::find($request->image_id);
            $extArray = explode('.',$tempImage->name);
            $ext = last ($extArray);
            $newImageName = $category->id.'.'.$ext;
            $sPath =public_path().'/temp/'.$tempImage->name;
            $dPath = public_path().'/uploads/category/'.$newImageName;
            File::copy($sPath, $dPath);
            $category->attachment = $newImageName;
            $category->save();
            }


        // return redirect()->route('admin.category.list')->with('success','Category created successfully');
        return response()->json([
            'message' => 'Category saved successfully!',
            'category' => $category
        ], 200);
    }

    public function categoryDelete(Request $request){
        $category = Category::where('id',$request->id)->first();
        $product = Product::where('category_id',$category->id)->exists();
        if($product){
            return response()->json(['message'=>'Category has product cannot delete'],422);
        }else{
            if(!empty($category->image))
            Storage::delete($category->image);
            $category->delete();
            return response()->json('Category Deleted Successfully');
        }
    
    }

    public function attachmentCreate(Request $request){
        $image = $request->file;
        // dd($image,$request->all());
        if (!empty($image)) {
        $ext = $image->getClientOriginalExtension();
        $newName = time().'.'.$ext;
        }
        $tempImage = new Attachment();
$tempImage->name = $newName;
$tempImage->save();
$image->move (public_path().'/temp', $newName);
return response()->json([
'status' => true,
'image_id' => $tempImage->id,
'message' => 'Image uploaded successfully'
]); 
    }

    public function subCategoryList(){
        $subCategories = SubCategory::latest()->paginate(10);
        return view('admin.subCategory.list',compact('subCategories'));
    }

    public function subCategoryCreate(){
        $categories=Category::all();
        return view('admin.subCategory.create',compact('categories'));
    }

    public function subCategoryEdit($id){
        $subCategory = SubCategory::find($id);
        $categories=Category::all();
        return view('admin.subCategory.create',compact('subCategory','categories'));
    }

    public function subCategorySave(Request $request){
        $validator =Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required',
            'category' => 'required',
            'status' => 'required'
        ]);

        if($validator->fails())
        return response()->json([ 'errors' => $validator->errors()], 422);


        // dd($request->all());
        $subCategory = SubCategory::updateOrCreate(
            ['id' => $request->input('subCategory_id')],
            [
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
                'category_id' => $request->input('category'),
                'status' => $request->input('status'),
                'show_home' => $request->input('show_home'),
            ]
        );


        return response()->json([
            'message' => 'Sub Category saved successfully!',
            'category' => $subCategory
        ], 200);
    }

    public function brandList(){
        $brands = Brand::latest()->paginate(10);
        return view('admin.brand.list',compact('brands'));
    }

    public function brandCreate(){
        return view('admin.brand.create');
    }

    public function brandEdit($id){
        $brand = Brand::find($id);
        return view('admin.brand.create',compact('brand',));
    }

    public function brandSave(Request $request){
        $validator =Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required',
            'status' => 'required'
        ]);

        if($validator->fails())
        return response()->json([ 'errors' => $validator->errors()], 422);


        // dd($request->all());
        $brand = Brand::updateOrCreate(
            ['id' => $request->input('brand_id')],
            [
                'name' => $request->input('name'),
                'slug' => $request->input('slug'),
                'status' => $request->input('status')
            ]
        );


        return response()->json([
            'message' => 'Brand saved successfully!',
            'category' => $brand
        ], 200);
    }

    public function getProducts(Request $request)
    {
// dd($request->all());
       $tempProduct= [];
        if ($request->term != "") {
        $products = Product::where('name', 'like', '%' . $request->term. '%')->get();
        }

        foreach ($products as  $product) {
            $tempProduct[] = array('id' => $product->id,'text' => $product->name);
        }

        return response()->json([
            'tags' => $tempProduct,
            'status' => true,
        ]);
    }
}

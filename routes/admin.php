<?php

use App\Http\Controllers\Admin\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::name('admin.')->prefix('admin')->group(function(){
    Route::get('/login','LoginController@login')->name('login');
    Route::post('/dologin','LoginController@doLogin')->name('doLogin');
    
    Route::middleware('auth:admin')->group(function(){
        Route::get('/logout','LoginController@logout')->name('logout');
        Route::get('/dashboard','DashboardController@dashboard')->name('dashboard');
        Route::name('product.')->prefix('/product')->group(function(){
        Route::get('/','ProductController@list')->name('list');
        Route::get('create','ProductController@create')->name('create');
        Route::post('save','ProductController@save')->name('save');
        Route::post('delete','ProductController@delete')->name('delete');
        Route::get('edit/{id}','ProductController@edit')->name('edit');
        Route::get('fetchSubCategory','ProductController@fetchSubCategory')->name('fetchSubCategory');
        Route::get('getProducts','ProductController@getProducts')->name('getProducts');
    });
        Route::get('category','ProductController@categoryList')->name('category.list');
        Route::get('categoryCreate','ProductController@categoryCreate')->name('category.create');
        Route::post('categorySave','ProductController@categorySave')->name('category.save');
        Route::post('categoryDelete','ProductController@categoryDelete')->name('category.delete');
        Route::get('categoryEdit/{id}','ProductController@categoryEdit')->name('category.edit');
        Route::post('/attachment','ProductController@attachmentCreate')->name('attachment.create');

        Route::get('subCategory','ProductController@subCategoryList')->name('subCategory.list');
        Route::get('subCategoryCreate','ProductController@subCategoryCreate')->name('subCategory.create');
        Route::post('subCategorySave','ProductController@subCategorySave')->name('subCategory.save');
        Route::post('subCategoryDelete','ProductController@subCategoryDelete')->name('subCategory.delete');
        Route::get('subCategoryEdit/{id}','ProductController@subCategoryEdit')->name('subCategory.edit');


        Route::get('brand','ProductController@brandList')->name('brand.list');
        Route::get('brandCreate','ProductController@brandCreate')->name('brand.create');
        Route::post('brandSave','ProductController@brandSave')->name('brand.save');
        Route::post('brandDelete','ProductController@brandDelete')->name('brand.delete');
        Route::get('brandEdit/{id}','ProductController@brandEdit')->name('brand.edit');
    
});
});


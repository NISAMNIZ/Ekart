<?php

use App\Http\Controllers\HomePageController;
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
Route::name('user.')->prefix('user')->group(function(){
    Route::get('/login','HomePageController@login')->name('login');
    Route::get('/signUp','HomePageController@signUp')->name('signUp');
    Route::post('/do-signUp','HomePageController@doSignUp')->name('doSignUp');
    Route::post('/do-login','HomePageController@doLogin')->name('doLogin');
    Route::middleware('auth')->group(function(){
    Route::get('/home','HomePageController@home')->name('home');
    Route::get('/profile','HomePageController@profile')->name('profile');
    Route::get('/logout','HomePageController@logout')->name('logout');
    Route::get('/shop/{categorySlug?}/{subCategorySlug?}','ShopController@shopIndex')->name('shop');
    Route::get('/products/{id?}','ShopController@products')->name('product');
    Route::get('/cart','CartController@cart')->name('cart');
    Route::post('/addToCart','CartController@addToCart')->name('addToCart');
    Route::post('/updateCart','CartController@updateCart')->name('updateCart');
    Route::post('/deleteCartRow','CartController@deleteCartRow')->name('deleteCartRow');
    Route::get('/checkout','CartController@checkout')->name('checkout');
    Route::post('/processOrder','CartController@processOrder')->name('processOrder');
    Route::get('/thanks{OrderId?}','CartController@thanks')->name('thanks');
    });
});

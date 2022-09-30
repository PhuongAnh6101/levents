<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Users\LoginController;
use App\Http\Controllers\Admin\MainCOntroller;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SliderController;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('admin/users/login',[LoginController::class, 'index']) -> name('loginn');
Auth::routes();

Route::post('admin/users/login/store',[LoginController::class,'store']);

Route::middleware(['auth']) ->group(function(){
    Route::prefix('admin')->group(function(){
        Route::get('/',[MainCOntroller::class,'index']) -> name('admin');
        Route::get('main',[MainCOntroller::class,'index']);
        #menu
        Route::prefix('menus')->group(function(){
            Route::get('add',[MenuController::class,'create']);
            Route::post('add',[MenuController::class,'store']);
            Route::get('list',[MenuController::class,'index']);
            Route::get('edit/{menu}',[MenuController::class,'show']);
            Route::post('edit/{menu}',[MenuController::class,'update']);
          //  Route::get('edit/7',[MenuController::class,'show']);

          //  Route::get('edit/{menu}',[MenuController::class,'show']);
            Route::DELETE('destroy',[MenuController::class,'destroy']);
        });
        Route::prefix('products')->group(function(){
            Route::get('add',[ProductController::class,'create']);
            Route::post('add',[ProductController::class,'store']);
            Route::get('list',[ProductController::class,'index']);
            Route::get('edit/{product}',[ProductController::class,'show']);
            Route::post('edit/{product}',[ProductController::class,'update']);
            Route::DELETE('destroy',[ProductController::class,'destroy']); 
        });
        Route::prefix('sliders')->group(function(){
            Route::get('add',[SliderController::class,'create']);
            Route::post('add',[SliderController::class,'store']);
            Route::get('list',[SliderController::class,'index']);
            Route::get('edit/{slider}',[SliderController::class,'show']);
            Route::post('edit/{slider}',[SliderController::class,'update']);
            Route::DELETE('destroy',[SliderController::class,'destroy']); 
        });
       #Upload
       Route::post('upload/services', [\App\Http\Controllers\Admin\UploadController::class, 'store']);

    });
   
});
Route::get('/', [App\Http\Controllers\MainController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::any('/services/load-product', [App\Http\Controllers\MainController::class, 'loadProduct']);
Route::get('danh-muc/{id}-{slug}.html', [App\Http\Controllers\MenuController::class, 'index']);
Route::get('san-pham/{id}-{slug}.html', [App\Http\Controllers\ProductController::class, 'index']);
Route::post('add-cart', [App\Http\Controllers\CartController::class, 'index']);
Route::get('carts',[App\Http\Controllers\CartController::class,'show']);
Route::post('update-cart',[App\Http\Controllers\CartController::class,'update']);
Route::get('carts/delete/{id}',[App\Http\Controllers\CartController::class,'remove']);
Route::post('carts',[App\Http\Controllers\CartController::class,'addCart']);

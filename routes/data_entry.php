<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataEntry\HomeController;
use App\Http\Controllers\DataEntry\AuthController;
use App\Http\Controllers\DataEntry\BrandController;
use App\Http\Controllers\DataEntry\CategoryController;
use App\Http\Controllers\DataEntry\ProductController;




Route::get('/data_entry/login', [AuthController::class , 'show_login'])->name('showLoginDataEntry');
Route::post('/data_entry/login', [AuthController::class,'login'])->name('dataEntryLogin');





Route::middleware(['checkIfDataEntry' , 'DashboardLang'])->prefix('data_entry')->group(function (){




    Route::prefix('auth')->group(function () {
        Route::get('/logout', [AuthController::class , 'logout'])->name('data_entry.auth.logout');

    });




    Route::get('chang_lang/{lang}' , function($lang){
        \Illuminate\Support\Facades\Session::put('locale', $lang);
        return redirect()->back();
    })->name('change_direction_data_entry');

    // home page at controller
    Route::prefix('home')->controller(HomeController::class)->group(function (){
        Route::get('/' , 'index')->name('data_entry.home.index');
    });


    // start brand
    Route::prefix('brands')->group(function (){
        Route::get('/' , [BrandController::class , 'index'])->name('data_entry.brands.index');
        Route::get('/create' , [BrandController::class , 'create'])->name('data_entry.brands.add');
        Route::post('/store' , [BrandController::class , 'store'])->name('data_entry.brands.store');
        Route::get('/edit/{id}' , [BrandController::class , 'edit'])->name('data_entry.brands.edit');
        Route::get('/delete/{id}' , [BrandController::class , 'delete'])->name('data_entry.brands.delete');
        Route::post('/update/{id}' , [BrandController::class , 'update'])->name('data_entry.brands.update');
    });

    //start category 

    Route::prefix('categories')->group(function (){
        Route::get('/' , [CategoryController::class , 'index'])->name('data_entry.category.index');
        Route::get('/add' , [CategoryController::class , 'create'])->name('data_entry.category.add');
        Route::get('/edit/{id}' , [CategoryController::class , 'edit'])->name('data_entry.category.edit');
        Route::post('/store' , [CategoryController::class , 'store'])->name('data_entry.category.store');
        Route::post('/update/{id}' , [CategoryController::class , 'update'])->name('data_entry.category.update');
        Route::get('/soft_delete/{id}' , [CategoryController::class , 'soft_delete'])->name('data_entry.category.soft_delete');
        Route::get('/restore/{id}' , [CategoryController::class , 'restore'])->name('data_entry.category.restore');
        Route::get('/destroy/{id}' , [CategoryController::class , 'destroy'])->name('data_entry.category.destroy');
    });

    //start products

    Route::prefix('products')->group(function (){

        // all products
        Route::get('/' , [ProductController::class , 'index'])->name('data_entry.products.index');
        Route::get('/edit/{id}' , [ProductController::class , 'edit'])->name('data_entry.products.edit');
        Route::get('/add' , [ProductController::class , 'create'])->name('data_entry.products.add');
        Route::post('/update/{id}' , [ProductController::class , 'update'])->name('data_entry.products.update');
        Route::post('/store' , [ProductController::class , 'store'])->name('data_entry.products.store');
        Route::get('/soft_delete/{id}' , [ProductController::class , 'soft_delete'])->name('data_entry.products.soft_delete');
        Route::get('/restore/{id}' , [ProductController::class , 'restore'])->name('data_entry.products.restore');
        Route::get('/destroy/{id}' , [ProductController::class , 'destroy'])->name('data_entry.products.destroy');


        // start gallary
        Route::get('/gallery/{id}' , [ProductController::class , 'gallery'])->name('data_entry.products.gallery');
        Route::get('/delete/{id}' , [ProductController::class , 'delete_gallery'])->name('data_entry.products.delete_gallery');
        Route::post('/store/{id}/gallery' , [ProductController::class , 'store_gallery'])->name('data_entry.products.save_gallery');


        // start file
        Route::prefix('files')->group(function (){
            Route::get('/{id}' , [ProductController::class , 'files'])->name('data_entry.products.files');
            Route::post('/store/{id}' , [ProductController::class , 'store_file'])->name('data_entry.products.files.store');
            Route::get('/delete/{id}' , [ProductController::class , 'delete_file'])->name('data_entry.products.files.delete');
        });



        // start props
        Route::prefix('props')->group(function (){
            Route::get('{id}' , [ProductController::class , 'props'])->name('data_entry.products.props');
            Route::post('/store/{id}' , [ProductController::class , 'store_prop'])->name('data_entry.products.props.store');
            Route::get('/delete/{id}' , [ProductController::class , 'delete_prop'])->name('data_entry.products.props.delete');

        });





    });




    


});

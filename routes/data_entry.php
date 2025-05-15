<?php

use App\Http\Controllers\DataEntry\AboutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataEntry\HomeController;
use App\Http\Controllers\DataEntry\AuthController;
use App\Http\Controllers\DataEntry\BrandController;
use App\Http\Controllers\DataEntry\CategoryController;
use App\Http\Controllers\DataEntry\CMSController;
use App\Http\Controllers\DataEntry\ContactUsController;
use App\Http\Controllers\DataEntry\MissionVission;
use App\Http\Controllers\DataEntry\ProductController;
use App\Http\Controllers\DataEntry\SliderController;

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
    // Route::prefix('home')->controller(HomeController::class)->group(function (){
    //     Route::get('/' , 'index')->name('data_entry.index');
    // });


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




    Route::prefix('cms')->group(function (){
        Route::get('/' , [CMSController::class , 'index'])->name('data_entry.cms.index');
        Route::get('/edit/{id}' , [CMSController::class , 'edit'])->name('data_entry.cms.edit');
        Route::post('/update/{id}' , [CMSController::class , 'update'])->name('data_entry.cms.update');
        Route::get('/create' , [CMSController::class , 'create'])->name('data_entry.cms.add');
        Route::post('/store' , [CMSController::class , 'store'])->name('data_entry.cms.store');
        Route::get('/soft_delete/{id}' , [CMSController::class , 'soft_delete'])->name('data_entry.cms.soft_delete');
        Route::get('/restore/{id}' , [CMSController::class , 'restore'])->name('data_entry.cms.restore');
        Route::get('/destroy/{id}' , [CMSController::class , 'destroy'])->name('data_entry.cms.destroy');
        });




    Route::prefix('slider')->group(function (){
        Route::get('/' , [SliderController::class , 'index'])->name('data_entry.sliders.index');
        Route::get('/add' , [SliderController::class , 'create'])->name('data_entry.sliders.add');
        Route::post('/store' , [SliderController::class , 'store'])->name('data_entry.sliders.store');
        Route::get('/edit/{id}' , [SliderController::class , 'edit'])->name('data_entry.sliders.edit');
        Route::post('/update/{id}' , [SliderController::class , 'update'])->name('data_entry.sliders.update');
        Route::get('/destroy/{id}' , [SliderController::class , 'destroy'])->name('data_entry.sliders.destroy');
        Route::get('/soft_delete/{id}' , [SliderController::class , 'soft_delete'])->name('data_entry.sliders.soft_delete');
        Route::get('/restore/{id}' , [SliderController::class , 'restore'])->name('data_entry.sliders.restore');
        Route::get('/slider/setting' , [SliderController::class , 'setting'])->name('data_entry.sliders.setting');
        Route::post('/slider/setting/update' , [SliderController::class , 'update_setting'])->name('data_entry.sliders.setting_update');
 
    }); // end slider



    Route::prefix('contact-us')->group(function (){
        Route::get('/' , [ContactUsController::class , 'index'])->name('data_entry.contact.index');
        Route::post('/update' , [ContactUsController::class , 'update'])->name('data_entry.contact.update');
    });


    Route::prefix('about')->group(function (){
        Route::get('/' , [AboutController::class , 'index'])->name('data_entry.about.index');
        Route::post('/update' , [AboutController::class , 'update'])->name('data_entry.about.update');
     });


     Route::get('/mission_visison', [MissionVission::class , 'mision_vission'])->name('data_entry.mission_vission.index');
     Route::post('/mission_visison/store', [MissionVission::class , 'mision_vission_store'])->name('data_entry.mission_vission.store');




    


});

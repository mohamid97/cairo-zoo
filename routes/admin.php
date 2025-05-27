<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\SlidersController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\SocialMediaController;
use App\Http\Controllers\Admin\OurClientController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OurworkController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\MetaController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CMSController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\DesController;
use App\Http\Controllers\Admin\AchievementConroller;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CardController;
use App\Http\Controllers\Admin\FeaturedController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\MissionVission;
use App\Http\Controllers\Admin\MediaGroupcontroller;
use App\Http\Controllers\Admin\OffersController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ShimpmentsController;
use App\Http\Controllers\Admin\SocialAuthController;
use App\Http\Controllers\Admin\TagsController;
use App\Models\Admin\Offers;
use App\Models\Admin\Payment;
use Illuminate\Routing\RouteRegistrar;
use App\Http\Controllers\Admin\PointsController;
use App\Http\Controllers\Admin\SalesToolController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\FeedBackController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\WeightController;
use App\Http\Controllers\Admin\PartenerController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\OurteamController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CahierOrderController;
use App\Http\Controllers\Admin\LogController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\TasteController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\ExpenseController;

Route::get('/mig' , function (){


    Artisan::call('migrate:fresh');

    Artisan::call('db:seed');

   return "Migrations and seeders have been run successfully.";

});






Route::get('/admin/login', [AuthController::class , 'show_login'])->name('showLogin');
Route::post('/login', [AuthController::class,'login'])->name('login');

Route::get('auth/google', [UserController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [UserController::class, 'handleGoogleCallback']);

Route::get('auth/facebook', [UserController::class, 'redirectToFacebook']);
Route::get('auth/facebook/callback', [UserController::class, 'handleFacebookCallback']);




Route::middleware(['checkIfAdmin' , 'DashboardLang'])->prefix('admin')->group(function (){

    // change language
    Route::get('chang_lang/{lang}' , function($lang){
        \Illuminate\Support\Facades\Session::put('locale', $lang);
        return redirect()->back();
    })->name('change_direction');




    // start feedback

    Route::prefix('feedbacks')->group(function(){
        Route::get('/' , [FeedBackController::class , 'index'])->name('admin.feedback.index');
        Route::get('/add' , [FeedBackController::class , 'create'])->name('admin.feedback.add');
        Route::post('/store' , [FeedBackController::class , 'store'])->name('admin.feedback.store');
        Route::get('/edit/{id}' , [FeedBackController::class , 'edit'])->name('admin.feedback.edit');
        Route::post('/update/{id}' , [FeedBackController::class , 'update'])->name('admin.feedback.update');
        Route::get('/destroy/{id}' , [FeedBackController::class , 'destroy'])->name('admin.feedback.destroy');
        Route::get('/soft_delete/{id}' , [FeedBackController::class , 'soft_delete'])->name('admin.feedback.soft_delete');
        Route::get('/restore/{id}' , [FeedBackController::class , 'restore'])->name('admin.feedback.restore');
    });



    // backup
    Route::prefix('backup')->group(function (){

        Route::get('/backup', [BackupController::class, 'index'])->name('admin.backup.index');

        Route::get('/backup/database', [BackupController::class, 'backupDatabase'])->name('admin.backup.database');

        Route::get('/backup/folder', [BackupController::class, 'backupFolder'])->name('admin.backup.folder');

    });


    Route::get('/' , [HomeController::class , 'index'])->name('admin.index');



    // start taste
    Route::prefix('tastes')->group(function(){
        Route::get('/' , [TasteController::class , 'index'])->name('admin.tastes.index');
        Route::get('/create' , [TasteController::class , 'create'])->name('admin.tastes.add');
        Route::post('/store' , [TasteController::class , 'store'])->name('admin.tastes.store');
        Route::get('/edit/{id}' , [TasteController::class , 'edit'])->name('admin.tastes.edit');
        Route::post('/update/{id}' , [TasteController::class , 'update'])->name('admin.tastes.update');
        Route::get('/delete/{id}' , [TasteController::class , 'delete'])->name('admin.tastes.delete');
    });



    // featured start featured products
    Route::prefix('featured')->group(function(){
        Route::get('/get' , [FeaturedController::class ,'index'])->name('admin.featured.index');
        Route::get('/delete/{id}' , [FeaturedController::class , 'delete'])->name('admin.featured.delete');
        Route::post('store' , [ FeaturedController::class, 'store'])->name('admin.featured.store');
    });






    //sales tool
//    Route::prefix('sales_tool')->group(function (){
//        Route::get('/sales' , [SalesToolController::class , 'index'])->name('admin.sales_tool.index');
//        Route::get('/points' , [SalesToolController::class , 'points'])->name('admin.sales_tool.points');
//        Route::post('/get-order-comparison', [SalesToolController::class, 'getOrderComparison'])->name('admin.sales_tool.order_comparison');
//        Route::post('/products-comparison', [SalesToolController::class, 'productsComparison'])->name('admin.sales_tool.products_comparison');
//
//    });



     // start Tags
//    Route::prefix('tags')->group(function (){
//        Route::get('/'  , [TagsController::class , 'index'])->name('admin.tags.index');
//        Route::get('/create' , [TagsController::class , 'create'])->name('admin.tags.create');
//        Route::post('/store' , [TagsController::class , 'store'])->name('admin.tags.store');
//        Route::get('/edit/{id}' , [TagsController::class , 'edit'])->name('admin.tags.edit');
//        Route::post('/update/{id}' , [TagsController::class , 'update'])->name('admin.tags.update');
//        Route::get('/delete/{id}' , [TagsController::class , 'delete'])->name('admin.tags.delete');
//    });




    // login and regsiter
    Route::prefix('auth')->group(function () {
        Route::get('/update', [AuthController::class , 'show_update'])->name('admin.auth.showUpdate');
        Route::get('/logout', [AuthController::class , 'logout'])->name('admin.auth.logout');
        Route::post('/update', [AuthController::class,'update'])->name('admin.auth.update');
    });



    // offers
//    Route::prefix('offers')->group(function(){
//        Route::get('/' , [OffersController::class , 'index'])->name('admin.offers.index');
//        Route::get('/add' , [OffersController::class , 'add'])->name('admin.offers.add');
//        Route::post('/store' , [OffersController::class , 'store'])->name('admin.offers.store');
//        Route::get('delete/{id}',[OffersController::class , 'delete'])->name('admin.offers.delete');
//
//
//    });




    // start slider
   Route::prefix('slider')->group(function (){
       Route::get('/' , [SlidersController::class , 'index'])->name('admin.sliders.index');
       Route::get('/add' , [SlidersController::class , 'create'])->name('admin.sliders.add');
       Route::post('/store' , [SlidersController::class , 'store'])->name('admin.sliders.store');
       Route::get('/edit/{id}' , [SlidersController::class , 'edit'])->name('admin.sliders.edit');
       Route::post('/update/{id}' , [SlidersController::class , 'update'])->name('admin.sliders.update');
       Route::get('/destroy/{id}' , [SlidersController::class , 'destroy'])->name('admin.sliders.destroy');
       Route::get('/soft_delete/{id}' , [SlidersController::class , 'soft_delete'])->name('admin.sliders.soft_delete');
       Route::get('/restore/{id}' , [SlidersController::class , 'restore'])->name('admin.sliders.restore');
       Route::get('/slider/setting' , [SlidersController::class , 'setting'])->name('admin.sliders.setting');
       Route::post('/slider/setting/update' , [SlidersController::class , 'update_setting'])->name('admin.sliders.setting_update');

   }); // end slider



    Route::get('/mission_visison', [MissionVission::class , 'mision_vission'])->name('admin.mission_vission.index');
    Route::post('/mission_visison/store', [MissionVission::class , 'mision_vission_store'])->name('admin.mission_vission.store');



    // start messages
   Route::prefix('messages')->group(function (){
       Route::get('/' , [MessageController::class , 'index'])->name('admin.messages.index');
       Route::get('/show/{id}' , [MessageController::class , 'show'])->name('admin.messages.show');
       Route::get('/destroy/{id}' , [MessageController::class , 'destroy'])->name('admin.messages.destroy');
   });


   Route::prefix('about')->group(function (){
      Route::get('/' , [AboutController::class , 'index'])->name('admin.about.index');
      Route::post('/update' , [AboutController::class , 'update'])->name('admin.about.update');
   });

   Route::prefix('contact-us')->group(function (){
       Route::get('/' , [ContactUsController::class , 'index'])->name('admin.contact.index');
       Route::post('/update' , [ContactUsController::class , 'update'])->name('admin.contact.update');
   });

   Route::prefix('logs')->group(function (){
       Route::get('/' , [LogController::class , 'index'])->name('admin.logs.index');
       Route::get('admin/logs/{log}', [LogController::class, 'show'])->name('admin.logs.show');
       Route::get('/delete/{log}' , [LogController::class , 'delete'])->name('admin.logs.delete');
       Route::get('user/logs/{user}', [LogController::class, 'userLogs'])->name('admin.logs.users.show');
    });


        // start social media
   Route::prefix('social-media')->group(function (){
       Route::get('/' , [SocialMediaController::class , 'index'])->name('admin.social_media.index');
       Route::post('/update' , [SocialMediaController::class , 'update'])->name('admin.social_media.update');
   });















//    Route::prefix('ourteam')->group(function(){
//        Route::get('/get' , [OurteamController::class , 'get'])->name('admin.ourteam.index');
//        Route::get('/edit/{id}' , [OurteamController::class , 'edit'])->name('admin.ourteam.edit');
//        Route::post('/update/{id}' , [OurteamController::class , 'update'])->name('admin.ourteam.update');
//        Route::get('/create' , [OurteamController::class , 'create'])->name('admin.ourteam.add');
//        Route::post('/store' , [OurteamController::class , 'store'])->name('admin.ourteam.store');
//        Route::get('/soft_delete/{id}' , [OurteamController::class , 'soft_delete'])->name('admin.ourteam.soft_delete');
//        Route::get('/restore/{id}' , [OurteamController::class , 'restore'])->name('admin.ourteam.restore');
//        Route::get('/destroy/{id}' , [OurteamController::class , 'destroy'])->name('admin.ourteam.destroy');
//    });



    // start our clients
//    Route::prefix('our_clients')->group(function (){
//       Route::get('/' , [OurClientController::class , 'index'])->name('admin.our_clients.index');
//       Route::get('/create' , [OurClientController::class , 'create'])->name('admin.our_clients.add');
//       Route::post('/store' , [OurClientController::class , 'store'])->name('admin.our_clients.store');
//       Route::get('/edit/{id}' , [OurClientController::class , 'edit'])->name('admin.our_clients.edit');
//       Route::get('/soft_delete/{id}' , [OurClientController::class , 'soft_delete'])->name('admin.our_clients.soft_delete');
//       Route::get('/restore/{id}' , [OurClientController::class , 'restore'])->name('admin.our_clients.restore');
//       Route::get('/destroy/{id}' , [OurClientController::class , 'destroy'])->name('admin.our_clients.destroy');
//       Route::post('/update/{id}' , [OurClientController::class , 'update'])->name('admin.our_clients.update');
//    });


    // start our brands
    Route::prefix('brands')->group(function (){
        Route::get('/' , [BrandController::class , 'index'])->name('admin.brands.index');
        Route::get('/create' , [BrandController::class , 'create'])->name('admin.brands.add');
        Route::post('/store' , [BrandController::class , 'store'])->name('admin.brands.store');
        Route::get('/edit/{id}' , [BrandController::class , 'edit'])->name('admin.brands.edit');
        Route::get('/delete/{id}' , [BrandController::class , 'delete'])->name('admin.brands.delete');
        Route::post('/update/{id}' , [BrandController::class , 'update'])->name('admin.brands.update');
    });


    // start our weight
//    Route::prefix('weights')->group(function (){
//        Route::get('/' , [WeightController::class , 'index'])->name('admin.weights.index');
//        Route::get('/create' , [WeightController::class , 'create'])->name('admin.weights.add');
//        Route::post('/store' , [WeightController::class , 'store'])->name('admin.weights.store');
//        Route::get('/edit/{id}' , [WeightController::class , 'edit'])->name('admin.weights.edit');
//        Route::get('/delete/{id}' , [WeightController::class , 'delete'])->name('admin.weights.delete');
//        Route::post('/update/{id}' , [WeightController::class , 'update'])->name('admin.weights.update');
//    });


        // start events
//        Route::prefix('events')->group(function (){
//            Route::get('/' , [EventController::class , 'index'])->name('admin.events.index');
//            Route::get('/create' , [EventController::class , 'create'])->name('admin.events.add');
//            Route::post('/store' , [EventController::class , 'store'])->name('admin.events.store');
//            Route::get('/edit/{id}' , [EventController::class , 'edit'])->name('admin.events.edit');
//            Route::get('/delete/{id}' , [EventController::class , 'delete'])->name('admin.events.delete');
//            Route::post('/update/{id}' , [EventController::class , 'update'])->name('admin.events.update');
//        });


    // start payment integeration

//    Route::prefix('payments')->group(function(){
//        Route::get('get' , [PaymentController::class , 'get'])->name('admin.payments.index');
//        Route::post('settings' , [PaymentController::class , 'settings'])->name('admin.payments.settings');
//        Route::get('status' , [PaymentController::class , 'get_status'])->name('admin.payments.status');
//        Route::post('/edit/status' , [PaymentController::class, 'edit_status'])->name('admin.payments.edit_status');
//
//
//    });




    // route of shimpments

   Route::prefix('shimpments')->group(function(){

       Route::get('get' , [ShimpmentsController::class , 'index'])->name('admin.shimpments.index');
       Route::post('update' , [ShimpmentsController::class , 'update' ])->name('admin.shimpments.update');
       Route::get('/show_zone' , [ShimpmentsController::class , 'show_zone'])->name('admin.shimpments.Show_zone');
       Route::get('/add_zone' , [ShimpmentsController::class , 'add_zone'])->name('admin.shimpments.add_zone');
       Route::post('store_zone' , [ShimpmentsController::class , 'store_zone'])->name('admin.shimpments.store_zone');
       Route::get('/edit_zone/{id}' , [ShimpmentsController::class , 'edit_zone'])->name('admin.shimpments.edit_zone');
       Route::post('/update_zone/{id}' , [ShimpmentsController::class , 'update_zone'])->name('admin.shimpments.update_zone');
    //    Route::get('/soft_delete_zone/{id}' , [ShimpmentsController::class , 'soft_delete_zone'])->name('admin.shimpments.soft_delete_zone');
    //    Route::get('/restore_zone/{id}' , [ShimpmentsController::class , 'restore_zone'])->name('admin.shimpments.restore_zone');
       Route::get('/destroy_zone/{id}' , [ShimpmentsController::class , 'destroy_zone'])->name('admin.shimpments.destroy_zone');


       // cities
       Route::get('/show_city' , [ShimpmentsController::class , 'show_city'])->name('admin.shimpments.show_city');
       Route::get('/add_city' , [ShimpmentsController::class , 'add_city'])->name('admin.shimpments.add_city');
       Route::post('store_city' , [ShimpmentsController::class , 'store_city'])->name('admin.shimpments.store_city');
       Route::get('/destroy_city/{id}' , [ShimpmentsController::class , 'destroy_city'])->name('admin.shimpments.destroy_city');



       // start company shipment
       Route::get('/show_company' , [ShimpmentsController::class , 'show_company'])->name('admin.shimpments.Show_company');
       Route::get('/add_company' , [ShimpmentsController::class , 'add_company'])->name('admin.shimpments.add_company');
       Route::post('store_company' , [ShimpmentsController::class , 'store_company'])->name('admin.shimpments.store_company');
       Route::get('/edit_company/{id}' , [ShimpmentsController::class , 'edit_company'])->name('admin.shimpments.edit_company');
       Route::post('/update_company/{id}' , [ShimpmentsController::class , 'update_company'])->name('admin.shimpments.update_company');
       Route::get('/soft_delete_company/{id}' , [ShimpmentsController::class , 'soft_delete_company'])->name('admin.shimpments.soft_delete_company');
       Route::get('/restore_company/{id}' , [ShimpmentsController::class , 'restore_company'])->name('admin.shimpments.restore_company');
       Route::get('/destroy_company/{id}' , [ShimpmentsController::class , 'destroy_company'])->name('admin.shimpments.destroy_company');
   });








    // start users
    Route::prefix('users')->group(function (){
        Route::get('/' , [UserController::class , 'index'])->name('admin.users.index');
        Route::get('/create' , [UserController::class , 'create'])->name('admin.users.add');
        Route::post('/store' , [UserController::class , 'store'])->name('admin.users.store');
        Route::get('/edit/{id}' , [UserController::class , 'edit'])->name('admin.users.edit');
        Route::post('/update/{id}' , [UserController::class , 'update'])->name('admin.users.update');
        Route::get('/soft_delete/{id}' , [UserController::class , 'soft_delete'])->name('admin.users.soft_delete');
        Route::get('/restore/{id}' , [UserController::class , 'restore'])->name('admin.users.restore');
        Route::get('/destroy/{id}' , [UserController::class , 'destroy'])->name('admin.users.destroy');

    });


//    Route::prefix('our-works')->group(function (){
//        Route::get('/' , [OurworkController::class , 'index'])->name('admin.our_works.index');
//        Route::get('/create' , [OurworkController::class , 'create'])->name('admin.our_works.add');
//        Route::get('/edit/{id}' , [OurworkController::class , 'edit'])->name('admin.our_works.edit');
//        Route::post('/store' , [OurworkController::class , 'store'])->name('admin.our_works.store');
//        Route::post('/update/{id}' , [OurworkController::class , 'update'])->name('admin.our_works.update');
//        Route::get('/soft_delete/{id}' , [OurworkController::class , 'soft_delete'])->name('admin.our_works.soft_delete');
//        Route::get('/restore/{id}' , [OurworkController::class , 'restore'])->name('admin.our_works.restore');
//        Route::get('/destroy/{id}' , [OurworkController::class , 'destroy'])->name('admin.our_works.destroy');
//        Route::get('/gallery/{id}' , [OurworkController::class , 'gallery'])->name('admin.our_works.gallery');
//        Route::get('/delete/{id}' , [OurworkController::class , 'delete_gallery'])->name('admin.our_works.delete_gallery');
//        Route::post('/store/{id}/gallery' , [OurworkController::class , 'store_gallery'])->name('admin.our_works.save_gallery');
//
//    });



    // start lang

    Route::prefix('langs')->group(function (){
        Route::get('/' , [LanguageController::class , 'index'])->name('admin.lang.index');
       Route::get('/add' , [LanguageController::class , 'create'])->name('admin.lang.add');
       Route::get('/delete/{id}' , [LanguageController::class , 'delete'])->name('admin.lang.delete');
       Route::post('/store' , [LanguageController::class , 'store'])->name('admin.lang.store');
    });




    // start meta
//    Route::prefix('meta')->group(function (){
//        Route::get('/' , [MetaController::class , 'index'])->name('admin.meta.index');
//        Route::post('/update' , [MetaController::class , 'update'])->name('admin.meta.update');
//        Route::get('/products' , [MetaController::class , 'products'])->name('admin.meta.products');
//        Route::get('/blogs' , [MetaController::class , 'blogs'])->name('admin.meta.blogs');
//        Route::get('/services' , [MetaController::class , 'services'])->name('admin.meta.services');
//        Route::get('/projects' , [MetaController::class , 'projects'])->name('admin.meta.projects');
//        Route::get('/categories' , [MetaController::class , 'categories'])->name('admin.meta.categories');
//        Route::post('/update/products' , [MetaController::class , 'update_products'])->name('admin.meta.update_products');
//        Route::post('/update/categories' , [MetaController::class , 'update_categories'])->name('admin.meta.update_categories');
//        Route::post('/update/blogs' , [MetaController::class , 'update_blogs'])->name('admin.meta.update_blogs');
//        Route::post('/update/services' , [MetaController::class , 'update_services'])->name('admin.meta.update_services');
//        Route::post('/update/projects' , [MetaController::class , 'update_projects'])->name('admin.meta.update_projects');
//
//    });



    // start categories
    Route::prefix('categories')->group(function (){
        Route::get('/' , [CategoryController::class , 'index'])->name('admin.category.index');
        Route::get('/add' , [CategoryController::class , 'create'])->name('admin.category.add');
        Route::get('/edit/{id}' , [CategoryController::class , 'edit'])->name('admin.category.edit');
        Route::post('/store' , [CategoryController::class , 'store'])->name('admin.category.store');
        Route::post('/update/{id}' , [CategoryController::class , 'update'])->name('admin.category.update');
        Route::get('/soft_delete/{id}' , [CategoryController::class , 'soft_delete'])->name('admin.category.soft_delete');
        Route::get('/restore/{id}' , [CategoryController::class , 'restore'])->name('admin.category.restore');
        Route::get('/destroy/{id}' , [CategoryController::class , 'destroy'])->name('admin.category.destroy');
    });


    // start product routes

    Route::prefix('products')->group(function (){

        // all products
        Route::get('/' , [ProductController::class , 'index'])->name('admin.products.index');
        Route::get('/edit/{id}' , [ProductController::class , 'edit'])->name('admin.products.edit');
        Route::get('/add' , [ProductController::class , 'create'])->name('admin.products.add');
        Route::post('/update/{id}' , [ProductController::class , 'update'])->name('admin.products.update');
        Route::post('/store' , [ProductController::class , 'store'])->name('admin.products.store');
        Route::get('/soft_delete/{id}' , [ProductController::class , 'soft_delete'])->name('admin.products.soft_delete');
        Route::get('/restore/{id}' , [ProductController::class , 'restore'])->name('admin.products.restore');
        Route::get('/destroy/{id}' , [ProductController::class , 'destroy'])->name('admin.products.destroy');

        // add stock
        Route::get('add_stock' , [ProductController::class , 'add_stock'])->name('admin.products.add_stock');
        Route::post('store_stock' , [ProductController::class , 'store_stock'])->name('admin.products.store_stock');
        Route::get('show_stock_movement/{id}' , [ProductController::class , 'stock_movement'])->name('admin.products.show_stock_movement');

        // start gallary
        Route::get('/gallery/{id}' , [ProductController::class , 'gallery'])->name('admin.products.gallery');
        Route::get('/delete/{id}' , [ProductController::class , 'delete_gallery'])->name('admin.products.delete_gallery');
        Route::post('/store/{id}/gallery' , [ProductController::class , 'store_gallery'])->name('admin.products.save_gallery');


        // start file
        Route::prefix('files')->group(function (){
            Route::get('/{id}' , [ProductController::class , 'files'])->name('admin.products.files');
            Route::post('/store/{id}' , [ProductController::class , 'store_file'])->name('admin.products.files.store');
            Route::get('/delete/{id}' , [ProductController::class , 'delete_file'])->name('admin.products.files.delete');
        });



        // start props
        Route::prefix('props')->group(function (){
            Route::get('{id}' , [ProductController::class , 'props'])->name('admin.products.props');
            Route::post('/store/{id}' , [ProductController::class , 'store_prop'])->name('admin.products.props.store');
            Route::get('/delete/{id}' , [ProductController::class , 'delete_prop'])->name('admin.products.props.delete');

        });





    });



    // route for blog cms
    Route::prefix('cms')->group(function (){
        Route::get('/' , [CMSController::class , 'index'])->name('admin.cms.index');
        Route::get('/edit/{id}' , [CMSController::class , 'edit'])->name('admin.cms.edit');
        Route::post('/update/{id}' , [CMSController::class , 'update'])->name('admin.cms.update');
        Route::get('/create' , [CMSController::class , 'create'])->name('admin.cms.add');
        Route::post('/store' , [CMSController::class , 'store'])->name('admin.cms.store');
        Route::get('/soft_delete/{id}' , [CMSController::class , 'soft_delete'])->name('admin.cms.soft_delete');
        Route::get('/restore/{id}' , [CMSController::class , 'restore'])->name('admin.cms.restore');
        Route::get('/destroy/{id}' , [CMSController::class , 'destroy'])->name('admin.cms.destroy');
        });




    // route for admin discount
    Route::prefix('discounts')->group(function (){
        Route::get('index' , [DiscountController::class , 'index'])->name('admin.discounts.index');
        Route::get('/add' , [DiscountController::class , 'add'])->name('admin.discounts.add');
        Route::post('store' , [DiscountController::class , 'store'])->name('admin.discounts.store');
        Route::get('targets/{type}' , [DiscountController::class , 'target'] )->name('admin.discounts.target');
        Route::get('delete/{id}' , [DiscountController::class , 'delete'])->name('admin.discounts.delete');
    });

    // route for coupons
    Route::prefix('coupons')->group(function (){
        Route::get('index' ,  [CouponController::class , 'index'])->name('admin.coupons.index');
        Route::get('add' , [CouponController::class , 'add'])->name('admin.coupons.add');
        Route::post('store' , [CouponController::class , 'store'])->name('admin.coupons.store');
        Route::post('update/{id}' , [CouponController::class , 'update'])->name('admin.coupons.update');
        Route::get('edit/{id}' , [CouponController::class , 'edit'])->name('admin.coupons.edit');
        Route::get('delete/{id}' , [CouponController::class , 'delete'])->name('admin.coupons.delete');
    });


    // start settings
    Route::prefix('settings')->group(function (){
        Route::get('/' , [SettingController::class , 'index'])->name('admin.settings.index');
        Route::post('/update' , [SettingController::class , 'update'])->name('admin.settings.update');
    });





    Route::prefix('cahier_orders')->group(function (){
        Route::get('/' , [CahierOrderController::class , 'index'])->name('admin.cahier_orders.index');
        Route::get('/show/{id}' , [CahierOrderController::class , 'show'])->name('admin.cahier_orders.show');
        Route::get('/delete/{id}' , [CahierOrderController::class , 'delete'])->name('admin.cahier_orders.delete');
    });

    // statistics
    Route::prefix('statistics')->group(function(){
        Route::get('store_data' , [StatisticsController::class , 'store_data'])->name('admin.statistics.store');
        Route::get('/orders' , [StatisticsController::class , 'orders'])->name('admin.statistics.orders');
        Route::get('/diff' , [StatisticsController::class , 'diff'])->name('admin.statistics.diff');
        Route::get('/monthly_report' , [StatisticsController::class , 'monthly_report'])->name('admin.statistics.monthly_report');
        Route::get('/statistics/export', [StatisticsController::class, 'export'])->name('admin.statistics.export');


    });

    // start expense
    Route::prefix('expense')->group(function(){
        Route::get('/', [ExpenseController::class, 'index'])->name('admin.expense.index');
        Route::get('/add', [ExpenseController::class, 'add'])->name('admin.expense.add');
        Route::post('/store', [ExpenseController::class, 'store'])->name('admin.expense.store');
        Route::get('/edit/{id}', [ExpenseController::class, 'edit'])->name('admin.expense.edit');
        Route::post('/update/{id}', [ExpenseController::class, 'update'])->name('admin.expense.update');
        Route::get('/delete/{id}', [ExpenseController::class, 'destroy'])->name('admin.expense.delete');
    });


        // start order
    Route::prefix('orders')->group(function(){
        Route::get('/',[OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/delete/{id}' , [OrderController::class, 'index'])->name('admin.orders.delete');
        Route::get('/show_details/{id}' , [OrderController::class, 'show_details'])->name('admin.orders.show_details');
        Route::get('/edit_status/{id}' ,[OrderController::class, 'edit_status'] )->name('admin.orders.edit_status');
        Route::post('/update_status/{id}', [OrderController::class, 'update_status'])->name('admin.orders.update_status');
        Route::get('retrieval/{id}' , [OrderController::class, 'retrieval'])->name('admin.orders.retrieval');

    });


    // start cards
    Route::prefix('cards')->group(function(){
        Route::get('/get' , [CardController::class , 'get'])->name('admin.cards.index');
        Route::get('delete/{id}', [CardController::class, 'delete'])->name('admin.cards.delete');
        Route::get('/show_details/{id}', [CardController::class, 'showDetails'])->name('admin.cards.show_details');
    });

    // start points
    Route::prefix('points')->group(function(){
        Route::get('index' , [PointsController::class , 'get'])->name('admin.points.index');
        Route::post('/update/points_price' ,[PointsController::class , 'update_price'])->name('admin.points_pirce.update');
    });






    // start shipment
    // Route::prefix('shipment')->group(function(){
    //     Route::get('add/gov' , [ShimpmentsController::class , 'add_gov'])->name('admin.shipment.add_gov');

    // });





    // start services
    // Route::prefix('services')->group(function (){
    //     Route::get('/' , [ServiceController::class , 'index'])->name('admin.services.index');
    //     Route::get('/edit/{id}' , [ServiceController::class , 'edit'])->name('admin.services.edit');
    //     Route::get('/create' , [ServiceController::class , 'create'])->name('admin.services.add');
    //     Route::post('/store' , [ServiceController::class , 'store'])->name('admin.services.store');
    //     Route::post('/update/{id}' , [ServiceController::class , 'update'])->name('admin.services.update');
    //     Route::get('/soft_delete/{id}' , [ServiceController::class , 'soft_delete'])->name('admin.services.soft_delete');
    //     Route::get('/restore/{id}' , [ServiceController::class , 'restore'])->name('admin.services.restore');
    //     Route::get('/destroy/{id}' , [ServiceController::class , 'destroy'])->name('admin.services.destroy');


    //     Route::get('/gallery/{id}' , [ServiceController::class , 'gallery'])->name('admin.services.gallery');
    //     Route::get('/delete/{id}' , [ServiceController::class , 'delete_gallery'])->name('admin.services.delete_gallery');
    //     Route::post('/store/{id}/gallery' , [ServiceController::class , 'store_gallery'])->name('admin.services.save_gallery');


    // });









    // start gallery and videos and files
    // Route::prefix('media')->group(function (){

    //     // create global media group
    //     Route::get('/group_media' , [MediaGroupcontroller::class , 'index'])->name('admin.group_media.index');
    //     Route::get('/group_media/create' , [MediaGroupcontroller::class , 'create'])->name('admin.media_group.add');
    //     Route::post('/group_media/store' , [MediaGroupcontroller::class , 'store'])->name('admin.group_media.store');
    //     Route::get('/group_media/edit/{id}' , [MediaGroupcontroller::class , 'edit'])->name('admin.group_media.edit');
    //     Route::post('/group_media/update/{id}' , [MediaGroupcontroller::class , 'update'])->name('admin.group_media.update');
    //     Route::get('/group_media/soft_delete/{id}' , [MediaGroupcontroller::class , 'soft_delete'])->name('admin.group_media.soft_delete');
    //     Route::get('/group_media/restore/{id}' , [MediaGroupcontroller::class , 'restore'])->name('admin.group_media.restore');
    //     Route::get('/group_media/destroy/{id}' , [MediaGroupcontroller::class , 'destroy'])->name('admin.group_media.destroy');


    //     // show all file belongs to media group

    //     Route::get('/group_media/files/{id}' , [MediaGroupcontroller::class , 'show_files'])->name('admin.group_media.files');

    //     //images
    //     Route::get('/gallery' , [GalleryController::class , 'gallery'])->name('admin.media.gallery');
    //     Route::get('/gallery/create' , [GalleryController::class , 'create'])->name('admin.gallery.add');
    //     Route::get('/gallery/edit/{id}' , [GalleryController::class , 'edit'])->name('admin.gallery.edit');
    //     Route::post('/gallery/store' , [GalleryController::class , 'store'])->name('admin.gallery.store');
    //     Route::post('/gallery/update/{id}' , [GalleryController::class , 'update'])->name('admin.gallery.update');
    //     Route::get('/gallery/soft_delete/{id}' , [GalleryController::class , 'soft_delete'])->name('admin.gallery.soft_delete');
    //     Route::get('/gallery/restore/{id}' , [GalleryController::class , 'restore'])->name('admin.gallery.restore');
    //     Route::get('/gallery/destroy/{id}' , [GalleryController::class , 'destroy'])->name('admin.gallery.destroy');



    //     // videos media
    //     Route::get('/videos' , [VideoController::class , 'videos'])->name('admin.media.videos');
    //     Route::get('/videos/create' , [VideoController::class , 'create'])->name('admin.videos.add');
    //     Route::get('/videos/edit/{id}' , [VideoController::class , 'edit'])->name('admin.videos.edit');
    //     Route::post('/videos/update/{id}' , [VideoController::class , 'update'])->name('admin.videos.update');
    //     Route::post('/videos/store' , [VideoController::class , 'store'])->name('admin.videos.store');
    //     Route::get('/videos/soft_delete/{id}' , [VideoController::class , 'soft_delete'])->name('admin.videos.soft_delete');
    //     Route::get('/videos/restore/{id}' , [VideoController::class , 'restore'])->name('admin.videos.restore');
    //     Route::get('/videos/destroy/{id}' , [VideoController::class , 'destroy'])->name('admin.videos.destroy');



    //     // files media
    //     Route::get('/files' , [FileController::class , 'files'])->name('admin.media.files');
    //     Route::get('/files/create' , [FileController::class , 'create'])->name('admin.files.add');
    //     Route::get('/files/edit/{id}' , [FileController::class , 'edit'])->name('admin.files.edit');
    //     Route::post('/files/update/{id}' , [FileController::class , 'update'])->name('admin.files.update');
    //     Route::post('/files/store' , [FileController::class , 'store'])->name('admin.files.store');
    //     Route::get('/files/soft_delete/{id}' , [FileController::class , 'soft_delete'])->name('admin.files.soft_delete');
    //     Route::get('/files/restore/{id}' , [FileController::class , 'restore'])->name('admin.files.restore');
    //     Route::get('/files/destroy/{id}' , [FileController::class , 'destroy'])->name('admin.files.destroy');


    // }); // end media files and gallery and gallery


    // route for description ( is some description or text with title )
    // Route::prefix('des')->group(function (){
    //    Route::get('/' , [DesController::class , 'index'])->name('admin.des.index');
    //    Route::get('/edit/{id}' , [DesController::class , 'edit'])->name('admin.des.edit');
    //    Route::get('/create' , [DesController::class , 'create'])->name('admin.des.add');
    //    Route::post('/store' , [DesController::class , 'store'])->name('admin.des.store');
    //    Route::post('/update/{id}' , [DesController::class , 'update'])->name('admin.des.update');
    //     Route::get('/soft_delete/{id}' , [DesController::class , 'soft_delete'])->name('admin.des.soft_delete');
    //     Route::get('/restore/{id}' , [DesController::class , 'restore'])->name('admin.des.restore');
    //     Route::get('/destroy/{id}' , [DesController::class , 'destroy'])->name('admin.des.destroy');

    // });




    // start achievement
    // Route::prefix('achievements')->group(function (){
    //     Route::get('/'  , [AchievementConroller::class , 'index'])->name('admin.ach.index');
    //     Route::get('/create' , [AchievementConroller::class , 'create'])->name('admin.ach.add');
    //     Route::get('/edit/{id}' , [AchievementConroller::class , 'edit'])->name('admin.ach.edit');
    //     Route::get('/delete/{id}' , [AchievementConroller::class , 'delete'])->name('admin.ach.delete');
    //     Route::post('/store' , [AchievementConroller::class , 'store'])->name('admin.ach.store');
    //     Route::post('/update'  , [AchievementConroller::class , 'update'])->name('admin.ach.update');
    // });

    // Route::prefix('parteners')->group(function (){
    //     Route::get('/' , [PartenerController::class , 'index'])->name('admin.parteners.index');
    //     Route::get('/create' , [PartenerController::class , 'create'])->name('admin.parteners.add');
    //     Route::post('/store' , [PartenerController::class , 'store'])->name('admin.parteners.store');
    //     Route::get('/edit/{id}' , [PartenerController::class , 'edit'])->name('admin.parteners.edit');
    //     Route::get('/soft_delete/{id}' , [PartenerController::class , 'soft_delete'])->name('admin.parteners.soft_delete');
    //     Route::get('/restore/{id}' , [PartenerController::class , 'restore'])->name('admin.parteners.restore');
    //     Route::get('/destroy/{id}' , [PartenerController::class , 'destroy'])->name('admin.parteners.destroy');
    //     Route::post('/update/{id}' , [PartenerController::class , 'update'])->name('admin.parteners.update');
    // });


    // Route::prefix('pages')->group(function (){
    //     Route::get('/' , [PageController::class , 'index'])->name('admin.pages.index');
    //     Route::get('/create' , [PageController::class , 'create'])->name('admin.pages.add');
    //     Route::get('/edit/{id}' , [PageController::class , 'edit'])->name('admin.pages.edit');
    //     Route::post('/store' , [PageController::class , 'store'])->name('admin.pages.store');
    //     Route::post('/update/{id}' , [PageController::class , 'update'])->name('admin.pages.update');
    //     Route::get('/soft_delete/{id}' , [PageController::class , 'soft_delete'])->name('admin.pages.soft_delete');
    //     Route::get('/restore/{id}' , [PageController::class , 'restore'])->name('admin.pages.restore');
    //     Route::get('/destroy/{id}' , [PageController::class , 'destroy'])->name('admin.pages.destroy');
    // });








}); // end admin prefix

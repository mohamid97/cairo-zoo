<?php


use App\Http\Controllers\Api\AchivementController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\CmsController;
use App\Http\Controllers\Api\ComparisonController;
use App\Http\Controllers\Api\FeaturedApiController;
use App\Http\Controllers\Api\GovsController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\MissionVisionController;
use App\Http\Controllers\Api\OffersController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\StatisticsController;
use App\Http\Controllers\Api\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Cashier\CashierController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


// middleware with lang
Route::middleware('checkLang')->group(function (){

    Route::prefix('sliders')->group(function (){
        Route::post('/get' , [\App\Http\Controllers\Api\SliderController::class , 'get']);
    });


    Route::prefix('category')->group(function (){
        Route::get('/paginate' , [\App\Http\Controllers\Api\CategoryController::class , 'paginate']);
        Route::post('/get' , [\App\Http\Controllers\Api\CategoryController::class , 'get']);
        Route::post('/details' , [\App\Http\Controllers\Api\CategoryController::class , 'get_details']);
        Route::post('/categories/products' , [\App\Http\Controllers\Api\CategoryController::class , 'categories_with_products']);
        Route::post('/parent' , [\App\Http\Controllers\Api\CategoryController::class , 'get_parent_categories']);
        Route::post('/sub' , [\App\Http\Controllers\Api\CategoryController::class , 'get_sub_categories']);
        Route::post('/parent/sub' , [\App\Http\Controllers\Api\CategoryController::class , 'get_parent_categories_with_child']);
    });


    Route::prefix('brands')->group(function (){
        Route::post('/get' , [\App\Http\Controllers\Api\BrandController::class , 'get']);
    });

    Route::prefix('messages')->group(function (){
        Route::post('/store'  , [\App\Http\Controllers\Admin\MessageController::class , 'save']);

    });


    Route::prefix('about-us')->group(function (){
        Route::post('/get' , [\App\Http\Controllers\Api\AboutController::class , 'get']);
    });


    
    Route::prefix('mission_vission')->group(function(){
        Route::post('/get' , [MissionVisionController::class , 'get']);
    });

    Route::prefix('contact-us')->group(function (){
        Route::post('/get' , [\App\Http\Controllers\Api\ContactusController::class , 'get']);
    });

    Route::prefix('products')->group(function (){
        Route::post('/paginate' , [\App\Http\Controllers\Api\ProductController::class , 'paginate']);
        Route::post('/product_details' , [\App\Http\Controllers\Api\ProductController::class , 'get_product_details']);
        Route::post('/featured' , [FeaturedApiController::class , 'get']);

        // Route::post('/' , [\App\Http\Controllers\Api\ProductController::class , 'get']);
        // Route::post('/filter' , [\App\Http\Controllers\Api\ProductController::class , 'getFilteredProducts']);
        // Route::post('/filter_product_name_category' , [\App\Http\Controllers\Api\ProductController::class , 'filter_product_name_category']);
        // Route::post('/cateory_slug' , [\App\Http\Controllers\Api\ProductController::class , 'products_category']);

    });

    Route::prefix('blogs')->group(function(){
        Route::post('paginate' , [CmsController::class , 'paginate']);
        Route::post('/article_details' , [CmsController::class , 'get_cms_details']);

    });



    // user route without auth
    Route::prefix('users')->group(function (){

        Route::post('/email/send-code', [\App\Http\Controllers\Api\Front\EmailVerificationController::class, 'sendCode']);
        Route::post('/email/verify-code', [\App\Http\Controllers\Api\Front\EmailVerificationController::class, 'verifyCode']);
        Route::post('/register' , [\App\Http\Controllers\Api\UsersController::class, 'register']);
        Route::post('login', [\App\Http\Controllers\Api\UsersController::class, 'login']);


        //  Route::get('get' , [ \App\Http\Controllers\Api\UsersController::class, 'get']);
        // Route::post('rest_password' , [\App\Http\Controllers\Api\UsersController::class, 'rest_password']);
        // Route::post('check/rest_code' , [\App\Http\Controllers\Api\UsersController::class, 'check_rest_code']);
    });






    // start feedback api Fe
    // Route::prefix('feedbacks')->group(function(){

    //     Route::get('/get' , [\App\Http\Controllers\Api\FeedbackController::class , 'get']);
    // });








    // Route::prefix('our-works')->group(function (){
    //     Route::post('/get' , [\App\Http\Controllers\Api\OurWorks::class , 'get']);

    // });


    // Route::prefix('social-media')->group(function (){
    //    Route::post('/get' , [\App\Http\Controllers\Api\SocialController::class , 'get']);
    // });

    // Route::prefix('langs')->group(function (){
    //   Route::get('/get' , [\App\Http\Controllers\Api\LangController::class , 'get']);
    // });

    // Route::prefix('meta')->group(function (){
    //     Route::post('/get' , [\App\Http\Controllers\Api\WebsiteMetaController::class , 'get']);
    // });

    // Route::prefix('settings')->group(function (){
    //    Route::post('/get' , [\App\Http\Controllers\Api\SettingsController::class , 'get']);
    // });




    // Route::prefix('clients')->group(function (){
    //    Route::post('/get'  , [\App\Http\Controllers\Api\OurClientController::class , 'get']);
    // });


    // Route::prefix('pages')->group(function (){
    //     Route::post('/get'  , [\App\Http\Controllers\Api\PageController::class , 'get']);
    //     Route::post('/details'  , [\App\Http\Controllers\Api\PageController::class , 'details']);
    // });


    // Route::prefix('our-teams')->group(function(){
    //     Route::post('/get' ,[\App\Http\Controllers\Api\OurteamController::class , 'get'] );
    // });

    // Route::prefix('parteners')->group(function (){
    //     Route::get('/get'  , [\App\Http\Controllers\Api\PartenerController::class , 'get']);
    // });

    // Route::prefix('subscribe')->group(function (){
    //     Route::post('store' , [\App\Http\Controllers\Api\SubscribeController::class , 'store'])->name('admin.subscribe.store');
    // });

    // Route::prefix('services')->group(function (){
    //     Route::get('/get' , [\App\Http\Controllers\Api\ServicesController::class , 'get']);
    //     Route::post('/service_details/get' , [\App\Http\Controllers\Api\ServicesController::class , 'get_service_details']);
    // });










    // Route::prefix('achivement')->group(function(){

    //     Route::post('/get' , [AchivementController::class , 'get']);


    // });

//    Route::prefix('featured')->group(function(){
//      Route::post('/products' , [FeaturedApiController::class , 'get']);
//    });




    // Route::prefix('mdeia')->group(function(){
    //     Route::get('/media-group/get' , [MediaController::class, 'get_media_group']);
    // });

    // Route::prefix('/statistics')->group(function(){

    //     Route::post('/add' , [StatisticsController::class  , 'save' ]);

    // });


    // // start govs
    // Route::prefix('govs')->group(function(){
    //     Route::post('/all', [GovsController::class , 'all_govs']);
    //     Route::post('cities' ,  [GovsController::class , 'cities']);
    // });


    // // offers
    // Route::prefix('offers')->group(function(){
    //    Route::post('get' , [OffersController::class , 'get']);

    // });


    // Route::prefix('orders_guest')->group(function(){
    //     Route::post('store' , [OrderController::class , 'store_guest']);
    // });

    // Route::prefix('descriptions')->group(function(){

    //     Route::get('/get' , [\App\Http\Controllers\Api\DescriptionController::class , 'get']);
    // });


    // cashier login 
    Route::prefix('cashier')->group(function(){
        Route::post('login' , [CashierController::class , 'login']);
    });
    // authincation with sanctum

        Route::middleware('auth:sanctum')->group(function (){

            // start router for cahsier
            Route::prefix('cashier')->middleware(['checkcashier'])->group(function(){
                Route::post('logout' , [CashierController::class , 'logout']);
                Route::post('info' , [CashierController::class , 'getCashierInfo']);
                Route::post('get_product' , [CashierController::class , 'getProduct']);
                Route::post('storeOrder' , [CashierController::class , 'StoreOrder']);
                Route::post('validate/coupon' , [CashierController::class , 'validate_coupon']);

            });

            Route::prefix('users')->middleware(['checkIfUser'])->group(function(){

                Route::post('logout' , [\App\Http\Controllers\Api\UsersController::class , 'logout']);
                Route::prefix('wishlists')->group(function(){
                    Route::post('/get', [WishlistController::class, 'index']);
                    Route::post('/store', [WishlistController::class, 'store']);
                    Route::post('/delete', [WishlistController::class, 'delete']);
                });

                Route::post('user-details', [\App\Http\Controllers\Api\UsersController::class, 'user']);
                Route::post('update', [\App\Http\Controllers\Api\UsersController::class, 'update']);


                Route::prefix('address')->group(function(){
                    Route::post('/' , [\App\Http\Controllers\Api\UsersController::class , 'all_address']);
                    Route::post('store' , [\App\Http\Controllers\Api\UsersController::class , 'store_address']);
                    Route::post('update' , [\App\Http\Controllers\Api\UsersController::class , 'update_address']);
                    Route::post('delete' ,[\App\Http\Controllers\Api\UsersController::class , 'delete_address'] );
                    Route::post('special_address',[\App\Http\Controllers\Api\UsersController::class , 'special_address']);

                });




                Route::prefix('carts')->group(function(){
                     Route::post('add_item',[CardController::class , 'add_item']);
                     Route::post('/cart', [CardController::class, 'get_user_card']);
                     Route::post('cart_update' , [CardController::class, 'update']);
                     Route::delete('clear', [CardController::class, 'delete']);
                     Route::post('item/delete', [CardController::class, 'delete_card_item']);

                });



                Route::prefix('orders_auth')->group(function(){
                    Route::post('store' , [OrderController::class , 'store_auth']);
                    Route::post('orders' , [OrderController::class , 'get_user_ordes']);
                });







            });












         




       

         
            // Route::prefix('compares')->group(function(){
            //     Route::post('/compare', [ComparisonController::class, 'index']);
            //     Route::post('/store', [ComparisonController::class, 'store']);
            //     Route::post('/delete', [ComparisonController::class, 'delete']);
            // });



            // start users
            // Route::prefix('users')->group(function(){


            //     Route::post('user', [\App\Http\Controllers\Api\UsersController::class, 'user']);
            //     Route::post('update', [\App\Http\Controllers\Api\UsersController::class, 'update']);
            //     Route::post('logout', [\App\Http\Controllers\Api\UsersController::class, 'logout']);
            //     Route::post('change_password', [\App\Http\Controllers\Api\UsersController::class, 'change_password']);
            
            //     Route::post('cart_update' , [CardController::class, 'update']);


            //     // address of user
            //     Route::prefix('address')->group(function(){
            //         Route::post('/' , [\App\Http\Controllers\Api\UsersController::class , 'all_address']);
            //         Route::post('store' , [\App\Http\Controllers\Api\UsersController::class , 'store_address']);
            //         Route::post('update' , [\App\Http\Controllers\Api\UsersController::class , 'update_address']);
            //         Route::post('delete' ,[\App\Http\Controllers\Api\UsersController::class , 'delete_address'] );
            //         Route::post('special_address',[\App\Http\Controllers\Api\UsersController::class , 'special_address']);



            //     });


            // });






        });











    









});
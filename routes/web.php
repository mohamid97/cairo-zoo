<?php

use App\Http\Controllers\Front\FrontendController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use function PHPSTORM_META\map;
use GuzzleHttp\Exception\RequestException;


Route::get('/upload/excel' , [\App\Http\Controllers\UploadExcel::class , 'index']);
Route::post('upload/data' , [\App\Http\Controllers\UploadExcel::class , 'upload'])->name('excel.upload');

Route::get('paymob' , function(){

    // $response = Http::withHeaders([
    //     'content-type' => 'application/json'
    // ])->post('https://accept.paymobsolutions.com/api/auth/tokens',[
    //     "api_key"=> "ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2ljSEp2Wm1sc1pWOXdheUk2T1RjMk1ESXpMQ0p1WVcxbElqb2lhVzVwZEdsaGJDSjkuWVBUMjlGTFBINGNlS2xjY2dHTWhTemllYzFaaWtvRnc1bUNZNmVHRE56WHhJamcyUHFQVWRPODJ6azF0ZFRyUTcxZGpxWlpGYkxOTEtIOWtVRjRIYkE="
    // ]);
    // $json=$response->json();


    // $headers = [
    //     'Authorization' => 'Token egy_sk_live_b7b25bea540dfe21d874d7ff3f6136834d6342014b7c524a72a09b9000e51ee2',
    //     'Content-Type' => 'application/json'
    // ];

    $headers = [
        'Authorization' => 'Token egy_sk_live_b7b25bea540dfe21d874d7ff3f6136834d6342014b7c524a72a09b9000e51ee2',
        'Content-Type' => 'application/json'
    ];
    $body = [
        "amount" => 2000,
        "currency" => "EGP",
        "payment_methods" => [

             4574292,



        ],
        "integration_id" => [
            4574292
        ],
        "items" => [
            [
                "name" => "Item name 1",
                "amount" => 2000,
                "description" => "Watch",
                "quantity" => 1
            ]
        ],
        "billing_data" => [
            "apartment" => "6",
            "first_name" => "Ammar",
            "last_name" => "Sadek",
            "street" => "938, Al-Jadeed Bldg",
            "building" => "939",
            "phone_number" => "+96824480228",
            "country" => "OMN",
            "email" => "AmmarSadek@gmail.com",
            "floor" => "1",
            "state" => "Alkhuwair"
        ],
        "customer" => [
            "first_name" => "Ammar",
            "last_name" => "Sadek",
            "email" => "AmmarSadek@gmail.com",
            "extras" => [
                "re" => "22"
            ]
        ],
        "extras" => [
            "ee" => 22
        ]
    ];
    $client = new Client();


        // Send the POST request
        $response = $client->post('https://accept.paymob.com/v1/intention/', [
            'headers' => $headers,
            'body' => json_encode($body)
        ]);

        // Log the response status and body for debugging
        $responseBody = $response->getBody()->getContents();

        // Parse the JSON response
        $last_json = json_decode($responseBody, true);

        // Return the response
        return response()->json($last_json);



});




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


Route::get('/' , function (){
    return redirect()->route('admin.index');
});
//Route::get('/', [HomeController::class , 'index'])->name('home');

//Route::get('/about' , [FrontendController::class , 'about'])->name('about');
//Route::get('/contact-us' , [FrontendController::class , 'contact'])->name('contact');
//Route::get('/services' , [FrontendController::class , 'services'])->name('services');
//Route::get('/service/{slug}' , [FrontendController::class, 'service_details'])->name('service_details');
//Route::get('/get-services' , [FrontendController::class, 'get_service_category']);
//Route::get('/projects' , [FrontendController::class, 'projects'])->name('projects');
//Route::get('/blog' , [FrontendController::class, 'blog'])->name('blog');
//Route::get('/latest_blog' , [FrontendController::class, 'latest_blog'])->name('latest_blog');
//Route::get('/blog/{slug}' , [FrontendController::class, 'blog_details'])->name('blog_details');
//
//
//// messsages from contacts
//
//Route::post('/send/message' , [FrontendController::class, 'message'])->name('send.contact');
//
//
//// payments
//Route::get('/pay' , function(){
//    return view('front.payments.index');
//});



// paypal  // used require srmklive/paypal:~3.0

// Route::get('create-transaction', [PayPalController::class, 'createTransaction'])->name('createTransaction');
// Route::get('process-transaction', [PayPalController::class, 'processTransaction'])->name('processTransaction');
// Route::get('success-transaction', [PayPalController::class, 'successTransaction'])->name('successTransaction');
// Route::get('cancel-transaction', [PayPalController::class, 'cancelTransaction'])->name('cancelTransaction');

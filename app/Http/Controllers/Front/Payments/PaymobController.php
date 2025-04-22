<?php

namespace App\Http\Controllers\Front\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymobController extends Controller
{
    public function checkingOut(): RedirectResponse
    {
        $response = Http::withHeaders([
            'Authorization' => 'Token egy_sk_test_28b4c68db2acbddf43dab6d2f983f100dac7dbd2732494c0e8537ce93742953a',
            'Content-Type' => 'application/json',
        ])->post('https://accept.paymob.com/v1/intention/', [
            'amount' => 1000,
            'currency' => 'EGP',
            'redirection_url'=>'https://simplexarabia.com/callback',
            'special_reference' => $merchant_order_id,
            'payment_methods' => [
                $integration_id
                
             
            ],
            'items' => [
                [
                    'name' => 'Item name 1',
                    'amount' => 1000,
                    'description' => 'Watch',
                    'quantity' => 1,
                ]
            ],
            'billing_data' => [
                'apartment' => '6',
                'first_name' => 'Ammar',
                'last_name' => 'Sadek',
                'street' => '938, Al-Jadeed Bldg',
                'building' => '939',
                'phone_number' => '+96824480228',
                'country' => 'OMN',
                'email' => 'AmmarSadek@gmail.com',
                'floor' => '1',
                'state' => 'Alkhuwair',
            ],
            'customer' => [
                'first_name' => 'Ammar',
                'last_name' => 'Sadek',
                'email' => 'AmmarSadek@gmail.com',
                'extras' => [
                    're' => '22',
                ],
            ],
            'extras' => [
                'ee' => 22,
            ]
        ]);
    
    
    
        $url = "https://accept.paymob.com/unifiedcheckout/?publicKey=egy_pk_test_vhe1T4jQ7dHiM6V9k1Lv1YywpNSS34yi&clientSecret={$response->json()['client_secret']}";
    
        // Send the GET request
        return  redirect($url);
    }

    public function callback(Request $request): RedirectResponse
    {
        $payment_details = json_encode($request->all());
        if ($request->success === "true")
        {
            return (new CheckoutController)->checkout_done($request->merchant_order_id, $payment_details);
        } else {
            flash(translate('Payment Failed'))->error();
            return redirect()->route('home');
        }
    }
}







 
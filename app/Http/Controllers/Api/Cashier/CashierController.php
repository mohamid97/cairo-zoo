<?php

namespace App\Http\Controllers\Api\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Trait\ResponseTrait;

class CashierController extends Controller
{
    use ResponseTrait;
    // login cashier
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        
        //return token if the user is cashierc to frontend
        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            if ($user->type !== 'cashier') {
                $this->res(false, 'Access denied. You do not have cashier permissions.', 403);
            }
            $token = $user->createToken('CashierToken')->plainTextToken;
            return $this->res(true, 'Login successful', 200, ['token' => $token,'user' => $user]);
        }

        return $this->res(false, 'Invalid credentials', 401);        
    }
    // logout cashier
    public function logout(Request $request)
    {
        auth()->logout();
        $this->res(true, 'Logout successful', 200);
    }

    // get cashier info
    public function getCashierInfo(Request $request)
    {
        $user = $request->user();
        if ($user->type !== 'cashier') {
            return $this->res(false, 'Access denied.', 403);
        }

        return $this->res(true, 'Cashier info', 200, ['user' => new CashierResource($user)]);
      
    }





}

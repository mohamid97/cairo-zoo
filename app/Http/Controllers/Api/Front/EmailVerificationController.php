<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Models\Admin\VerfiyEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Trait\ResponseTrait;
use Illuminate\Support\Facades\DB;

class EmailVerificationController extends Controller
{
    use ResponseTrait;
    public function sendCode(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $code = rand(100000, 999999);
        $email = $request->email;

        VerfiyEmail::updateOrCreate(
            ['email' => $email],
            [
                'code' => $code,
                'expires_at' => now()->addMinutes(10)
            ]
        );

        // You can replace this with a Mailable
        Mail::to($email)->send(new \App\Mail\EmailVerificationCode($email , $code));


        return response()->json(['message' => 'Verification code sent.']);
    }


    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required'
        ]);

        $record = EmailVerification::where('email', $request->email)
            ->where('code', $request->code)
            ->where('expires_at', '>', now())
            ->first();

        if (!$record) {
            return response()->json(['message' => 'Invalid or expired code.'], 422);
        }

        return response()->json(['message' => 'Email verified. You can now register.']);
    }

}

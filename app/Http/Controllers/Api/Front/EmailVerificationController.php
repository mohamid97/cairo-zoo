<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use App\Models\Admin\verfiyEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Trait\ResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Models\User;



class EmailVerificationController extends Controller
{
    use ResponseTrait;

    public function sendCode(Request $request)
    {

        try {

            $request->validate([
                'email' => 'required|email'
            ]);

            $code  = rand(100000, 999999);
            $email = $request->email;
            if (User::where('email', $email)->exists()) {
                return $this->res(false, __('main.email_already_exists'), 422);
            }

            DB::beginTransaction();

            verfiyEmail::updateOrCreate(
                ['email' => $email],
                [
                    'code'       => $code,
                    'expires_at' => now()->addMinutes(10),
                ]
            );


            Mail::to($email)
                ->send(new \App\Mail\EmailVerificationCode($email, $code));
                DB::commit();

            return $this->res(true, __('main.verification_code_sent'), 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return $this->res(false,__('main.validation_failed') , 422 , $e->validator->errors());

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->res(false, $e->getMessage(), 500);
        }
    }


    public function verifyCode(Request $request)
    {

        try{
            $request->validate([
                'email' => 'required|email',
                'code' => 'required|numeric|digits:6',
            ]);
            $record = VerfiyEmail::where('email', $request->email)
            ->where('code', $request->code)
            ->where('expires_at', '>', now())
            ->first();

            if (!$record) {
              return $this->res(true , __('main.invalid_code') , 422);
            }

            DB::beginTransaction();

            $record->is_verified = true;
            $record->save();

            DB::commit();
            return $this->res(false , __('main.email_verfied') , 200);

        }catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return $this->res(false,__('main.validation_failed') , 422 , $e->validator->errors());

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->res(false, $e->getMessage(), 500);
        }





    } // end of verifyCode





}

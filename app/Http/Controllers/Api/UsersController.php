<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddressUserRequest;
use App\Http\Requests\Admin\ChangePasswordRequest;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserAddress;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Resources\Admin\UserAddressResource;
use App\Http\Resources\Admin\UserDetailsResource;
use App\Http\Resources\Admin\UsersResource;
use App\Mail\ChangePassword;
use App\Models\Admin\Lang;
use App\Models\Admin\UserAddress;
use App\Models\User;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str; // Import Str facade
use Illuminate\Support\Facades\Mail;
use App\Models\Admin\VerfiyEmail;

class UsersController extends Controller
{
    use ResponseTrait;



  
    public function user(Request $request)
    {
        return  $this->res(true ,__('main.user_details') , 200 ,['user'=> new UserDetailsResource($request->user())]);
    }



    public function login(LoginRequest $request)
    {
        try{
            $credentials = $request->only('email', 'password');

            if (!auth()->attempt($credentials)) {
                return  $this->res(false , __('main.invalid_credentials'), 422);
            }
            $user = auth()->user();
            if ($user->type != 'user') {
                return  $this->res(false , __('main.invalid_credentials'), 422);
            }
            $token = $user->createToken('API Token')->plainTextToken;
            return  $this->res(true ,__('main.user_details') , 200 ,['user'=> new UserDetailsResource($user) , 'token'=>$token]);
        }catch (ValidationException $e) {
            DB::rollBack();
            // Handle validation exceptions
            return  $this->res(false , __('main.validation_failed') ,  422 ,   ['errors' => $e->errors()]);
        }catch(\Exception $e){
            return  $this->res(false , __('main.error_happened') , 500, $e->getMessage());
        }


    }



    
    public function register(StoreUserRequest $request)
    {

        try{
            $record = VerfiyEmail::where('email', $request->email)
            ->where('is_verified', true)
            ->first();

            if (!$record) {
                return $this->res(true , __('main.active_email') , 422);
            }
            $image_name = null;
            if($request->has('avatar')){
                $image_name = $request->avatar->getClientOriginalName();
                $request->avatar->move(public_path('uploads/images/users'), $image_name);
            }


            DB::beginTransaction();
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'type'=> 'user',
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone'=>$request->phone,
                'avatar'=> (isset($image_name) && $image_name != null) ?  $image_name : null

            ]);
    
            $record->delete(); 
            DB::commit();
            return $this->res(false , __('main.user_created') , 200);

        }catch(\Exception $e){       
            DB::rollBack();
            return  $this->res(false , __('main.error_happened') , $e->getCode() , $e->getMessage());

        }





    } // end register new user




        // update user
    public function update(UpdateUserRequest $request)
    {
        try {

            DB::beginTransaction();
            $user = $request->user();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            // $user->email = $request->email;
            $user->phone = $request->phone;
            if ($request->has('avatar')) {
                if ($user->avatar && file_exists(public_path('uploads/images/users/' . $user->avatar))) {
                    unlink(public_path('uploads/images/users/' . $user->avatar));
                }

                $image_name = $request->avatar->getClientOriginalName();
                $request->avatar->move(public_path('uploads/images/users'), $image_name);
                $user->avatar = $image_name;
            }

            $user->save();

            DB::commit();
            return $this->res(true, __('main.user_updated'), 200, new UserDetailsResource($user));

        } catch (ValidationException $e) {
            DB::rollBack();
            return  $this->res(false , __('main.validation_failed')  ,  422 ,   ['errors' => $e->errors()]);

       }catch (\Exception $e) {
            DB::rollBack();
            return $this->res(false, __('main.error_happened'), $e->getCode(), $e->getMessage());
        }


    } // end update user




    public function store_address(AddressUserRequest $request){

        try {
            $user = $request->user();
            // Check if the user already has 3 addresses
            if ($user->address()->count() >= 3) {
            return $this->res(false, __('main.max_address'), 400);
            }

            DB::beginTransaction();
            $user_address = UserAddress::create([
                'user_id' => $user->id,
                'address'=>$request->address
            ]);
            DB::commit();
            return  $this->res(true ,__('main.user_address_added') , 200 , ['user'=> new UserDetailsResource($user)]);

        } catch (ValidationException $e) {
            DB::rollBack();
            return  $this->res(false , __('main.validation_failed')  ,  422 ,   ['errors' => $e->errors()]);

       }catch (\Exception $e) {
           DB::rollBack();
            return  $this->res(false ,__('main.error_happened') , 500 , $e->getMessage());

        }



    } //end store users address





    public function update_address(UpdateUserAddress $request){

        try {
            $user = $request->user();
            $address = $user->address()->find($request->address_id);
            if (!$address) {
                return $this->res(false, __('main.address_not_found'), 404, null);
            }
            $address->update([
                'address' => $request->address
            ]);
            return $this->res(true, __('main.user_address_updated'), 200, new UserDetailsResource($user));

        } catch (\Exception $e) {
            return $this->res(false, __('main.error_happened'), 500, $e->getMessage());
        }




    } // end update user address





    public function delete_address(Request $request)
    {
        try {
            $user = $request->user();
            $address = $user->address()->find($request->address_id);
            if (!$address) {
                return $this->res(false,  __('main.address_not_found'), 404, null);
            }
            $address->delete();
            return $this->res(true, __('main.address_deleted'), 200, new UserDetailsResource($user));
        } catch (\Exception $e) {
            return $this->res(false, __('main.error_happened'), 500, $e->getMessage());
        }
    }













    // public function get()
    // {
    //     $users = User::all();
    //     return  $this->res(true ,'All Users' , 200 ,UsersResource::collection($users));
    // }


    // public function store(StoreUserRequest $request){
    //     try{

    //             if($request->has('avatar')){
    //                 $image_name = $request->avatar->getClientOriginalName();
    //                 $request->avatar->move(public_path('uploads/images/users'), $image_name);
    //             }

    //             DB::beginTransaction();
    //                 $user = new User();
    //                 $user->first_name = $request->first_name;
    //                 $user->last_name  = $request->last_name;
    //                 $user->password   = Hash::make($request->password);
    //                 $user->email      = $request->email;
    //                 $user->phone  = $request->phone;
    //                 (isset($image_name) && $image_name != null) ? $user->avatar = $image_name : $user->avatar = null;
    //                 $user->save();
    //             DB::commit();
    //             return  $this->res(true ,'User Details' , 200 ,new UserDetailsResource($user));

    //     }catch(\Exception $e){

    //             DB::rollBack();
    //             return  $this->res(false ,'Error Happend' , $e->getCode() , $e->getMessage());


    //     }

    // }













    // logout
    // public function logout(Request $request)
    // {
    //     try {
    //         $user = $request->user();
    //         $user->tokens()->delete();
    //         return  $this->res(true ,'User Looged Out' , 200);

    //     } catch (\Exception $e) {
    //         return  $this->res(false ,'Error Happend' , 500 , $e->getMessage());

    //     }
    // }


    // change user passeword
    // public function change_password(ChangePasswordRequest $request)
    // {
    //     // Get the authenticated user
    //     $user = $request->user();
    //     // Verify the current password
    //     if (!Hash::check($request->current_password, $user->password)) {
    //         return  $this->res(true ,'Current password is incorrect.' , 400);
    //     }
    //     // Update the password
    //     $user->password = Hash::make($request->new_password);
    //     $user->save();
    //     return  $this->res(true ,'Password Changed Successfully !' , 200 , ['user'=> new UserDetailsResource($user)]);

    // }













          // Delete an address
    // public function delete_address(Request $request)
    // {
    //     try {
    //         $user = $request->user();
    //         $address = $user->address()->find($request->address_id);
    //        // dd($address);

    //         if (!$address) {
    //             return $this->res(false, 'Address not found!', 404, null);
    //         }

    //         // Delete the address
    //         $address->delete();

    //         return $this->res(true, 'User Address deleted successfully!', 200, new UserDetailsResource($user));
    //     } catch (\Exception $e) {
    //         return $this->res(false, 'Error happened', 500, $e->getMessage());
    //     }
    // }

    // public function all_address(Request $request){
    //     $user = $request->user();
    //     return $this->res(true, 'User Addresses retrieved successfully!', 200, new UserDetailsResource($user));
    // }



    // public function special_address(Request $request){
    //     $user = $request->user();
    //     $address = $user->address()->find($request->address_id);

    //     if (!$address) {
    //         return $this->res(false, 'Address not found!', 404, null);
    //     }
    //     return $this->res(true, 'User Address retrieved successfully!', 200, new UserAddressResource($address));
    // }




        // start rest password

        // public function rest_password(Request $request){


        //     try{
        //         // Validate the request data
        //         $validatedData = $request->validate([
        //             'email' => 'required|email',
        //         ], [
        //             'email.required' => 'Email is required.',

        //         ]);

        //         $user = User::where('email' , $request->email)->where('type' , 'user')->first();
        //         if(isset($user)){
        //             $rest_code = Str::random(40);
        //             $user->rest_password_code = $rest_code;
        //             $user->save();
        //             $resetLink = 'https://imtiazshop.com/reset-password?token=' . $rest_code; // Generate or fetch the reset token

        //             Mail::to($request->email)->send(new ChangePassword($resetLink));

        //            return  $this->res(true , 'Email Sent ! Check Your Email'  ,  200  , new UserDetailsResource($user));


        //         }
        //         return  $this->res(false , 'Email Not Found'  ,  404 );

        //     }catch (ValidationException $e) {
        //         DB::rollBack();
        //        // Handle validation exceptions
        //         return  $this->res(false , 'Validation failed: '  ,  422 ,   ['errors' => $e->errors()]);

        //    }catch(\Exception $e){
        //         return  $this->res(false , 'Failed To Delete Address'  ,  $e->getCode()  , $e->getMessage());

        //     }
        // }


        // public function check_rest_code(Request $request){
        //     try{
        //         // Validate the request data
        //         $validatedData = $request->validate([
        //             'rest_password_code' => 'required|string',
        //         ], [
        //             'rest_password_code.required' => 'Rest Password Code is required.',

        //         ]);

        //         $user = User::where('rest_password' , $request->rest_password_code)->first();
        //         if(isset($user)){
        //             $newToken = $user->createToken('auth_token')->plainTextToken;
        //             return  $this->res(true ,  'access_token' , 200 ,  ['access_token'=>$newToken , 'token_type' => 'Bearer' , 'user'=>new UserDetailsResource($user)]);

        //         }
        //         return  $this->res(false , 'Email Not Found',  404 );

        //     }catch (ValidationException $e) {
        //         DB::rollBack();
        //        // Handle validation exceptions
        //         return  $this->res(false , 'Validation failed: '  ,  422 ,   ['errors' => $e->errors()]);

        //    }catch(\Exception $e){
        //         return  $this->res(false , 'Failed To Delete Address'  ,  $e->getCode()  , $e->getMessage());

        //     }
        // }






}
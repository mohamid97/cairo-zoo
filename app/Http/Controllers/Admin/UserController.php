<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EditUserRequest;
use App\Models\Admin\Slider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    //
    public function index(Request $request)
    {

        $query = User::withTrashed();
        if($request->has('search') && !empty($request->search) ){
            $searchTerm = $request->search;
            $query = $query->where('first_name' , 'like' , '%' . $searchTerm . '%')->orWhere('last_name' , 'like' , '%' . $searchTerm . '%')
            ->orWhere('email' , 'like' , '%' . $searchTerm . '%')->orWhere('phone' , 'like' , '%' . $searchTerm . '%');
        }
        $accounts = $query->where('type' , '!=' , 'admin')->paginate(10);

        return view('admin.users.index' , [
            'accounts'=>$accounts,
            'searchTerm'=>$request->search ?? '',
        ]);

    }

    public function create(){
        return view('admin.users.add');
    }

    public function store(EditUserRequest $request){
        try{
            DB::beginTransaction();
            $image_name = null;
            if($request->has('avatar')){
                $image_name = $request->avatar->getClientOriginalName();
                $request->avatar->move(public_path('uploads/images/users'), $image_name);
            }
            User::create([
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'type'=>($request->user_type) ? $request->user_type : 'user',
                'password'=> ($request->password ) ? Hash::make($request->password) : Hash::make('123456789@m'),
                'avatar'     =>$image_name
            ]);
            DB::commit();
            Alert::success('success' , __('main.user_stored'));
            return redirect()->back();
        }catch (\Exception $e){
            dd($e->getMessage() , $e->getLine());
            DB::rollBack();
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->route('admin.users.index');
        }

    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit' , compact('user'));

    }


    public function update(EditUserRequest $request , $id)
    {
        try {


            DB::beginTransaction();
            $user = User::findOrFail($id);
            $user->update([
                'first_name' =>$request->first_name,
                'last_name'  =>$request->last_name,
                'email'      =>$request->email,
                'phone'      => $request->phone,
            ]);

            if($request->has('avatar')){
                $image_name = $request->avatar->getClientOriginalName();
                $request->avatar->move(public_path('uploads/images/users'), $image_name);
                if ($user->avatar != null && file_exists(public_path('uploads/images/users/' .$user->avatar))) {
                    unlink(public_path('uploads/images/users/' .$user->avatar));
                }
                $user->avatar = $image_name;
                $user->save();

            }
            DB::commit();
            Alert::success('success', 'User Updated Successfully !');
            return redirect()->route('admin.users.index');

        }catch (\Exception $e){
           DB::rollBack();
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->route('admin.users.index');
        }

    } // end update user


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->forceDelete();
        Alert::success('success', 'User Deleted Successfully !');
        return redirect()->route('admin.users.index');
    }

    public function soft_delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        Alert::success('success', 'User Soft Deleted Successfully !');
        return redirect()->route('admin.users.index');

    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        Alert::success('success', 'Users Restored Successfully !');
        return redirect()->route('admin.users.index');

    }



    public function redirectToGoogle()
    {

        return Socialite::driver('google')->redirect();
    }

    public function redirectToFacebook()
    {

        return Socialite::driver('facebook')->redirect();

    }
    public function handleFacebookCallback(){
        dd(123);
    }
    public function handleGoogleCallback()
    {
        $user_data = Socialite::driver('google')->user();
        // Check if user already exists using google_id
        $existingUser = User::where('google_id', $user_data->id)->first();
        if (isset($existingUser)) {
                $token = $existingUser->createToken('auth_token')->plainTextToken;
                return redirect()->to('https://imtiazshop.com/login/redirect?token=' . $token);
        } else {
                // Create a new user
                $user = new User();
                $user->first_name = $user_data->user['given_name'];
                $user->last_name  = $user_data->user['family_name'];
                $user->password   = Hash::make('123456');
                $user->email      = $user_data->user['email'];
                $user->phone      = null;
                $user->google_id = $user_data->id;
                $user->type       = 'user';
                $user->avatar     = null; // Assign the image name or null if no image
                $user->save();
                // Generate a personal access token
                $token = $user->createToken('auth_token')->plainTextToken;
                return redirect()->to('https://imtiazshop.com/login/redirect?token=' . $token);
        }


    } // end handel callback




}

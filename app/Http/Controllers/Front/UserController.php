<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Cart;
use Validator;
use Hash;
use Session;
use Auth;

class UserController extends Controller
{
    public function loginRegister(){
        return view ('front.users.login_register');
    }
    public function userRegister(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

                $validator = Validator::make($request->all(), [
                    'name' => 'required|string|max:100',
                    'mobile' => 'required|numeric|digits:11',
                    'email' => 'required|email|max:150|unique:users',
                    'password' => 'required|min:6',
                    'accept' => 'required',
                    'age'=>'required|min:2|max:100',
                    'gender'=>'required'
                    
                ],
                [
                    'accept.required' => 'Please accept our Terms & Conditions'
                ]
                );

            if($validator->passes()){
                 // Register the user
                    $user = new User;
                    $user->name = $data['name'];
                    $user->mobile = $data['mobile'];
                    $user->email = $data['email'];
                    $user->password = bcrypt($data['password']);
                    $user->gender = $data['gender'];  
                    $user->age = $data['age'];
                    $user->status = 0;
                    $user->save();

                    /*Activate the user only when user confirms his email account */

                     $email = $data['email'];
                     $messageData = ['name'=>$data['name'],'mobile'=>$data['mobile'],'email'=>$data['email'],'code'=>base64_encode($data['email'])];
                     Mail::send('emails.confirmation',$messageData,function($message)use($email){
                        $message->to($email)->subject('Confirm your account.'); 
                    });

                    //Redirect back user with success_message
                    $redirectTo = url('user/login-register');
                    return response()->json(['type'=>'success','url'=>$redirectTo,'message'=>'Please confirm your email to activate your account']);

                    
            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }

           
        }
    }

    public function userAccount(Request $request){
        if($request->ajax()){
            $data = $request->all();    
            /*echo "<pre>"; print_r($data); die;*/
                $validator = Validator::make($request->all(), [
                    'name' => 'required|string|max:100',
                    'mobile' => 'required|numeric|digits:11',
                    'age'=>'required|min:2|max:100',
                    'gender'=>'required'
                    
                ],
            );
            if($validator->passes()){
                // Update User Details
                User::where('id', Auth::user()->id)->update(['name'=>$data['name'],'mobile'=>$data['mobile'],'age'=>$data['age'],'gender'=>$data['gender'] ]);
                // Rediret back
                //$redirectTo = url('/cart');
                return response()->json(['type'=>'success','message'=>'Your contact details successfully updated!']);
            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }
        }else{
            return view('front.users.user_account');
        }
    }

    public function userUpdatePassword(Request $request){
        if($request->ajax()){
            $data = $request->all();    
            /*echo "<pre>"; print_r($data); die;*/
                $validator = Validator::make($request->all(), [
                    'current_password' => 'required',
                    'new_password' => 'required|min:6',
                    'confirm_password'=>'required|min:6|same:new_password'
                ],
            );
            if($validator->passes()){
                $current_password = $data['current_password'];
                $checkPassword = User::where('id',Auth::user()->id)->first();
                if(Hash::check($current_password,$checkPassword->password)){

                    // Update user Current Password
                    $user = User::find(Auth::user()->id);
                    $user->password = bcrypt($data['new_password']);
                    $user->save();

                    //$redirectTo = url('cart');
                    return response()->json(['type' => 'success', 'message' => 'Your account password has been successfully updated!',]);
                    

                }else{
                    return response()->json(['type'=>'incorrect','message'=>'Your current password is incorrect!']);
                }
      
            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }
        }else{
            return view('front.users.user_account');
        }
    }

    public function forgotPassword(Request $request){
        if($request->ajax()){
            $data = $request->all();
    
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:150|exists:users',
            ], [
                'email.exists' => 'Email does not exist!'
            ]);
    
            if($validator->passes()){
                // Generate New pass
                $new_password = rand(1000000, 9999999); // Generate a random 7-digit numeric password
    
                // Hash the new password
                $hashed_password = bcrypt($new_password);
    
                // Update new hashed password
                User::where('email', $data['email'])->update(['password' => $hashed_password]);
    
                // Get User Details
                $userDetails = User::where('email', $data['email'])->first()->toArray();
    
                // Send Email to user
                $email = $data['email'];
                $messageData = ['name' => $userDetails['name'], 'email' => $email, 'password' => $new_password];
                
                Mail::send('emails.user_forgot_password', $messageData, function($message) use ($email){
                    $message->to($email)->subject('New Password - Wavepad Management');
                });
    
                // Show Success Message
                return response()->json(['type' => 'success', 'message' => 'New Password sent to your registered email.']);
            } else {
                return response()->json(['type' => 'error', 'errors' => $validator->messages()]);
            }
        } else {
            return view('front.users.forgot_password');
        }
    }
    
    public function userLogin(Request $request){
        if($request->Ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:150|exists:users',
                'password' => 'required|min:6',
            ]);

            if($validator->passes()){

                if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){

                    if(Auth::user()->status==0){
                        Auth::logout();
                        return response()->json(['type'=>'inactive','message'=>'You account is not activated. Please confirm your account to activate.']);
                    }
                        // Update User cart with user id 
                        if(!empty(Session::get('session_id'))){
                            $user_id = Auth::user()->id;
                            $session_id = Session::get('session_id');
                            Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                        }

                    $redirectTo = url('cart');
                    return response()->json(['type'=>'success','url'=>$redirectTo]);
                }else{
                    return response()->json(['type'=>'incorrect','message'=>'Incorrect Email or Password!']);
                }

            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }
        }
    }

    public function userLogout(){
        Auth::logout();
        return redirect('/');
    }

    public function confirmAccount($code){
        $email = base64_decode($code);
        $userCount = User::where('email', $email)->count();
        if($userCount>0){
            $userDetails = User::where('email',$email)->first();
            if($userDetails->status==1){
                // Redirect the user to login page with error message
                return redirect('user/login-register')->with('error_message','Your email account is already activated You can log in now');
            }else{
                User::where('email',$email)->update(['status'=>1]);

            // Send Welcome Email
                $messageData = ['name'=>$userDetails->name,'mobile'=> $userDetails->mobile,'email'=>$email];

                Mail::send('emails.register',$messageData,function($message)use($email){
                        $message->to($email)->subject('Welcome to Wavepad'); 
                });
                 // Redirect the user to login page with success message
                 return redirect('user/login-register')->with('success_message','Your account is activated. You can login now!');

            }
        }else{
            abort(404);
        }
    }
}
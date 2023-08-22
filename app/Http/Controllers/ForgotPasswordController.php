<?php

namespace App\Http\Controllers;

use DB; 
use Mail;
use App\User;
use Carbon\Carbon; 
use Illuminate\Support\Str;
use App\Mail\ForgotPassword;
use Illuminate\Http\Request;
use Hash;

class ForgotPasswordController extends Controller
{
    public function showForgetPasswordForm()
    {
         return view('forgetpassword');
    }

    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
        ]);

        $data=[
            'token' => $token, 
        ];
        Mail::to($request->email)->send(new ForgotPassword($data));

        return back()->with('message', 'We have e-mailed your password reset link!');
    }

    public function showResetPasswordForm($token) { 
        return view('forgetpasswordlink', ['token' => $token]);
    }

    public function submitResetPasswordForm(Request $request)
    {
          $request->validate([
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);
  
          $updatePassword = DB::table('password_resets')->where('token',$request->token)->first();
  
          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }
  
          $user = User::where('email', $updatePassword->email)
                      ->update(['password' => Hash::make($request->password)]);
 
          DB::table('password_resets')->where(['email'=> $updatePassword->email])->delete();
  
          return redirect()->back()->with('message', 'Your password has been changed!');
    }
}

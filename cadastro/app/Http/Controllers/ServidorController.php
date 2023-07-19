<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Servidor;
use constGuards;
use constDefaults;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class ServidorController extends Controller
{
    public function loginHandler(Request $request){
        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if ($fieldType == 'email') {
            $request->validate([
               'login_id' =>'required|email|exists:servidors,email',
               'password' =>'required|min:5|max:45'
            ],
            [
               'login_id.required' =>'Email or Username is required',
               'login_id.email' =>'Invalid email address',
               'login_id.exists' =>'Email is not exists in system',
               'password.required' =>'Password is required',
            ]);
        } else {
            $request->validate([
                'login_id' =>'required|exists:servidors,username',
                'password' =>'required|min:5|max:45'
             ],
             [
                'login_id.required' =>'Email or Username is required',
                'login_id.exists' =>'Username is not exists in system',
                'password.required' =>'Password is required',
             ]);
        }

        $creds = array(
            $fieldType => $request->login_id,
            'password'=>$request->password
        );

        if( Auth::guard('servidor')->attempt($creds)){
            return redirect()->route('servidor.home');
        }else{
            session()->flash('fail', 'Incorrect credentials');
            return redirect()->route('servidor.login');
        }
    }

    public function logoutHandler(Request $request){
        Auth::guard('servidor')->logout();
        session()->flash('fail', 'You are logged out');
        return redirect()->route('servidor.login');
    }

    public function sendPasswordResetLink(Request $request){

        $request->validate([
            'email'=>'required|email|exists:servidors,email'
        ],[
            'email.required'=>'The :attribute is required',
            'email.email'=>'Invalid email address',
            'email.exists'=>'The :attribute is not exists in system'
        ]);

        //Get servidor details
        $servidor = Servidor::where('email', $request->email)->first();

        //Generate token
        $token = base64_encode(Str::random(64));

        //Check if there is an existing reset password token
        $oldToken = DB::table('password_reset_tokens')
                        ->where(['email'=>$request->email,'guard'=>constGuards::SERVIDOR])
                        ->first();
        if ( $oldToken ) {
            //Update token
            DB::table('password_reset_tokens')
                ->where(['email'=>$request->email,'guard'=>constGuards::SERVIDOR])
                ->update([
                    'token'=>$token,
                    'created_at'=>Carbon::now()
                ]);
        } else {
            //Add new token
            DB::table('password_reset_tokens')->insert([
                'email'=>$request->email,
                'guard'=>constGuards::SERVIDOR,
                'token'=>$token,
                'created_at'=>Carbon::now()
            ]);
        }

        $actionLink = route('servidor.reset-password', ['token'=>$token, 'email'=>$request->email]);

        $data = array(
            'actionLink'=>$actionLink,
            'servidor'=>$servidor
        );

        $mail_body = view('email-templates.servidor-forgot-email-template', $data)->render();

        $mailConfig = array(
            'mail_from_email'=>env('EMAIL_FROM_ADDRESS'),
            'mail_from_name'=>env('EMAIL_FROM_NAME'),
            'mail_recipient_email'=>$servidor->email,
            'mail_recipient_name'=>$servidor->name,
            'mail_subject'=>'Reset password',
            'mail_body'=>$mail_body
        );

        if ( sendEmail($mailConfig) ) {
            session()->flash('success','We have e-mailed your password reset link.');
            return redirect()->route('servidor.forgot-password');
        } else {
            session()->flash('fail','Something went wrong!');
            return redirect()->route('servidor.forgot-password');
        }

    }

    public function resetPassword(Request $request, $token = null){
        $check_token = DB::table('password_reset_tokens')
                            ->where(['token'=>$token,'guard'=>constGuards::SERVIDOR])
                            ->first();

        if ( $check_token ) {
            //Check if token is not expired
            $diffMins = Carbon::createFromFormat('Y-m-d H:i:s', $check_token->created_at)
            ->diffInMinutes(Carbon::now());

            if ( $diffMins > constDefaults::tokenExpiredMinutes ) {
                //if token expired
                session()->flash('fail','Token expired, request another reset password link');
                return redirect()->route('servidor.forgot-password',['token'=>$token]);
            } else {
                return view('back.pages.servidor.auth.reset-password')->with(['token'=>$token]);
            }

        } else {
            session()->flash('fail','Invalid token!, request another reset password link');
            return redirect()->route('servidor.forgot-password',['token'=>$token]);
        }
    }

    public function resetPasswordHandler(Request $request){
        $request->validate([
            'new_password'=>'required|min:5|max:45|required_with:new_password_confirmation|
            same:new_password_confirmation',
            'new_password_confirmation'=>'required'
        ]);


        $token = DB::table('password_reset_tokens')
                    ->where(['token'=>$request->token,'guard'=>constGuards::SERVIDOR])
                    ->first();

        //Get servidor details
        $servidor = Servidor::where('email', $token->email)->first();

        //Update servidor details
        Servidor::where('email', $servidor->email)->update(
                ['password'=>Hash::make($request->new_password)]
        );

        //Delete token record
        DB::table('password_reset_tokens')->where([
            'email'=>$servidor->email,
            'token'=>$request->token,
            'guard'=>constGuards::SERVIDOR,
        ])->delete();

        //Send email to notify servidor
        $data = array(
                'servidor'=>$servidor,
                'new_password'=>$request->new_password

        );

        $mail_body = view('email-templates.servidor-reset-email-template', $data)->render();

        $mailConfig = array(
            'mail_from_email'=>env('EMAIL_FROM_ADDRESS'),
            'mail_from_name'=>env('EMAIL_FROM_NAME'),
            'mail_recipient_email'=>$servidor->email,
            'mail_recipient_name'=>$servidor->name,
            'mail_subject'=>'Password changed',
            'mail_body'=>$mail_body
        );

        sendEmail($mailConfig);
        return redirect()->route('servidor.login')->with('success', 'Done!, Your password has been changed.
        Use new password to login into system.');

    }
}

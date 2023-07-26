<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Candidato;
use constGuards;
use constDefaults;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Validator;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class CandidatoController extends Controller
{

    public readonly Candidato $candidato;

    public function __construct(){

        $this->candidato = new Candidato();
    }


    /**
     * Display a listing of the resource.
     */
    /*public function index()
    {
        return view('');
    }*/

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('back.pages.candidato.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
       /* $validated = $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:'.Candidato::class,
            'password' => 'required|confirmed|max:100', Rules\Password::defaults(),
            'cpf' => 'required|integer|min:11|max:11|unique:'.Candidato::class,
            'sexo' => 'string|min:1|max:1',
            'nome_mae' => 'string|max:100',
            'dt_nascimento' => 'date',
            'escolaridade' => 'string|max:50',
            'vinculo' => 'string|max:50',
            'endereco' => 'string|max:70',
            'complemento' => 'string|max:70',
            'bairro' => 'string|max:70',
            'cidade' => 'string|max:20',
            'uf' => 'string|min:2|max:2',
            'cep' => 'integer|min:10|max:10',
            'rg' => 'integer',
            'org_exp' => 'string',
            'dt_emissao' => 'date',
            'telefone' => 'integer',
        ]);*/

        $candidato = $this->candidato->create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'cpf' => $request->input('cpf'),
            'sexo' => $request->input('sexo'),
            'nome_mae' => $request->input('nome_mae'),
            'dt_nascimento' => $request->input('dt_nascimento'),
            'escolaridade' => $request->input('escolaridade'),
            'vinculo' => $request->input('vinculo'),
            'endereco' => $request->input('endereco'),
            'complemento' => $request->input('complemento'),
            'bairro' => $request->input('bairro'),
            'cidade' => $request->input('cidade'),
            'uf' => $request->input('uf'),
            'cep' => $request->input('cep'),
            'rg' => $request->input('rg'),
            'org_exp' => $request->input('org_exp'),
            'dt_emissao' => $request->input('dt_emissao'),
            'telefone' => $request->input('telefone')
        ]);

        /*event(new Registered($candidato));

        Auth::login($candidato);

        return redirect(RouteServiceProvider::HOME);*/

        if ($candidato) {

            return redirect()->route('candidato.login')->with('message', 'Cadastro concluído com sucesso.');
        }

        return redirect()->route('candidato.login')->with('message', 'Erro ao criar o cadastro, tente outra vez.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function loginHandler(Request $request){
        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if ($fieldType == 'email') {
            $request->validate([
               'login_id' =>'required|email|exists:candidatos,email',
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
                'login_id' =>'required|exists:candidatos,username',
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

        if( Auth::guard('candidato')->attempt($creds)){
            session()->flash('success', 'Login feito!');
            return redirect()->route('candidato.home');
        }else{
            session()->flash('fail', 'Credenciais incorretas');
            return redirect()->route('candidato.login');
        }
    }

    public function logoutHandler(Request $request){
        Auth::guard('candidato')->logout();
        session()->flash('fail', 'Você está desconectado');
        return redirect()->route('candidato.login');
    }

    public function sendPasswordResetLink(Request $request){

        $request->validate([
            'email'=>'required|email|exists:candidatos,email'
        ],[
            'email.required'=>'The :attribute is required',
            'email.email'=>'Invalid email address',
            'email.exists'=>'The :attribute is not exists in system'
        ]);

        //Get candidato details
        $candidato = Candidato::where('email', $request->email)->first();

        //Generate token
        $token = base64_encode(Str::random(64));

        //Check if there is an existing reset password token
        $oldToken = DB::table('password_reset_tokens')
                        ->where(['email'=>$request->email,'guard'=>constGuards::CANDIDATO])
                        ->first();
        if ( $oldToken ) {
            //Update token
            DB::table('password_reset_tokens')
                ->where(['email'=>$request->email,'guard'=>constGuards::CANDIDATO])
                ->update([
                    'token'=>$token,
                    'created_at'=>Carbon::now()
                ]);
        } else {
            //Add new token
            DB::table('password_reset_tokens')->insert([
                'email'=>$request->email,
                'guard'=>constGuards::CANDIDATO,
                'token'=>$token,
                'created_at'=>Carbon::now()
            ]);
        }

        $actionLink = route('candidato.reset-password', ['token'=>$token, 'email'=>$request->email]);

        $data = array(
            'actionLink'=>$actionLink,
            'candidato'=>$candidato
        );

        $mail_body = view('email-templates.candidato-forgot-email-template', $data)->render();

        $mailConfig = array(
            'mail_from_email'=>env('EMAIL_FROM_ADDRESS'),
            'mail_from_name'=>env('EMAIL_FROM_NAME'),
            'mail_recipient_email'=>$candidato->email,
            'mail_recipient_name'=>$candidato->name,
            'mail_subject'=>'Reset password',
            'mail_body'=>$mail_body
        );

        if ( sendEmail($mailConfig) ) {
            session()->flash('success','We have e-mailed your password reset link.');
            return redirect()->route('candidato.forgot-password');
        } else {
            session()->flash('fail','Something went wrong!');
            return redirect()->route('candidato.forgot-password');
        }

    }

    public function resetPassword(Request $request, $token = null){
        $check_token = DB::table('password_reset_tokens')
                            ->where(['token'=>$token,'guard'=>constGuards::CANDIDATO])
                            ->first();

        if ( $check_token ) {
            //Check if token is not expired
            $diffMins = Carbon::createFromFormat('Y-m-d H:i:s', $check_token->created_at)
            ->diffInMinutes(Carbon::now());

            if ( $diffMins > constDefaults::tokenExpiredMinutes ) {
                //if token expired
                session()->flash('fail','Token expired, request another reset password link');
                return redirect()->route('candidato.forgot-password',['token'=>$token]);
            } else {
                return view('back.pages.candidato.auth.reset-password')->with(['token'=>$token]);
            }

        } else {
            session()->flash('fail','Invalid token!, request another reset password link');
            return redirect()->route('candidato.forgot-password',['token'=>$token]);
        }
    }

    public function resetPasswordHandler(Request $request){
        $request->validate([
            'new_password'=>'required|min:5|max:45|required_with:new_password_confirmation|
            same:new_password_confirmation',
            'new_password_confirmation'=>'required'
        ]);


        $token = DB::table('password_reset_tokens')
                    ->where(['token'=>$request->token,'guard'=>constGuards::CANDIDATO])
                    ->first();

        //Get candidato details
        $candidato = Candidato::where('email', $token->email)->first();

        //Update candidato details
        Candidato::where('email', $candidato->email)->update(
                ['password'=>Hash::make($request->new_password)]
        );

        //Delete token record
        DB::table('password_reset_tokens')->where([
            'email'=>$candidato->email,
            'token'=>$request->token,
            'guard'=>constGuards::CANDIDATO,
        ])->delete();

        //Send email to notify candidato
        $data = array(
                'candidato'=>$candidato,
                'new_password'=>$request->new_password

        );

        $mail_body = view('email-templates.candidato-reset-email-template', $data)->render();

        $mailConfig = array(
            'mail_from_email'=>env('EMAIL_FROM_ADDRESS'),
            'mail_from_name'=>env('EMAIL_FROM_NAME'),
            'mail_recipient_email'=>$candidato->email,
            'mail_recipient_name'=>$candidato->name,
            'mail_subject'=>'Password changed',
            'mail_body'=>$mail_body
        );

        sendEmail($mailConfig);
        return redirect()->route('candidato.login')->with('success', 'Done!, Your password has been changed.
        Use new password to login into system.');

    }
}

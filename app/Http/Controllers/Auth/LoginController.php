<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;

use App\Models\Common\Login;
use App\Models\Users\User;
use App\Models\Users\UserPerson;
use App\Models\Common\Utilities;
use App\Models\Competitions\Competition;
use Illuminate\Support\Facades\Mail;


class LoginController extends Controller
{
    public function login(){
        
        return view("auth/login")->with(["mesaj"=>["OK"]]);
    }
    
    
    public function changepassword(Request $request){

        $token = $request->token;
        
        return view("auth/changepassword", ['_passtoken'=>$token]);
    }

    public function changethepassword(Request $request){

        $password2 = $request->password2;

        $password = $request->password;

        $passtoken = $request-> _passtoken;

        if ($password !== $password2)
            return view("auth/changepassword")->with(["mesaj" => ['mesaj' =>'Ai introdus parole diferite. Incearca inca o data'], "_passtoken"=>$passtoken]);    

        $password = crypt($password, $password);




        $message = User::setPassword($password, $passtoken);

        if ($message == 'OK')
            return view("auth/login")->with(["mesaj" => ['mesaj' => 'Parola a fost modificata!']]);
        else
            return view("auth/changepassword")->with(["mesaj" => ['mesaj' =>$message], "_passtoken"=>$passtoken]);

    }
    
    
    public function resetpasswordmail(Request $request){
        // reset the password
        
       
        // if email exists ok and back to intex
        $Email = $request->input('email');
        
        $user = Login::EmailExists($Email);
        
        if (isset($user) && count($user) > 0) {

            $passtoken = uniqid();

            User::setPasswordReset($Email, $passtoken);


            $data = [
                'title' => 'Modifica parola',
                'content' => "Apasa linkul pentru a modifica parola",
                'link' => url('/changepassword?token='.$passtoken),

            ];
        
            Mail::send('mails.resetmail', $data, function($message) use ($Email){

                $message->to($Email, 'User')->from('noreply@fitascsporting.ro')->subject('Modificare parola');
            }

            );
            return view("auth/login")->with(["mesaj" =>['password'=> 'S-a trimis un email de confirmare catre adresa introdusa. Trebuie sa confirmi apasand link-ul din email!']]);
        }
        else
            return view("auth/reset")->with(["mesaj" =>['email'=> 'Nu exista utilizator cu emailul introdus!']]);
            
            
            
    }
    
    public function register(Request $request){

        $password2 = $request->password2;

        $password = $request->password;

        $Email = $request->Email;


        if ($password !== $password2)
            return view("auth/register")->with(["mesaj" => ['NotOK' =>'Ai introdus parole diferite. Incearca inca o data']]);    

        $password = crypt($password, $password);

        $request['Password'] = $password;



        $user = Login::EmailExists($Email);

        if (isset($user) && count($user) > 0) {
            return view("auth/register")->with(["mesaj" => ['NotOK' =>'Exista deja un utilizator cu acest email!']]);
        }

        $passtoken = uniqid();

        $request['Token'] = $passtoken;

        $data = [
            'title' => 'Inregistrare pe fitascsporting.ro',
            'content' => "Apasa linkul pentru a confirma emailul. Dupa confirmare se va analiza si crea utilizatorul. Veti primi un alt email de confirmare a utilizatorului!",
            'link' => url('/confirmregistration?token='.$passtoken),

        ];

        $message =  UserPerson::registeruser($request->all());

      


        if ($message == 'OK'){

            Mail::send('mails.registration', $data, function($message) use ($Email){

                    $message->to($Email, 'User')->from('noreply@fitascsporting.ro')->subject('Inregistrare pe fitascsporting.ro');
                }
            );

            return view("auth/login")->with(["mesaj" => ['mesaj' => 'S-a trimis un email pentru confirmare. Trebuie sa confirmi apasand link-ul din email!']]);
        }
        else{
            return view("auth/register")->with(["mesaj" => ['NotOK' =>$message]]);
        }
        
    }

    public function confirmregistrationemail(Request $request){

        $passtoken = $request->token;

        $message = UserPerson::saveRegisteredUser($passtoken);

        $Email = 'admin@fitascsporting.ro';
        $data = [
            'title' => 'Inregistrare noua pe fitascsporting.ro',
            'content' => "Apasa linkul pentru a vizualiza cererile!",
            'link' => url('/registeries'),

        ];

        if ($message == 'OK'){
            Mail::send('mails.registration', $data, function($message) use ($Email){

                $message->to($Email, 'User')->from('noreply@fitascsporting.ro')->subject('Inregistrare noua pe fitascsporting.ro');
                }
            );

            return view("auth/login")->with(["mesaj" => ['mesaj' => 'E-mailul tau a fost intregistrat. Vei primi un email cand userul tau este configurat.']]);
        }
        else
            return view("auth/register")->with(["mesaj" => ['NotOK' => $message]]);


    }
  
    
    public function authenticate(Request $request){
        
        
        $parola = crypt($request->input('password'), $request->input('password'));
        
        $user = Login::Login($request->input('username'));

        if (($request->input('password') === null) || ($request->input('username') === null)){
            return view("auth/login")->with(["mesaj" =>[ 'password'=> 'Introdu emailul si parola']]);
        }
        
        
        
        if (!empty($user)) {
            if ($user[0]->Password !==  $parola){
                return view("auth/login")->with(["mesaj" =>[ 'password'=> 'Parola incorecta']]);
            }
            else{
                
                $request->session()->put('PersonId', $user[0]->PersonId);
                $request->session()->put('IsSuperUser', $user[0]->IsSuperUser);
                $request->session()->put('username', $request->input('username'));
                $request->session()->put('name', $user[0]->Name);
                $request->session()->put('function', $user[0]->Function);
                $request->session()->put('email', $user[0]->Email);
                
                
                
                // get last login
                
              //  $lastUrl = Utilities::getLastUrl($user[0]->PersonId);

             //   if (count($lastUrl) == 0)
                return redirect("/");

                // if ($lastUrl[0]->Location == "logout")
                //     return redirect("welcome");
                // else    
                //     return redirect($lastUrl[0]->Location);
            }
        }
        else{
            return view("auth/login")->with(["mesaj" =>[ 'password'=> 'Email inexistent in baza de date']]);
        }
        
    }
    
    public function logout(Request $request){
        
        // return dd($request->input('password'));
        
        $request->session()->flush();
        
        return redirect("welcome");
        
        
    }


    public function getregisteries(){
      
        return view( 'auth.registeries',['master' => UserPerson::getregisteries(), 'teams' => Competition::getTeams()]);
        
    
    }

    public function finishuser(Request $request){

        $mesaj = '';

        $Email = $request['Email'];
        $PersonId = $request['PersonId'];
        $RegisterId = $request['RegisterId'];
        $TeamId = $request['TeamId'];
        $Team = $request['Team'];

        $mesaj = UserPerson::finishuser($RegisterId, $PersonId, $Email, $TeamId, $Team);

        if ($mesaj == '')
        {

            $data = [
                'title' => 'Confirmare cont pe fitascsporting.ro',
                'content' => "Contul tau a fost configurat. Poti sa te loghezi urmand linkul",
                'link' => url('/login'),
    
            ];


    
            Mail::send('mails.registration', $data, function($message) use ($Email){

                    $message->to($Email, 'User')->from('noreply@fitascsporting.ro')->subject('Confirmare cont pe fitascsporting.ro');
                }
            );


                return redirect( '/registeries')->with('mesaj', $mesaj);
        }
        else{
            return redirect( "/registere/$RegisterId")->with('mesaj', $mesaj);
        }

    }

    public function getregistere($RegisterId ){
        return view( 'auth.registere',['register' => UserPerson::getregistere($RegisterId), 'persons' => UserPerson::getPersonNoUser(),  'teams' => Competition::getTeams()]);
    }

    
    
    
}

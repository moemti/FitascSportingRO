<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;

use App\Models\Common\Login;
use App\Models\Users\User;
use App\Models\Users\UserPerson;
use App\Models\Common\Utilities;
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
            return view("auth/changepassword")->with(["mesaj" => ['mesaj' =>'You entered different passwords! Try again'], "_passtoken"=>$passtoken]);    

        $password = crypt($password, $password);




        $message = User::setPassword($password, $passtoken);

        if ($message == 'OK')
            return view("auth/login")->with(["mesaj" => ['The password has been changed!']]);
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
                'title' => 'Change password',
                'content' => "Click the link to change your password",
                'link' => url('/changepassword?token='.$passtoken),

            ];
        
            Mail::send('mails.resetmail', $data, function($message) use ($Email){

                $message->to($Email, 'User')->from('noreply@fitascsporting.ro')->subject('Password change');
            }

            );
            return view("auth/login")->with(["mesaj" =>['password'=> 'An email was sent to you. Follow the link received to change your password!']]);
        }
        else
            return view("auth/reset")->with(["mesaj" =>['email'=> 'There is no user with the email you entered!']]);
            
            
            
    }
    
    public function register(Request $request){

        $password2 = $request->password2;

        $password = $request->password;

        $Email = $request->Email;


        if ($password !== $password2)
            return view("auth/register")->with(["mesaj" => ['NotOK' =>'You entered different passwords! Try again']]);    

        $password = crypt($password, $password);

        $request['Password'] = $password;



        $user = Login::EmailExists($Email);

        if (isset($user) && count($user) > 0) {
            return view("auth/register")->with(["mesaj" => ['NotOK' =>'There already exist an user with this email!']]);
        }

        $passtoken = uniqid();

        $request['Token'] = $passtoken;

        $data = [
            'title' => 'Registration to fitascsporting.ro',
            'content' => "Click the link to confirm your email. After confirming your email, your request will be analyzed and you will receive a confirmation email!",
            'link' => url('/confirmregistration?token='.$passtoken),

        ];

        $message =  UserPerson::registeruser($request->all());

      


        if ($message == 'OK'){

            Mail::send('mails.registration', $data, function($message) use ($Email){

                    $message->to($Email, 'User')->from('noreply@fitascsporting.ro')->subject('Registration to fitascsporting.ro');
                }
            );

            return view("auth/register")->with(["mesaj" => ['OK'=>'You will receive an email to confirm your email. Please check your email and click the confirmation link']]);
        }
        else{
            return view("auth/register")->with(["mesaj" => ['NotOK' =>$message]]);
        }
        
    }

    public function confirmregistrationemail(Request $request){

        $passtoken = $request->token;

        $message = UserPerson::saveRegisteredUser($passtoken);

        if ($message == 'OK'){
            return view("auth/register")->with(["mesaj" => ['OK'=>'Your email has been confirmed. You will receive an email when your account is ready.']]);
        }
        else
            return view("auth/register")->with(["mesaj" => ['NotOK' =>$message]]);


    }
  
    
    public function authenticate(Request $request){
        
        
        $parola = crypt($request->input('password'), $request->input('password'));
        
        $user = Login::Login($request->input('username'));

        if (($request->input('password') === null) || ($request->input('username') === null)){
            return view("auth/login")->with(["mesaj" =>[ 'password'=> 'Introduceti emailul si parola']]);
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
    
    
}

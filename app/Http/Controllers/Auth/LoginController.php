<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Common\Login;
use App\Models\Competitions\Competition;
use App\Models\Dictionaries\Dictionary;
use App\Models\Users\Person;
use App\Models\Users\User;
use App\Models\Users\UserPerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth/login')->with(['mesaj' => ['OK']]);
    }

    public function changepassword(Request $request)
    {
        $token = $request->token;
        return view('auth/changepassword', ['_passtoken' => $token]);
    }

    public function changethepassword(Request $request)
    {
        $password2 = $request->password2;

        $password = $request->password;
        $passtoken = $request->_passtoken;

        if ($password !== $password2) {
            return view('auth/changepassword')->with(['mesaj' => ['mesaj' => transex('Ai introdus parole diferite. Incearca inca o data')], '_passtoken' => $passtoken]);
        }

        $password = crypt($password, $password);
        $message = User::setPassword($password, $passtoken);

        if ($message == 'OK') {
            return view('auth/login')->with(['mesaj' => ['mesaj' => transex('Parola a fost modificata!')]]);
        } else {
            return view('auth/changepassword')->with(['mesaj' => ['mesaj' => $message], '_passtoken' => $passtoken]);
        }
    }

    public function resetpasswordmail(Request $request)
    {
        // reset the password

        // if email exists ok and back to intex
        $Email = $request->input('email');

        $user = Login::EmailExists($Email);

        if (isset($user) && count($user) > 0) {
            $passtoken = uniqid();

            User::setPasswordReset($Email, $passtoken);

            $data = [
                'title' => transex('Modificare parola'),
                'content' => transex('Apasa linkul pentru a modifica parola'),
                'link' => url('/changepassword?token=' . $passtoken),
            ];

            Mail::send('mails.resetmail', $data, function ($message) use ($Email) {
                $message->to($Email, 'User')->from('noreply@fitascsporting.ro')->subject(transex('Modificare parola'));
            });
            return view('auth/login')->with(['mesaj' => ['password' => transex('S-a trimis un email de confirmare catre adresa introdusa. Trebuie sa confirmi apasand link-ul din email!')]]);
        } else {
            return view('auth/reset')->with(['mesaj' => ['email' => transex('Nu exista utilizator cu emailul introdus!')]]);
        }
    }

    public function register(Request $request)
    {
        $password2 = $request->password2;
        $password = $request->password;
        $Email = $request->Email;

        if ($password !== $password2) {
            return view('auth/register')->with(['mesaj' => ['NotOK' => transex('Ai introdus parole diferite. Incearca inca o data')]]);
        }

        $password = crypt($password, $password);
        $request['Password'] = $password;
        $user = Login::EmailExists($Email);

        if (isset($user) && count($user) > 0) {
            return view('auth/register')->with(['mesaj' => ['NotOK' => transex('Exista deja un utilizator cu acest email!')]]);
        }

          // verific daca a mai facut o cerere

          $toapprove = Login::RegisterExistsToApprove($Email);

          if (isset($toapprove) and count($toapprove) > 0){
       
              return view('auth/register')->with(['mesaj' => ['NotOK' => transex('Utilizatorul cu acest email este in proces de aprobare')]]);
          }

          $passtoken = Login::RegisterExists($Email);

          if (isset($passtoken) and count($passtoken) > 0){
              $passtoken = $passtoken[0]->Token;
          }
          else
              $passtoken = uniqid();

        $request['Token'] = $passtoken;

        $data = [
            'title' => transex('Inregistrare pe fitascsporting.ro'),
            'content' => transex('Apasa linkul pentru a confirma emailul. Dupa confirmare se va analiza si crea utilizatorul. Veti primi un alt email de confirmare a utilizatorului!'),
            'link' => url('/confirmregistration?token=' . $passtoken),
        ];

        $message = UserPerson::registeruser($request->all());

        if ($message == 'OK') {
            Mail::send('mails.registration', $data, function ($message) use ($Email) {
                $message->to($Email, 'User')->from('noreply@fitascsporting.ro')->subject(transex('Inregistrare pe fitascsporting.ro'));
            });

            Mail::send('mails.registration', $data, function ($message) use ($Email) {
                $message->to('admin@fitascsporting.ro', 'User')->from('noreply@fitascsporting.ro')->subject(transex('Inregistrare pe fitascsporting.ro COPY'));
            });

            return view('auth/login')->with(['mesaj' => ['mesaj' => transex('S-a trimis un email pentru confirmare. Trebuie sa confirmi apasand link-ul din email!')]]);
        } else {
            return view('auth/register')->with(['mesaj' => ['NotOK' => $message]]);
        }
    }

    public function registerUserAPI(Request $request)
    {
        $IsOld = false;
        try{
            $password2 = $request->password2;
            $password = $request->password;
            $Email = $request->Email;

            if ($password !== $password2) {
                return ['status' => 'Error', 'Mesaj' => transex('Ai introdus parole diferite. Incearca inca o data')];
            }

            $password = crypt($password, $password);
            $request['Password'] = $password;
            $user = Login::EmailExists($Email);

            if (isset($user) && count($user) > 0) {
                return ['status' => 'Error', 'Mesaj' =>  transex('Exista deja un utilizator cu acest email!')];
            }

            // verific daca a mai facut o cerere

            $toapprove = Login::RegisterExistsToApprove($Email);

            if (isset($toapprove) and count($toapprove) > 0){
                return ['status' => 'Error', 'Mesaj' =>  transex('Utilizatorul cu acest email este in proces de aprobare')];
            }

            $passtoken = Login::RegisterExists($Email);

            if (isset($passtoken) and count($passtoken) > 0){
                $passtoken = $passtoken[0]->Token;
                $IsOld = true;
            }
            else
                $passtoken = uniqid();

            $request['Token'] = $passtoken;

            $data = [
                'title' => transex('Inregistrare pe fitascsporting.ro'),
                'content' => transex('Apasa linkul pentru a confirma emailul. Dupa confirmare se va analiza si crea utilizatorul. Veti primi un alt email de confirmare a utilizatorului!'),
                'link' => url('/confirmregistration?token=' . $passtoken),
            ];

            $message =  $IsOld ?  "OK" : UserPerson::registeruser($request->all()) ;

            if ($message == 'OK' ) {
                Mail::send('mails.registration', $data, function ($message) use ($Email) {
                    $message->to($Email, 'User')->from('noreply@fitascsporting.ro')->subject(transex('Inregistrare pe fitascsporting.ro'));
                });

                Mail::send('mails.registration', $data, function ($message) use ($Email) {
                    $message->to('admin@fitascsporting.ro', 'User')->from('noreply@fitascsporting.ro')->subject(transex('Inregistrare pe fitascsporting.ro COPY'));
                });

                return  ['status' => 'OK', 'Mesaj' =>transex('S-a trimis un email pentru confirmara email-ului. Trebuie sa confirmi apasand link-ul din email!')];
            } else {
                return ['status' => 'Error', 'Mesaj' => $message];
            }
        } catch (\Exception $e) {
            return ['status' => 'Error', 'Mesaj' => transex($e->getMessage())];
        }

    }

    public function confirmregistrationemail(Request $request)
    {
        $passtoken = $request->token;

        $confirmedEmail = '';

        $message = UserPerson::saveRegisteredUser($passtoken, $confirmedEmail);

        $Email = 'admin@fitascsporting.ro';
        $data = [
            'title' => transex('Inregistrare noua pe fitascsporting.ro de catre emailul: ') . $confirmedEmail,
            'content' => transex('Apasa linkul pentru a vizualiza cererile!'),
            'link' => url('/registeries'),
        ];

        if ($message == 'OK') {
            Mail::send('mails.registration', $data, function ($message) use ($Email) {
                $message->to($Email, 'User')->from('noreply@fitascsporting.ro')->subject(transex('Inregistrare noua pe fitascsporting.ro'));
            });

            return view('auth/login')->with(['mesaj' => ['mesaj' => transex('Emailul tau a fost intregistrat. Vei primi un email cand userul tau este configurat.')]]);
        } else {
            return view('auth/register')->with(['mesaj' => ['NotOK' => $message]]);
        }
    }

    public function authenticate(Request $request)
    {
        $parola = crypt($request->input('password'), $request->input('password'));
        $user = Login::Login($request->input('username'));

        if (($request->input('password') === null) || ($request->input('username') === null)) {
            return view('auth/login')->with(['mesaj' => ['password' => transex('Introduceti emailul si parola')]]);
        }

        if (!empty($user)) {
            if ($user[0]->Password !== $parola) {
                return view('auth/login')->with(['mesaj' => ['password' => transex('Parola incorecta')]]);
            } else {
                $request->session()->put('PersonId', $user[0]->PersonId);
                $request->session()->put('IsSuperUser', $user[0]->IsSuperUser);
                $request->session()->put('username', $request->input('username'));
                $request->session()->put('name', $user[0]->Name);
                $request->session()->put('function', $user[0]->Function);
                $request->session()->put('email', $user[0]->Email);
                return redirect('/');
            }
        } else {
            return view('auth/login')->with(['mesaj' => ['password' => transex('Email inexistent in baza de date')]]);
        }
    }

    public function loginApi(Request $request)
    {
        $parola = crypt($request->password, $request->password);
        $user = $request->email;
        $device = $request->device;

        $user = Login::Login($user);

        if (!empty($user)) {
            if ($user[0]->Password !== $parola) {
                return ['status' => 'Error', 'Mesaj' => transex('Parola incorecta')];
            } else {
                return ['status' => 'OK',
                    'data' => [
                        'Token' => Login::getUserToken($user[0]->PersonId, $device),
                        'PersonId' => $user[0]->PersonId,
                        'Name' => $user[0]->Name,
                    ]];
            }
        } else {
            return ['status' => 'Error', 'Mesaj' => transex('Email inexistent')];
        }
    }

    public function loginApiToken(Request $request)
    {
        $token = $request->token;

        $user = Login::loginApiToken($token);

        if (!empty($user)) {
            return ['status' => 'OK',
                'data' => [
                    'Token' => $token,
                    'PersonId' => $user[0]->PersonId,
                    'Name' => $user[0]->Name,
                ]];
        } else {
            return ['status' => 'Error', 'Mesaj' => transex('token inexistent')];
        }
    }

    public function getmyusertoken(Request $request, $token)
    {
        $user = Login::loginApiToken($token);

        if (count($user) == 0) {
            return redirect('login');
        } else {
            $request->session()->put('PersonId', $user[0]->PersonId);
            $request->session()->put('IsSuperUser', $user[0]->IsSuperUser);
            $request->session()->put('username', $request->username);
            $request->session()->put('name', $user[0]->Name);
            $request->session()->put('function', $user[0]->Function);
            $request->session()->put('email', $user[0]->Email);
            $PersonId = $user[0]->PersonId;

            $ob = new Person;

            return view('modules.pages.editables/users/myuser', ['data' => $ob->getMyUser($PersonId), 'teams' => $ob->getTeams(), 'countries' => Dictionary::getCountries()]);
        }
    }

    public function logoutApi($token)
    {
        return Login::logoutToken($token);
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('welcome');
    }

    public function getregisteries()
    {
        return view('auth.registeries', ['master' => UserPerson::getregisteries(), 'teams' => Competition::getTeams()]);
    }

    public function finishuser(Request $request)
    {
        $mesaj = '';
        $Email = $request['Email'];
        $PersonId = $request['PersonId'];
        $RegisterId = $request['RegisterId'];
        $TeamId = $request['TeamId'];
        $Team = $request['Team'];
        $mesaj = UserPerson::finishuser($RegisterId, $PersonId, $Email, $TeamId, $Team);

        if ($mesaj == '') {
            $data = [
                'title' => transex('Confirmare cont pe fitascsporting.ro'),
                'content' => transex('Contul tau a fost configurat. Poti sa te loghezi urmand linkul'),
                'link' => url('/login'),
            ];

            Mail::send('mails.registration', $data, function ($message) use ($Email) {
                $message->to($Email, 'User')->from('noreply@fitascsporting.ro')->subject(transex('Confirmare cont pe fitascsporting.ro'));
            });

            return redirect('/registeries')->with('mesaj', $mesaj);
        } else {
            return redirect("/registere/$RegisterId")->with('mesaj', $mesaj);
        }
    }


    public function deletecerere(Request $request)
    {
        $mesaj = '';
        $RegisterId = $request['RegisterId'];
        $mesaj = UserPerson::deletecerere($RegisterId);
        return redirect('/registeries')->with('mesaj', $mesaj);
    }
     

    public function getregistere($RegisterId)
    {
        return view('auth.registere', ['register' => UserPerson::getregistere($RegisterId), 'persons' => UserPerson::getPersonNoUser(), 'teams' => Competition::getTeams()]);
    }
}

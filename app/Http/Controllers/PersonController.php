<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\MasterController;
use App\Models\Dictionaries\Dictionary;

class PersonController extends MasterController
{
    public $BObject = 'App\Models\Users\Person';

    public $views = ['master'=>'modules.pages.persoane.person'];

    public function getDictionaries(){
 
        return ['roles' => $this->BObject()->getRoles(), 'seasons' => $this->BObject()->getSeasons(),  'shootercategories' => $this->BObject()->getShooterCategories(),
                              'teams' => $this->BObject()->getTeams(), 'countries' =>  Dictionary::getCountries()];
    }

    public function getmyuser(){
        $PersonId = session('PersonId');
        return view('modules.pages.editables/users/myuser', ['data' => $this->BObject()->getMyUser($PersonId),  'teams' => $this->BObject()->getTeams(),  'countries' =>  Dictionary::getCountries()]);
    }

    public function savemyuser(Request $request){
        return $this->BObject()->saveMyUser($request);
    }

    public function deletemyuser(Request $request){
        $r = $this->BObject()->deleteMyUser($request) ;
        if($r == 'OK'){
            $request->session()->flush();
            return redirect('welcome');
        }
        else
            return $r;
    }

    public function changemypassvord(Request $request){
        $PersonId = session('PersonId');
        $password = $request['Password'];
        $password = crypt($password, $password);
        $this->BObject()->setPassword($PersonId, $password);
        return 'OK';
    }

    public function echivalarepersoana(Request $request){
        $badId = $request['badId'];
        $goodId = $request['goodId'];
        return  $this->BObject()->echivalarepersoana($badId, $goodId);
    }

    public function MyInfo($PersonId){
        return $this->BObject()->getMyUser($PersonId)[0];
    }

    
    public function saveMyInfo(Request $request){
        return $this->BObject()->saveMyInfo($request);
    }

}
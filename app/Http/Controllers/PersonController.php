<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\MasterController;






class PersonController extends MasterController
{
    public $BObject = 'App\Models\Users\Person';

    public $views = ['master'=>'modules.pages.persoane.person'];


    public function getDictionaries(){
 
        return ['roles' => $this->BObject()->getRoles(), 'seasons' => $this->BObject()->getSeasons(),  'shootercategories' => $this->BObject()->getShooterCategories(),
                              'teams' => $this->BObject()->getTeams()];
    }


    public function getmyuser(){
        $PersonId = session('PersonId');
        return view('modules.pages.editables/users/myuser', ['data' => $this->BObject()->getMyUser($PersonId)]);
    }


    public function savemyuser(Request $request){
        return $this->BObject()->saveMyUser($request);
        
    }

    public function changemypassvord(Request $request){
        $PersonId = session('PersonId');
        $password = $request['Password'];

        $password = crypt($password, $password);
         $this->BObject()->setPassword($PersonId, $password);
        return 'OK';
        
    }


    


}
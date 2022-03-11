<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\MasterController;






class CompetitiiController extends MasterController
{
    public $BObject = 'App\Models\Competitions\Competition';

    public $views = ['master'=>'modules.pages.competitii', 'detail' => 'modules.pages.competitiidetail'];

    public function getDictionaries(){
        return ['years' => $this->BObject()->getCompetitionYears()];
    }

    public function getClasament($ItemId){
        return view( 'modules.pages.competitiedetail',['master' => $this->BObject()->getMaster($ItemId), 'clasament' => $this->BObject()->GetClasament($ItemId)]);
    }

    public function editresult($ResultId){
        return view( 'modules.pages.competition.resultedit',[
                                                         
                                                            'MasterPrimaryKey' => 'ResultId',
                                                            'MasterPrimaryKeyValue' => $ResultId,
                                                            'teams' => $this->BObject()->getTeams(),
                                                            'categories' => $this->BObject()->getShootingCategories(),
                                                        
                                                        ]);
    }


    public function getresultajax(Request $request){
        $ResultId = $request->ResultId;
        return [$this->BObject()->getresultDetail($ResultId)];
    }

    public function saveresultdetail(Request $request){
        $fields = $request->all();
        return $this->BObject()->SaveResultsDetail($fields);
    }

    public function getresultdetailsajax(Request $request){
      
        $ResultId = $request['MasterKeyField'];
        return [$this->BObject()->getresultDetails($ResultId)];
    }


    public function changeCompetitionStatus(Request $request){

        $Status = $request->Status;
        $CompetitionId = $request->CompetitionId;

        return $this->BObject()->changeCompetitionStatus($CompetitionId, $Status);
    }

    public function registerMe(Request $request){

        $PersonId = session('PersonId');
        $Register = $request->Register == 1;
        $CompetitionId = $request->CompetitionId;
        if ($Register)
            return $this->BObject()->registerMe($CompetitionId, $PersonId);
        else
            return $this->BObject()->unRegisterMe($CompetitionId, $PersonId);
    }
    

    public function registerCompetitor(Request $request){
        $CompetitionId = $request->CompetitionId;

        return view('modules.pages.competition.addcompetitor')->with(["CompetitionId"=>$CompetitionId, "persons"=>$this->BObject()->getUnregisteredPersons($CompetitionId)]);
    }

    public function registerCompetitorDB(Request $request){
        $CompetitionId = $request->CompetitionId;
        $PersonId = $request->PersonId;
        $Name = $request->Name;

        return $this->BObject()->registerCompetitorDB($CompetitionId, $PersonId, $Name);
    }





}
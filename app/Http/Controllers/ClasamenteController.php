<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\MasterController;






class ClasamenteController extends MasterController
{
    public $BObject = 'App\Models\Competitions\Clasamente';

    public $views = ['master'=>'modules.pages.competitii', 'detail' => 'modules.pages.competitiidetail'];

    public function getDictionaries(){
        return ['years' => $this->BObject()->getCompetitionYears()];
    }

    
    public function getClasamente(){
        $years = $this->getDictionaries();
        $year = $years["years"][0]->Year;
        $clasamentSup = $this->BObject()->GetClasamentSuperCupa($year);
        return view( 'modules.pages.clasamente',['clasament' => $this->BObject()->GetClasament($year), 'clasamentsup' => $clasamentSup], $years);
    }

    public function getClasamentByYear(Request $request){
        $year = $request->Year;
        return  [$this->BObject()->GetClasament($year),  $this->BObject()->GetClasamentSuperCupa($year)];
    }
    
    public function getResultsPersonyYear(Request $request){
        $year = $request->Year;
        $PersonId = $request->PersonId;
        return  $this->BObject()->getResultsPersonyYear($PersonId, $year);
    }

    function getClasamentYearsAPI(){
        return $this->BObject()->getClasamentYearsAPI();
    }
    
    function getClasamentByYearAPI($year){
        return $this->BObject()->getClasamentByYearAPI($year);
    }

}
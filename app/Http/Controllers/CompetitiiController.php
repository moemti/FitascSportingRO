<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\MasterController;






class CompetitiiController extends MasterController
{
    public $BObject = 'App\Models\Competitions\Competition';

    public $views = ['master'=>'modules.pages.competitii', 'detail' => 'modules.pages.competitiidetail'];

    // public function getOtherDetail($ItemId, Request $request){
    //     return ['clasament' => $this->BObject()->GetClasament($ItemId)];
    // }

    
    public function getClasament($ItemId){
        return view( 'modules.pages.competitiedetail',['master' => $this->BObject()->getMaster($ItemId), 'clasament' => $this->BObject()->GetClasament($ItemId)]);
    }


}
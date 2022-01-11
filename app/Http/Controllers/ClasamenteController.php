<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\MasterController;






class ClasamenteController extends MasterController
{
    public $BObject = 'App\Models\Competitions\Clasamente';

    public $views = ['master'=>'modules.pages.competitii', 'detail' => 'modules.pages.competitiidetail'];

    // public function getOtherDetail($ItemId, Request $request){
    //     return ['clasament' => $this->BObject()->GetClasament($ItemId)];
    // }

    
    public function getClasamente(){
        return view( 'modules.pages.clasamente',[ 'clasament2021' => $this->BObject()->GetClasament2021()]);
    }


}
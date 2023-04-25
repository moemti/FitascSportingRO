<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\MasterController;
use App\Models\Dictionaries\Dictionary;





class ClubController extends MasterController
{
    public $BObject = 'App\Models\Dictionaries\Club';

    public $views = ['master'=>'modules.pages.clubedit'];


    
    
    
    public function echivalareclub(Request $request){
        
        
        
        $badId = $request['badId'];
        $goodId = $request['goodId'];
        
        
        return  $this->BObject()->echivalareclub($badId, $goodId);
        
        
    }


}


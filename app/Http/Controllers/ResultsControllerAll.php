<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;

use App\Models\Dictionaries\BObject;
use App\Models\Competitions\Competition;



class ResultsControllerAll extends Controller
{
    public $BObject = 'App\Models\Competitions\ResultsAll';

    public $MasterPrimayKeys = 'ResultId';
    public $MasterFilter = 'CompetitionId';


    public $theobject = null;

    public function BObject(){
        return $this->theobject;
     }
  
    public function getDictionaries(){
        return [];
    }

    public function getdictionariesajax(Request $request){
        return [];
    }

    public function getOtherDetail($ItemId, Request $request){
        return [];
    }

    public function __construct(){
        

        $r = new \ReflectionClass($this->BObject);
        $this->theobject =  $r->newInstanceArgs([]);
    }


    public function getlist($Item){
        $title = Competition::getCompetitionName($Item);

        $items = $this->BObject()->getMasterList( $Item);

    

        $MasterPrimayKeys = $this->BObject()->MasterKeyFields();
      

  

        return view('modules.pages.competitieaddresults', array_merge(['masterlist' => $items, 'MasterPrimaryKeys'=>$MasterPrimayKeys, 'MasterFilter' => $Item, 'Title' => $title], $this->getDictionaries()));
    }


    public function getlistajax(Request $request){


        $Item = $request['MasterFilter'];
     


        return $this->BObject()->getMasterList( $Item);


    }


    public function savelist(Request $request){
        $fields = $request->all();
     
        return $this->BObject()->Save($fields);
    }

}
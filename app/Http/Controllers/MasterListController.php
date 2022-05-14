<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;

use App\Models\Dictionaries\BObject;




class MasterListController extends Controller
{
    public $BObject = null;
    public $MasterPrimayKeys = null;
    public $MasterFilter = null;
    public $view = null;


    public $theobject = null;

    public function getTitle($Item){
        return '';
    }

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


    public function getlist($Item = null){
        $title = $this->getTitle($Item);
        $items = $this->BObject()->getMasterList($Item);
        $MasterPrimayKeys = $this->BObject()->MasterKeyFields();
       
        return view($this->view, array_merge(['masterlist' => $items, 'MasterPrimaryKeys'=>$MasterPrimayKeys, 'MasterFilter' => $Item, 'Title' => $title], $this->getDictionaries()));
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
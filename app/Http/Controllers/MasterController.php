<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;

use App\Models\Dictionaries\BObject;




class MasterController extends Controller
{

    public $BObject = '';
    public $ModuleCode = '';
    public $views;

    public $theobject = null;
    public $OrganizationId;

    public function __construct(){
        
        $this->OrganizationId = session('organizationId');

        $r = new \ReflectionClass($this->BObject);
        $this->theobject =  $r->newInstanceArgs([$this->OrganizationId]);
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

    public function GetInitialFilter(){

        $filter = $this->BObject()->GetInitialFilter();

        if (empty($filter))
            return app(CommonDictionariesController::class)->getModuleInitialFilter($this->ModuleCode);
        else    
            return $filter;
    }

    public function getlist(Request $request){

        $thefilter = '';
        $thecaption = '';
        $filterkey = 'LAST_FILTER.'.get_class($this) ;
        $filtercaptionkey = 'LAST_FILTER_CAPTION.'.get_class($this) ;

        if (session()->has($filterkey)){
            $thefilter = session($filterkey);
            $thecaption = session($filtercaptionkey);
        }

        $filter[0] = $thecaption;    
        $filter[1] = $thefilter;

 
        

        $OrganizationId = session('organizationId');
        $PersonId = session('PersonId');

        $others = ['PersonId' => $PersonId];

        $items = $this->BObject()->getMasterList($OrganizationId, $thefilter, $others);

        $MasterPrimayKey = $this->BObject()->MasterKeyField();
        $DetailPrimaryKey = $this->BObject()->DetailKeyField();
        $DefaultMasterValues = $this->BObject()->DefaultMasterValues();
        $cfilters = $this->BObject()->CustomFilters();
        $FilterSource = $this->BObject()->FilterSource();


        $Permissions = app(CommonDictionariesController::class)->GetDeniedModulePermissions($PersonId, $this->ModuleCode);

  

        return view($this->views['master'], array_merge(['masterlist' => $items, 'DefaultMasterValues' => $DefaultMasterValues,'CustomFilters' => $cfilters, 
                'FilterSource'=> $FilterSource, 'MasterPrimaryKey'=>$MasterPrimayKey, 'DeniedPermissions' => $Permissions,
                'DetailPrimaryKey'=>$DetailPrimaryKey, 'DefaultFilter'=>$filter], $this->getDictionaries()));
    }


    // this is used just for one item show
    public function getItem(Request $request){

        //return $request;  // for debug
        $OrganizationId = session('organizationId');
        $ItemId = $request[$this->BObject()->MasterKeyField()];
        $PersonId = session('PersonId');


        $Permissions = app(CommonDictionariesController::class)->GetDeniedModulePermissions($PersonId, $this->ModuleCode);


        return view($this->views['master'], array_merge(['master' => $this->BObject()->getMaster($ItemId), 
                   'DeniedPermissions' => $Permissions], $this->getDictionaries()));
   


    }

    public function getitemsajax(Request $request){

        $PersonId = session('PersonId');
        $filter = $request->filter;
        $caption = $request->caption;

        if ($filter == "all")
            $filter = " 1 = 1";
       
        $filterkey = 'LAST_FILTER.'.get_class($this) ;
        session()->put($filterkey, $filter);

        $filterkey = 'LAST_FILTER_CAPTION.'.get_class($this) ;
        session()->put($filterkey, $caption);

        $others = ['PersonId' => $PersonId];

        $items = $this->BObject()->getMasterList($OrganizationId, $filter, $others);

        return  [ 'masterlist' => $items];
    }


    

    public function getitemajax(Request $request){
        $OrganizationId = session('organizationId');
        $ItemId = $request[$this->BObject()->MasterKeyField()];

        if ($this->views['detail'])
            return view($this->views['detail'], array_merge([
                'master' => $this->BObject()->getMaster($ItemId), 
                'dictionaries' => $this->getDictionaries(), 
                'other' => $this->getOtherDetail($ItemId, $request)]));
        else
            return  [$this->BObject()->getMaster($ItemId)] ;
        
    }

    public function saveitemajax(Request $request){



        $fields = $request->all();
        $fields['_PersonId_'] = session('PersonId');
        $fields['_OrganizationId_'] = session('organizationId');
        $fields['_LocationId_'] = session('LocationId');

        $Permissions = app(CommonDictionariesController::class)->GetDeniedModulePermissions(session('PersonId'), $this->ModuleCode);

        if (in_array( 'Edit', $Permissions))
            throw new \Exception('Beiiii bei');

        return [$this->BObject()->Save($fields)];
    }



    public function deleteitemajax(Request $request){
        $ItemId = $request[$this->BObject()->MasterKeyField()];
        $this->BObject()->deleteMaster($ItemId);
    }

    public function getdetaillistajax(Request $request){
        $ItemId = $request['MasterKeyField'];
        $OrganizationId = session('organizationId');
        $others = $this->BObject()->getMasterOthers($ItemId, $OrganizationId);
    
        return  [$this->BObject()->getDetails($ItemId, $OrganizationId), $others];

    }


}

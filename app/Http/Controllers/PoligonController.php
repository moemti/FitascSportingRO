<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\MasterController;
use App\Models\Dictionaries\Dictionary;





class PoligonController extends MasterController
{
    public $BObject = 'App\Models\Dictionaries\Poligon';

    public $views = ['master'=>'modules.pages.poligonedit'];


    public function getDictionaries(){
        $OrganizationId = session('organizationId');
 
        return [ 'countries' =>  Dictionary::getCountries(), 'persons' => Dictionary::getPersons($OrganizationId)];
    }

    public function getRangesAPI(){
        return $this->BObject()->getRangesAPI();
    }

    


}
<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\MasterController;
use App\Models\Dictionaries\Dictionary;





class CompetitieController extends MasterController
{
    public $BObject = 'App\Models\Competitions\Competitie';

    public $views = ['master'=>'modules.pages.competitieedit'];


    public function getDictionaries(){
        $OrganizationId = session('organizationId');
 
        return [ 'poligoane' =>  Dictionary::getRanges($OrganizationId), 'sportfields' =>  Dictionary::getSports($OrganizationId)];
    }


}
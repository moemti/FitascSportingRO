<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Models\Dictionaries\Dictionary;
use App\Models\Common\Permissions;



class CommonDictionariesController extends Controller{

	// == generale == 		

    private function getdictionaries($code, &$dictionaryid){

        $OrganizationId = session('organizationId');
        $dictionaryid = Dictionary::getDictionaryId($code);
        return Dictionary::getList( $OrganizationId, $dictionaryid);
       
    }


    public function getCurrencies(){
        return Dictionary::getCurrencies();
    }

    public function getDocumentSerials($DocumentCode){
        return Dictionary::getDocumentSerials($DocumentCode);
    }


    public function getEUType(){
        $DictioanryCode = 'EUType';
		
		$dictionaryid = 0;
		return $this->getdictionaries($DictioanryCode, $dictionaryid);

    }

    public function getVatCodes(){
        $DictioanryCode = 'VATCode';
		$dictionaryid = 0;
		return $this->getdictionaries($DictioanryCode, $dictionaryid);   
    }
	
    public function getDeliveryRep(){
        // todo sa punem rolul in functie
        $OrganizationId = session('organizationId');
        return Dictionary::getPersons($OrganizationId);
    }

    public function getSalesRep(){
        // todo sa punem rolul in functie
        $OrganizationId = session('organizationId');
        return Dictionary::getPersons($OrganizationId);
    }

    public function getArticles(){
        $OrganizationId = session('organizationId');
        return Dictionary::getArticles($OrganizationId);
    }

    public function getArticleCategories(){
        $OrganizationId = session('organizationId');
        return Dictionary::getArticleCategories($OrganizationId);

    }

    public function getModuleInitialFilter($modulecode){
        $OrganizationId = session('organizationId');
        $configcode = 'ALL_REG';
        $config = Dictionary::getModuleConfig($modulecode, $configcode, $OrganizationId, 1);
        if ($config == 1)
            return ['All', ' 1 = 1 '];
        else
            return ['None', ' 1 = 0 '];
    }

    public function GetDeniedModulePermissions($personId, $ModuleCode){
        return Permissions::GetDeniedModulePermissions($personId, $ModuleCode);

    }


}

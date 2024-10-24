<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Storage;
use App\Models\Dictionaries\BObject;
use App\Models\Competitions\Competition;
use App\Models\Common\Translate;


class TranslationController extends MasterListController
{
    public $BObject = 'App\Models\Common\Translation';

    public $MasterPrimayKeys = 'TranslationId';
    public $MasterFilter = '';
    public $view = 'modules.pages.translation';

    public function getTitle($Item){
        return transex('Traduceri');
    }

    public function addTranslationDB(Request $request){
        
        $base = $request->base;
   //     Storage::append('file.log', $base); // sa scoatem dupa test
        Translate::addTranslation($base, '');     
    }

    public function getTranslationDB(){
        return Translate::getTranslationDB();
    }

}
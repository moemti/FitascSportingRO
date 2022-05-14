<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;

use App\Models\Dictionaries\BObject;
use App\Models\Competitions\Competition;



class TranslationController extends MasterListController
{
    public $BObject = 'App\Models\Common\Translation';

    public $MasterPrimayKeys = 'TranslationId';
    public $MasterFilter = '';
    public $view = 'modules.pages.translation';

    public function getTitle($Item){
        return transex('Traduceri');
    }


}
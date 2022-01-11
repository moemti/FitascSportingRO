<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\MasterController;






class PersonController extends MasterController
{
    public $BObject = 'App\Models\Users\Person';

    public $views = ['master'=>'users/person'];


    public function getDictionaries(){
        $OrganizationId = session('organizationId');
        return ['roles' => $this->BObject()->getRoles($OrganizationId), 'params' => $this->BObject()->getParams('personxparam')];
    }

}
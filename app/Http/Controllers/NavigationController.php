<?php


namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Pages;


class NavigationController extends Controller
{

    function getdata($page){

        $result = [];
        switch ($page){
            case 'clasamente':
                
                $result['participanti'] = Pages::getParticipanti();
                break;
            case 'poligoane':
                $result['poligoane'] = Pages::getPoligoane();
                break;
            
      
        }



        return $result;
    }

    function getPage($page){

        if (view()->exists("modules.pages.$page")) {
            return view("modules.pages.$page", $this->getData($page));
        } else {
            return view("paginainconstructie", ['pagina' => $page]);
        }
    
    }

    function getPoligon($RangeId){
        $result = Pages::getPoligon($RangeId);

        return view("modules.pages.poligondetail", ['poligon' => $result[0]])->render();
    }
    
}


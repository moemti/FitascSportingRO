<?php

use App\Models\Competitions\Competition;
use App\Models\Dictionaries\Poligon;

    function getMenu(){
        return  [
        
           
                            ['welcome', 'Pagina principala'],
                            ['competitii', 'Competitii'],
                            ['clasamente', 'Clasamente'],
                            ['regulamente', 'Regulamente'],
                   
                            [      
                                    [   
                                            ['poligoane', 'Poligoane'],
                                            ['utile', 'Linkuri utile']
                    
                                    ], 'Utile'
                            ],
    
                            [
                                   Competition::getGaleries(), 'Galerii foto'
                    
                            ],
    
                            [
                                    [
                                            ['persoane', 'Persoane', 'IsSuperUser'],
                                            ['sezoane', 'Sezoane', 'IsSuperUser'],
                                            ['registeries', 'Cereri inregistrare', 'IsSuperUser'],
                                            ['translations', 'Traduceri', 'IsSuperUser'],
                                            ['poligoaneedit', 'Poligoane', hasRangesRight()], 
                                    ], 'Administrare', 'PersonId'
                            ]
             
                    
            ];      
    
    }

    function getCurrentCompetition(){
        return Competition::getCurrentCompetition();
    }

    function hasRangesRight(){

        $PersonId = session('PersonId');
        if(!$PersonId)
                 return '';

        if (Poligon::hasRangesRight($PersonId) || (session('IsSuperUser') == 1))
                return 'PERMITED';
        else    
                return '';
    }

    function getCompetitionRight($CompetitionId){
        if (session('IsSuperUser') == 1)
                return true;
        

        $PersonId = session('PersonId');
        if(!$PersonId)
                return false;

        return Poligon::hasCompetitionRight($PersonId, $CompetitionId); 
    }
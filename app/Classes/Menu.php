<?php

use App\Models\Competitions\Competition;

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
                                            ['persoane', 'Persoane'],
                                            ['sezoane', 'Sezoane'],
                                            ['registeries', 'Cereri inregistrare'],
                                            ['translations', 'Traduceri'],
                                    ], 'Administrare', 'super'
                            ]
             
                    
            ];      
    
    }

    function getCurrentCompetition(){
        return Competition::getCurrentCompetition();
    }
<?php

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'options'], function () {

        Route::get('/debug', function(){  return view('debug');});

        Route::get('/',  'App\Http\Controllers\CompetitiiController@returnWelcome')->name('welcome');

     

        Route::get('/welcome',  'App\Http\Controllers\CompetitiiController@returnWelcome')->name('welcome');


        Route::get('/competitii', 'App\Http\Controllers\CompetitiiController@getList');


        Route::get('/login', function(){  return view('auth/login');})->name('login');

        Route::post('/authenticate', 'App\Http\Controllers\Auth\LoginController@authenticate');
        Route::post('/registerme', 'App\Http\Controllers\Auth\LoginController@register');
        Route::post('/resetpassword', 'App\Http\Controllers\Auth\LoginController@resetpasswordmail');
        Route::get('/confirmregistration', 'App\Http\Controllers\Auth\LoginController@confirmregistrationemail');
        Route::get('/changepassword', 'App\Http\Controllers\Auth\LoginController@changepassword');
        Route::post('/changethepassword', 'App\Http\Controllers\Auth\LoginController@changethepassword');
        Route::post('/addtranslation', 'App\Http\Controllers\Controller@addTranslation');


        Route::get('/resetform', function (){
            return view('auth/reset');

        })->name('resetpassword');

        Route::get('/register', function (){
            return view('auth/register');

        })->name('register');

        Route::get('/termeni', function (){
            return view('modules/pages/termeni');

        })->name('termeni');

        Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');

// o sa-l punem in superuser

        Route::get('/registeries', 'App\Http\Controllers\Auth\LoginController@getregisteries')->name('registeries');
        Route::get('/registere/{id}', 'App\Http\Controllers\Auth\LoginController@getregistere');
        Route::post('registere/finishuser', 'App\Http\Controllers\Auth\LoginController@finishuser');


// permisiune de editare competitii
        Route::get('/editresult/{id}', 'App\Http\Controllers\CompetitiiController@editresult');


        Route::get('/editresultsall/{id}', 'App\Http\Controllers\ResultsControllerAll@getlist');
        Route::post('/saveresultsall', 'App\Http\Controllers\ResultsControllerAll@savelist');
        Route::post('/getresultallajax', 'App\Http\Controllers\ResultsControllerAll@getlistajax');

        Route::post('/getresultajax', 'App\Http\Controllers\CompetitiiController@getresultajax');

        Route::post('/changeCompetitionStatus', 'App\Http\Controllers\CompetitiiController@changeCompetitionStatus');
        Route::post('/doCompetitionSquads', 'App\Http\Controllers\CompetitiiController@doCompetitionSquads');
        Route::get('/ExportCompetitie/{id}', 'App\Http\Controllers\CompetitiiController@ExportCompetitie');
        Route::get('/competitionResultsDown/{id}', 'App\Http\Controllers\CompetitiiController@ExportClasamente');
        Route::post('/switchPersons', 'App\Http\Controllers\CompetitiiController@switchPersons');
        
        

        Route::post('/registerMe', 'App\Http\Controllers\CompetitiiController@registerMe');
        Route::post('/registerCompetitor', 'App\Http\Controllers\CompetitiiController@registerCompetitor');
        Route::post('/registerCompetitor/{PersonId}', 'App\Http\Controllers\CompetitiiController@registerCompetitor');
        Route::post('/registerCompetitorDB', 'App\Http\Controllers\CompetitiiController@registerCompetitorDB');

        Route::post('/getresultdetailsajax', 'App\Http\Controllers\CompetitiiController@getresultdetailsajax');
        Route::post('/saveresultdetail', 'App\Http\Controllers\ResultsController@saveitemajax');
        Route::post('/deleteresultajax', 'App\Http\Controllers\ResultsController@deleteitemajax');
    
        
        
        
        
        Route::get('/translations', 'App\Http\Controllers\TranslationController@getlist');
        Route::post('/gettranslationajax', 'App\Http\Controllers\TranslationController@getlistajax');
        Route::post('/savetranslation', 'App\Http\Controllers\TranslationController@savelist');
    

        Route::get('/gallery/{id}', 'App\Http\Controllers\CompetitiiController@getgallery');
        

        Route::get('/clasamente', 'App\Http\Controllers\ClasamenteController@getClasamente');
        Route::post('/getResultsPersonyYear', 'App\Http\Controllers\ClasamenteController@getResultsPersonyYear');
        Route::post('/getClasamentByYear', 'App\Http\Controllers\ClasamenteController@getClasamentByYear');
        
        
        //Route::POST('/competition', 'App\Http\Controllers\CompetitiiController@getItemAjax');
        Route::GET('/clasament/{id}', 'App\Http\Controllers\CompetitiiController@getClasament');
        Route::GET('/clasamentAPI/{id}', 'App\Http\Controllers\CompetitiiController@getClasamentAPI');

        Route::GET('/ClasamentYears', 'App\Http\Controllers\ClasamenteController@getClasamentYearsAPI');
        Route::GET('/ClasamentByYearAPI/{Year}', 'App\Http\Controllers\ClasamenteController@getClasamentByYearAPI');


        /************    API     *******/

        Route::GET('/CompetitionsAPI', 'App\Http\Controllers\CompetitiiController@getCompetitiiAPI');

        Route::GET('/rangesAPI', 'App\Http\Controllers\PoligonController@getRangesAPI');


        Route::get('/loginApi', 'App\Http\Controllers\Auth\LoginController@loginApi');
        Route::get('/loginApiToken', 'App\Http\Controllers\Auth\LoginController@loginApiToken');
        Route::get('/logoutApi', 'App\Http\Controllers\Auth\LoginController@logoutApi');

        Route::GET('/imregisteredAPI/{CompetitionId}/{PersonId}', 'App\Http\Controllers\CompetitiiController@imregisteredAPI');
        Route::GET('/registermeAPI/{CompetitionId}/{PersonId}', 'App\Http\Controllers\CompetitiiController@registermeAPI');
        Route::GET('/listaParticipantiAPI/{CompetitionId}', 'App\Http\Controllers\CompetitiiController@listaParticipantiAPI');
        Route::GET('/competitionTimetableAPI/{CompetitionId}/{Day}', 'App\Http\Controllers\CompetitiiController@competitionTimetableAPI');
        Route::GET('/MyCompetitionsAPI/{PersonId}', 'App\Http\Controllers\CompetitiiController@MyCompetitionsAPI');
        Route::GET('/MyPersonalInfo/{PersonId}', 'App\Http\Controllers\CompetitiiController@MyPersonalInfo');
       
        
        



        /******************/



        Route::GET('/clasamentdata/{id}', 'App\Http\Controllers\CompetitiiController@getClasamentdata');
        Route::GET('/competitionListDown/{id}', 'App\Http\Controllers\CompetitiiController@getClasamentList');
        Route::GET('/competitionDownSquads/{id}/{day}', 'App\Http\Controllers\CompetitiiController@getClasamentSquads');
        Route::GET('/competitionListDownSerii/{id}', 'App\Http\Controllers\CompetitiiController@getClasamentListSerii');
        Route::GET('/competitionTimetable/{id}/{day}', 'App\Http\Controllers\CompetitiiController@competitionTimetable');
        Route::POST('/generateTimetable', 'App\Http\Controllers\CompetitiiController@generateTimetable');

        
        
        Route::get('/competitionattachment/{id}', 'App\Http\Controllers\CompetitiiController@getCompetitionAttachment');
        Route::get('/competitionattachment/{id}/{filename}', 'App\Http\Controllers\CompetitiiController@getCompetitionAttachmentByName');

        Route::get('/competitieQRCode', 'App\Http\Controllers\CompetitiiController@getBarCode');

        
 //
        Route::get('/editattachments/{id}', 'App\Http\Controllers\CompetitiiController@geteditattach');
        Route::post('/attachDelete', 'App\Http\Controllers\CompetitiiController@deleteAttach');
        Route::post('/attachUpload', 'App\Http\Controllers\CompetitiiController@attachUpload');
        Route::post('/attachModify', 'App\Http\Controllers\CompetitiiController@attachModify');
        

        Route::get('/poligon/{id}', 'App\Http\Controllers\NavigationController@getPoligon');
       

        Route::middleware(['guest'])->group(function(){

            // my user
            Route::get('/myuser', 'App\Http\Controllers\PersonController@getmyuser')->name('myuser');
            Route::post('/savemyuser', 'App\Http\Controllers\PersonController@savemyuser');
            Route::post('/getmyuserajax', 'App\Http\Controllers\PersonController@getmyuserajax');
            Route::post('/changemypassword', 'App\Http\Controllers\PersonController@changemypassvord');

            // persoane
            Route::get('/persoane', 'App\Http\Controllers\PersonController@getList');

            Route::post('savepersonajax', 'App\Http\Controllers\PersonController@saveitemajax');
            Route::post('getpersonsajax', 'App\Http\Controllers\PersonController@getitemsajax');
            Route::post('getpersonajax', 'App\Http\Controllers\PersonController@getitemajax');
            Route::post('deletepersonajax', 'App\Http\Controllers\PersonController@deleteitemajax');
            Route::post('getpersondetaillistajax', 'App\Http\Controllers\PersonController@getdetaillistajax');
            Route::post('echivalarepersoana', 'App\Http\Controllers\PersonController@echivalarepersoana');

            // poligoane

            Route::get('poligoaneedit', 'App\Http\Controllers\PoligonController@getList');
            Route::post('savepoligonajax', 'App\Http\Controllers\PoligonController@saveitemajax');
            Route::post('getpoligonsajax', 'App\Http\Controllers\PoligonController@getitemsajax');
            Route::post('getpoligonajax', 'App\Http\Controllers\PoligonController@getitemajax');
            Route::post('deletepoligonajax', 'App\Http\Controllers\PoligonController@deleteitemajax');
            Route::post('getpoligondetaillistajax', 'App\Http\Controllers\PoligonController@getdetaillistajax');


            //
            Route::get('/editgallery/{id}', 'App\Http\Controllers\CompetitiiController@geteditgallery');
            Route::post('/galleryDelete', 'App\Http\Controllers\CompetitiiController@deleteGallery');
            Route::post('/galleryUpload', 'App\Http\Controllers\CompetitiiController@galleryUpload');
            
            
            // cluburi

            Route::get('clubedit', 'App\Http\Controllers\ClubController@getList');
            Route::post('saveclubajax', 'App\Http\Controllers\ClubController@saveitemajax');
            Route::post('getclubsajax', 'App\Http\Controllers\ClubController@getitemsajax');
            Route::post('getclubajax', 'App\Http\Controllers\ClubController@getitemajax');
            Route::post('deleteclubajax', 'App\Http\Controllers\ClubController@deleteitemajax');
            Route::post('echivalareclub', 'App\Http\Controllers\ClubController@echivalareclub');


            // competitie

            Route::get('competitieedit', 'App\Http\Controllers\CompetitieController@getList');
            Route::post('getcompetitiiajax', 'App\Http\Controllers\CompetitieController@getitemsajax');
            Route::post('getcompetitieajax', 'App\Http\Controllers\CompetitieController@getitemajax');
            Route::post('savecompetitieajax', 'App\Http\Controllers\CompetitieController@saveitemajax');




        });

        Route::get('{page}', 'App\Http\Controllers\NavigationController@getPage'); 

    });

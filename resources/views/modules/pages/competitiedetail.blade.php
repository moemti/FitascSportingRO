@extends('layouts.baseex')

@push('footerscripts')

<script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxcore.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxdata.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxbuttons.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxscrollbar.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxmenu.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxcheckbox.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxlistbox.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxdropdownlist.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.sort.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.pager.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.selection.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.edit.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.filter.js')}}"></script> 
   

    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxdata.export.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.export.js')}}"></script> 
	<script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxexport.js')}}"></script> 


	<!-- JSZip -->
    <script type="text/javascript" src="{{asset('js/components/scripts/jszip.min.js')}}"></script>

    <script defer type="module" src="{{asset('js/pages/competitie.js?v=12')}}"></script>

    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/competitii.css')}}"/>
    <link rel="stylesheet" href="{{asset('js/components/jqwidgets/styles/jqx.base.css')}}" type="text/css" />


<script>

        let dsClasament= @Json($clasament);
        let dsClasamentCat = @Json($clasamentcategorie);
        let dsClasamentTeam = @Json($clasamentteams);
        let dsClasamentSup = @Json($clasamentSup);
        let dsClasamentStr = @Json($clasamentStr);
        let HasCompetitionRight = '{{getCompetitionRight($master[0]->CompetitionId)}}'  == '1';

        let Status = '{{$master[0]->Status}}' ; 

</script>
@endpush

@push('sidebar_left')   
        
@endpush

@push('content')

<section class="content-termeni section section-tertiary section-no-border m-0">
    <div class="container">

    <div class="compet_status {{$master[0]->Status}}">
        <span >{{$master[0]->Status}}</span> 
    </div>

        <div class="page_content_header text-center pt-3">
             <input id="CompetitionId" value='{{$master[0]->CompetitionId}}' hidden> 
        <div class='row'>
            <div class="mb-12">
                <h2 id="p_competitie" value='' > {{$master[0]->Name}}</h2>
            </div>
        </div>
          <div class='row'>
            <div class="mb-12">
                <p id="p_sportfield" value='' > {{$master[0]->SportField}}</p>
            </div>
        </div>
        <div class='row'>
            <div>
                <h3 id="p_locatie" value=''> {{$master[0]->Range}}</h3>
            </div>
        </div>
        <div class='row'>
            <div class="d-flex">
               <strong> <p id="p_startdate" value=''> {{$master[0]->StartDate}}</p></strong>
               <div class="ms-2  me-2">   -   </div> 
                <strong>  <p id="p_enddate" value=''>{{$master[0]->EndDate}} </p> </strong> 
            </div>

            <div class='d-flex'>
                    @if ( file_exists('img/gallery/competitions/'.$master[0]->CompetitionId ))
                        <a href="{{url('/gallery/').'/'.$master[0]->CompetitionId}}" class = "btn-galerie btn btn-primary btn-outline mb-2" >{{transex('Vezi galerie')}}</a>
                    @endif

                    @if (getCompetitionRight($master[0]->CompetitionId))
                        <a href="{{url('/editgallery/').'/'.$master[0]->CompetitionId}}" class = " btn btn-danger btn-outline ms-2 mb-2" >{{transex('Editeaza galerie')}}</a>
                    @endif

                    @php
                        $attachments = getCompetitionAttachments($master[0]->CompetitionId);
                    @endphp  

                    @foreach($attachments as $att)
                            <a class="text-2  text-color-light btn "  href="{{url('/competitionattachment/'.$att->CompetitionattachId)}}" target="_blank" title="{{transex($att->Name)}}">

                            <p style ="color: blue !important;
                                    text-shadow: rgb(256, 256, 256) -1px 1px !important;
                                    background: rgba(256,256,256,0.4); 
                                    border-radius: 8px;
                                    padding-left: 5px;
                                    padding-right: 5px;
                                    "> {{transex($att->Name)}}</p>
                            </a>
                    @endforeach

                     @if (getCompetitionRight($master[0]->CompetitionId))
                        <a href="{{url('/editattachments/').'/'.$master[0]->CompetitionId}}" class = " btn btn-danger btn-outline ms-2 mb-2" >{{transex('Editeaza atasamente')}}</a>

                        <a id="btnDownloadListaAll" href="{{url('/competitionListDown/').'/'.$master[0]->CompetitionId}}"  class=" btn btn-secondary btn-outline ms-2 mb-2">Download lista</a>
                    @endif
            </div>
                <div class="btnwrapper m-2">
                    @switch($master[0]->Status)
                        @case('Closed')
                            @if (getCompetitionRight($master[0]->CompetitionId))
                            <button id="btnOpen" data-status="Open" class = "cmpStatusChange btn btn-primary btn-outline mb-2" >{{transex('Deschide')}}</button>
                            @endif
                            @break
                     @case('Open')

                        @if (session("PersonId"))
                            @php 
                                $exists = false;
                                $cl =  $clasament;
                                if ($cl)
                                foreach( $cl as $person) {
                                    if ($person->PersonId === session("PersonId")){
                                        $exists = true;
                                        break;
                                    }
                                }
                            @endphp    
                            @if ($exists)
                                <button id="btnUnRegister" class = "btn-register btn btn-danger btn-outline mb-2" >{{transex('Nu mai particip')}}</button>
                            @else
                                 <button id="btnRegister" class = "btn-register btn btn-primary btn-outline mb-2" >{{transex('Ma inscriu')}}</button>
                            @endif
                          
                    

                            @if (getCompetitionRight($master[0]->CompetitionId))
                             <button id="btnOngoing"  data-status="Preparation" class="cmpStatusChange btn btn-secondary btn-outline mb-2">Start preperation</button>
                              <button id="btnOngoing"  data-status="Closed" class="cmpStatusChange btn btn-secondary btn-outline mb-2">Close competition</button>
                            @endif
                        @endif
                         @if (session("IsSuperUser") == 1)
                                <button id="btnEditSerii"  data-type="EditSerii" class="editSerii btn btn-secondary btn-outline mb-2">Editeaza serii</button>
                            @endIf
                        @break
                    @case('Preparation')

                        @if (getCompetitionRight($master[0]->CompetitionId))
                            <button id="btnClose"  data-status="Closed" class="cmpStatusChange btn btn-secondary btn-outline mb-2">{{transex('Close')}}</button>
                            <button id="btnOpen" data-status="Open" class = "cmpStatusChange btn btn-secondary btn-outline mb-2" >Open</button>
                            <button id="btnOngoing"  data-status="Progress" class="cmpStatusChange btn btn-secondary btn-outline mb-2">Start competition</button>

                            @if (session("IsSuperUser") == 1)
                                <button id="btnEditSerii"  data-type="EditSerii" class="editSerii btn btn-secondary btn-outline mb-2">Editeaza serii</button>
                            @endIf

                            <button id="btnCreateSquadsAll"  data-type="All" class="createSquads btn btn-secondary btn-outline mb-2">Create squads all</button>
                            <button id="btnCreateSquadsDiff"  data-type="Diff" class="createSquads btn btn-secondary btn-outline mb-2">Create squads diff</button>
                            <button id="btnCreateSquadsEven"  data-type="Even" class="createSquads btn btn-secondary btn-outline mb-2">Create squads even</button>
                            <button id="btnDeleteSquads"  data-type="Clear" class="createSquads btn btn-secondary btn-outline mb-2">Clear squads</button>
                            <button id="btnGenTimetable"   class = "btn btn-secondary btn-outline mb-2">Genereaza program</button>
                            <button id="btnSeeTimetable"  class = " btn btn-secondary btn-outline mb-2">Editeaza program</button>

                            <a id="btnDownloadListaAll" href="{{url('/competitionListDown/').'/'.$master[0]->CompetitionId}}" data-type="Diff" class=" btn btn-secondary btn-outline mb-2">Download lista</a>
                            <div class="row"> 
                                <div class="btnwrapper m-2">
                                    <b>{{transex('Download fise')}}</b>
                                    <a id="btnDownloadListaSquad1" href="{{url('/competitionDownSquads/').'/'.$master[0]->CompetitionId}}/1" data-type="Diff" class=" btn btn-secondary btn-outline mb-2">{{transex('Ziua 1')}}</a>
                                    <a id="btnDownloadListaSquad2" href="{{url('/competitionDownSquads/').'/'.$master[0]->CompetitionId}}/2" data-type="Diff" class=" btn btn-secondary btn-outline mb-2">{{transex('Ziua 2')}}</a>
                                </div>
                            </div>
                            <a id="btnDownloadListaAll" href="{{url('/competitionListDownSerii/').'/'.$master[0]->CompetitionId}}" data-type="Diff" class=" btn btn-secondary btn-outline mb-2">{{transex('Download serii')}}</a>
                            <a id="btnDownloadListaAll" href="{{url('/competitionListVeziSerii/').'/'.$master[0]->CompetitionId}}" data-type="Diff" class=" btn btn-secondary btn-outline mb-2">{{transex('Vezi serii')}}</a>
                            
                        @endif
                        @break
                        
                    @case('Progress')     
                         @if (getCompetitionRight($master[0]->CompetitionId))
                            <button id="btnOngoing"  data-status="Preparation" class="cmpStatusChange btn btn-secondary btn-outline mb-2">Open to preparation</button>
                            <button id="btnFinish"  data-status="Finished" class="cmpStatusChange btn btn-secondary btn-outline mb-2">Finish competition</button>
                            <button id="btnGenTimetable"   class = "btn btn-secondary btn-outline mb-2">Genereaza program</button>
                            <button id="btnSeeTimetable"  class = " btn btn-secondary btn-outline mb-2">Editeaza program</button>
                            <a id="btnDownloadListaSquad1" href="{{url('/competitionDownSquads/').'/'.$master[0]->CompetitionId}}/1" data-type="Diff" class=" btn btn-secondary btn-outline mb-2">Ziua 1</a>
                            <a id="btnDownloadListaSquad2" href="{{url('/competitionDownSquads/').'/'.$master[0]->CompetitionId}}/2" data-type="Diff" class=" btn btn-secondary btn-outline mb-2">Ziua 2</a>
                            <a id="btnDownloadListaAll" href="{{url('/competitionListDown/').'/'.$master[0]->CompetitionId}}" data-type="Diff" class=" btn btn-secondary btn-outline mb-2">Download lista</a>
                            <a id="btnAddResults"  href="{{url('/editresultsall/').'/'.$master[0]->CompetitionId}}" data-status="Finished" class=" btn btn-secondary btn-outline mb-2">Adauga rezultate</a>
                            <button id="btnSeeTimetable"  class = " btn btn-secondary btn-outline mb-2">Editeaza program</button>
                        @endif
                            <a id="btnDownloadListaAll" href="{{url('/competitionListDownSerii/').'/'.$master[0]->CompetitionId}}" data-type="Diff" class=" btn btn-secondary btn-outline mb-2">{{transex('Download serii')}}</a>
                            <a id="btnDownloadListaAll" href="{{url('/competitionListVeziSerii/').'/'.$master[0]->CompetitionId}}" data-type="Diff" class=" btn btn-secondary btn-outline mb-2">{{transex('Vezi serii')}}</a>
                            <button id="btnVeziProgram"  class="btnVeziProgram btn btn-secondary btn-outline mb-2">Vezi program</button>
                            <a id="btnDownloadProgram" href="{{url('/competitionTimetable/').'/'.$master[0]->CompetitionId}}/1"  class=" btn btn-secondary btn-outline mb-2">{{transex('Download program ziua 1')}}</a>
                            <a id="btnDownloadProgram" href="{{url('/competitionTimetable/').'/'.$master[0]->CompetitionId}}/2"  class=" btn btn-secondary btn-outline mb-2">{{transex('Download program ziua 2')}}</a>
                        @break

                        @if (session("IsSuperUser") == 1)
                                <button id="btnEditSerii"  data-type="EditSerii" class="editSerii btn btn-secondary btn-outline mb-2">Editeaza serii</button>
                            @endIf

                    @case('Finished')
                      
                        @if (getCompetitionRight($master[0]->CompetitionId))
                            <button id="btnOngoingR"  data-status="Progress" class="cmpStatusChange btn btn-secondary btn-outline mb-2">Reopen competition</button>

                        @endif
                        
                        <a id="btnDownloadResultsAll" href="{{url('/competitionResultsDown/').'/'.$master[0]->CompetitionId}}" data-type="Diff" class=" btn btn-danger btn-outline mb-2">{{transex('Download clasamente')}}</a>
                        @break

                @endswitch

                    
          
                </div>


            
        </div>

      



    </div>
                                
       @if ($master[0]->Status == 'Finished')
       <h6>{{transex('Clasamente categorii')}}</h6>
        <div id ="jqxGridCat" class="gridnou">
                    
        </div> 

        <h6>{{transex('Clasamente pe echipe')}}</h6>
        <div id ="jqxGridTeam" class="gridnou">
                    
        </div> 

         <h6>{{transex('Puncte Supercupa')}}</h6>
        <div id ="jqxGridSup" class="gridnou">
                    
        </div> 

         <h6>{{transex('Clasament straini')}}</h6>
            <div id ="jqxGridStr" class="gridnou">
                        
            </div>

       @endif
       <div class="d-flex text-left">
            @switch($master[0]->Status)
                @case('Finished')
                @case('Progress')
                    <h4>{{transex('Clasament open')}}</h4>
                    @break
                @case('Open')
                    <h4>{{transex('Inscrisi')}}</h4>
                    @break
                @default
            @endswitch
        </div>

 <div class='row'>
        <div class="d-flex text-right">

            @if ((getCompetitionRight($master[0]->CompetitionId)) && (in_array(  $master[0]->Status,  array("Open","Preparation", "Progress"))  ))

               
                    <button id="addCompetitor" class = "btn-add btn btn-sm btn-danger" >Adauga sportiv</button>
               
            @endif
        </div>

   <div class="d-flex text-right">
            <button id="exportexcel" class = "btn-secondary">Export fisier Excel</button>
             </div>
 </div>

            <!-- <button id="exportpdf">PDF</button> -->

            <div id ="jqxGrid" class="gridnou">
                    
            </div>
        

    </div>
    
 </section>


@endpush
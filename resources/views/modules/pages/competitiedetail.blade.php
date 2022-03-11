@extends('layouts.base')

@push('scripts')

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

    <script defer type="module" src="{{asset('js/pages/competitie.js')}}"></script>

    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/competitii.css')}}"/>
    <link rel="stylesheet" href="{{asset('js/components/jqwidgets/styles/jqx.base.css')}}" type="text/css" />


<script>

        let dsClasament= @Json($clasament);

        let Status = '{{$master[0]->Status}}' ; 

</script>
@endpush

@push('sidebar_left')   
        
@endpush

@push('content')


    <div class="page_content page_content_master page_content_competitii">
        
        <div class="page_content_header">
         

         <input id="CompetitionId" value='{{$master[0]->CompetitionId}}' hidden> </input>
        <div class='row'>


            <div>
                <input id="input_competitie" value='{{$master[0]->Name}}' disabled> </input>
                <input id="input_sportfield" value='{{$master[0]->SportField}}'disabled> </input>
            </div>
        </div>


            
        <div class='row'>
        
            <div>
                <input id="input_locatie" value='{{$master[0]->Range}}'disabled> </input>
            </div>
        </div>
      

        <div class='row'>

            <div>
                <input id="input_startdate" value='{{$master[0]->StartDate}}'disabled> </input>
                <input id="input_enddate" value='{{$master[0]->EndDate}}'disabled> </input>
                <span class="compet_status {{$master[0]->Status}}">{{$master[0]->Status}}</span> 
                <div class="btnwrapper">
                @switch($master[0]->Status)
                    @case('Closed')
                       
                        @if (session("IsSuperUser") == 1)
                        <button id="btnOpen" data-status="Open" class = "cmpStatusChange btn btn-sm" >Open</button>
                        @endif
                        @break
                    @case('Open')


                  

                        @if (session("PersonId"))
                       
                            @php 

                                $exists = false;

                                $cl =  $clasament;
                                foreach( $cl as $person) {
                                    if ($person->PersonId === session("PersonId")){
                                        $exists = true;
                                        break;

                                    }
                                }


                            @endphp    
                            @if ($exists)
                                <button id="btnUnRegister" class = "btn-register btn btn-sm" >Nu mai particip</button>
                            @else
                                 <button id="btnRegister" class = "btn-register btn btn-sm" >Ma inscriu</button>
                            @endif

                        @endif

                        @if (session("IsSuperUser") == 1)
                            <button id="btnClose"  data-status="Closed" class="cmpStatusChange btn-add btn btn-sm">Close</button>
                            <button id="btnOngoing"  data-status="Progress" class="cmpStatusChange btn-add btn btn-sm">Start competition</button>
                        @endif
                        @break

                    @case('Progress')     
                         @if (session("IsSuperUser") == 1)
                            <button id="btnOpen" data-status="Open" class = "cmpStatusChange btn btn-sm" >Open</button>
                            <button id="btnFinish"  data-status="Finished" class="cmpStatusChange btn-add btn btn-sm">Finish competition</button>
                        @endif

                        @break


                    @case('Finished')
                      
                        @if (session("IsSuperUser") == 1)
                            <button id="btnOngoingR"  data-status="Progress" class="cmpStatusChange btn-add btn btn-sm">Reopen competition</button>
                        @endif
                        @break

                @endswitch
          
                </div>


            </div>
        </div>

        @switch($master[0]->Status)
            @case('Finished')
               
            @case('Progress')
                <h2>Clasament</h2>
                @break
        
            @case('Open')
                <h2>Inscrisi</h2>
                @break
        
            @default
                
        @endswitch





    </div>
        
        <div class="page_content_content">

            @if ((session('IsSuperUser') == 1) && (in_array(  $master[0]->Status,  array("Open","Progress"))  ))

                <div class='row'>
                    <button id="addCompetitor" class = "btn-add btn btn-sm" >Adauga</button>
                </div>

            @endif
            <div id ="jqxGrid" class="gridnou">
                    
            </div>
        </div>

    </div>
    


@endpush
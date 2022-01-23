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

    <script defer type="module" src="{{asset('js/pages/competitii.js')}}"></script>

    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/competitii.css')}}"/>
    <link rel="stylesheet" href="{{asset('js/components/jqwidgets/styles/jqx.base.css')}}" type="text/css" />
@endpush

<script>

        let dsCompetitii= @Json($masterlist);
           

</script>

@push('content')

    <div class="page_content page_content_master page_content_competitii">
        <div class="page_content_header">
            <h1>Competitii</h1>

            <h2>Competitii din Romania 2022 - 2021</h2>
        </div>

        <div class="page_content_content">

            <div id ="jqxGrid" class="gridnou">
                    
            </div>
        </div>

    </div>

  


@endpush
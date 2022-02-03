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
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxcombobox.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.sort.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.pager.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.selection.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.edit.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.filter.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/form-components/form-validation.min.js')}}"></script> 


    <link rel="stylesheet" href="{{asset('js/components/jqwidgets/styles/jqx.base.css')}}" type="text/css" />




    <script type="text/javascript" src={{asset('js/frame/master.js')}}></script>
      
      
      @stack('masterscripts')

       
          
      <script>

         

          var MasterFields = [];
          var DefaultMasterValues = [];
          var DefaultDetailValues = [];

          @isset($data)
            let data = @JSON($data)
          @endisset

          @isset($master)
              var data =  @JSON($master);
          @endisset

          @isset($MasterFields)
              var MasterFields = @JSON($MasterFields);
          @endisset
         
          @isset($DefaultMasterValues)
              var DefaultMasterValues = @JSON($DefaultMasterValues);
          @endisset
          
          @isset($DefaultDetailValues)
              var DefaultDetailValues = @JSON($DefaultDetailValues);
          @endisset

          @isset($MasterPrimaryKey)
              var MasterPrimaryKey = @JSON($MasterPrimaryKey);
          @endisset

          @isset($DetailPrimaryKey)
              var DetailPrimaryKey = @JSON($DetailPrimaryKey);
          @endisset

          @isset($DefaultFilter)
              LastFilter = @JSON($DefaultFilter)[1];
          @endisset

      </script>
@endpush

@push('content')

    <div class="page_content page_content_master">

        <div class="page_content_header">
            <h1>@stack('title')</h1>
    
            <h2>@stack('subtitle')</h2>

        </div>

        
        <div class="page_content_content">
                @stack('content_before')

                <form id="detailform" method="POST">
                    @csrf

                    @stack('formcontent')
                    
                    <div class="  text-right u-margin-top-medium">
                        <button type="submit" class="btn-wide btn-pill btn-shadow btn-hover-shine btn btn-primary btn-lg">Salveaza</button>
               
                    </div>


                </form>
                @stack('content_after')

        </div>

    </div>
    


@endpush
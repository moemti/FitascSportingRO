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


    <script>

            let persons = @Json($persons);
            

    </script>


    <script  src="{{asset('js/pages/registere.js')}}"></script>




@endpush

@push('content')

    <div class="page_content page_content_master ">
        <h1>Utilizator de inregistrat</h1>

        <form class="" action="finishuser" method="POST">
            @csrf
        <div class='row'>
                
                <input Name = "RegisterId" id="RegisterId" value='{{$register->RegisterId}}' hidden> </input>

                <div>
                    <input Name = "Name" id="Name" class="input-w100" value='{{$register->Name}}' > </input>
                   
                </div>
           
                <div>
                  
                    <input Name = "Email" id="Email" class="input-w100" value='{{$register->Email}}' > </input>
                </div>
            </div>

            <div class='row u-margin-top-medium'>
     
                <select Name='PersonId' id='PersonId'>
                    <option value = "-1">Persoana noua</option>
                        @foreach ($persons as $person)
                            <option value = "{{$person->PersonId}}">{{ $person->Name}}</option>
                        @endforeach


                </select>
            </div>

            <div class="  text-right u-margin-top-medium">
                     <button class="btn-wide btn-pill btn-shadow btn-hover-shine btn btn-primary btn-lg">Registreaza</button>
               
            </div>


         

            @if ((isset($mesaj) &&  $mesaj != '') or (session()->has('message')))
                    <div class="col-md-12">
                    <span class="text-danger">
                        <strong>{{ $mesaj.session()->has('message') }} </strong>
                    </span>
                    </div>
                @endif
        </form>


        <a href="{{Route('registeries')}}" target="_blank" class="a a__medium">De inregistrat</a>   


    </div>
    
       

@endpush
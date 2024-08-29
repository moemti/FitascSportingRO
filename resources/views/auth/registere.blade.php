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
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxcombobox.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.sort.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.pager.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.selection.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.edit.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/components/jqwidgets/jqxgrid.filter.js')}}"></script> 
    <script type="text/javascript" src="{{asset('js/form-components/form-validation.min.js')}}"></script> 
     {{-- <script type="text/javascript" src="{{asset('js/pages/registere.js')}}"></script>  --}}
    <script>
            let persons = @Json($persons);
    </script>
    

@endpush

@push('content')
<section class="content-termeni section section-tertiary section-no-border m-0">
    <div class="container">
        <h1>Persoana de inregistrat</h1>

        <div class="card mb-4">
            <div class="card-body">

                <form id = "registerform" class="" action="" method="POST">
                    @csrf
                    <div class='row'>
                        
                        <input Name = "RegisterId" id="RegisterId" value='{{$register->RegisterId}}' hidden>

                        <div class="form-group col-lg-12 col">
                       
                            <input  Name = "Name" id="Name"  type="text" value='{{$register->Name}}' data-msg-required="" maxlength="100" class="form-control text-3 h-auto py-2" name="name" >
                        </div>
                    </div>

                    <div class='row'>
                        <div class="form-group col-lg-12">
                            <input   Name = "Email" id="Email"  type="text"  value='{{$register->Email}}' data-msg-required="" maxlength="100" class="form-control text-3 h-auto py-2" name="name" >
                        </div>
                    </div>
                    <div class='row'>
                        <div class="form-group col-lg-6">
                            <select Name='PersonId' id='PersonId' class="form-select form-control h-auto py-2">
                                <option value = "-1">Persoana noua</option>
                                    @foreach ($persons as $person)
                                        <option value = "{{$person->PersonId}}">{{ $person->Name}}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>

                    <div class='row'>
                        <div class="form-group col-lg-12">
                            <input   Name = "Team" id="Team"  type="text"  value='{{$register->UserName}}' data-msg-required="" maxlength="100" class="form-control text-3 h-auto py-2" name="name" >
                        </div>
                    </div>
                    <div class='row'>
                        <div class="form-group col-lg-6">
                
                            <select Name='TeamId' id='TeamId' class="form-select form-control h-auto py-2">
                                <option value = "-1">Club nou</option>
                                    @foreach ($teams as $team)
                                        <option value = "{{$team->TeamId}}">{{ $team->Name}}</option>
                                    @endforeach


                            </select>
                        </div>
                    </div>

                     <div class="  text-left u-margin-top-medium">
                            <button type="submit" formaction="deletecerere" id = "sterge" class="btn-wide btn-pill btn-shadow btn-hover-shine btn btn-danger btn-lg">Sterge cererea</button>
                    </div>

                    <div class="  text-right u-margin-top-medium">
                            <button type="submit" formaction="finishuser" id = "aproba" class="btn-wide btn-pill btn-shadow btn-hover-shine btn btn-primary btn-lg">Registreaza</button>
                    </div>
                   





                    @if ((isset($mesaj) &&  $mesaj != '') or (session()->has('message')))
                            <div class="col-md-12">
                                <span class="text-danger">
                                    <strong>{{ $mesaj.session()->has('message') }} </strong>
                                </span>
                            </div>
                        @endif
                </form>
            </div>
        </div>

        
     

        <a href="{{Route('registeries')}}" target="_blank" class="a a__medium">De inregistrat</a>   

    </div>
    
</section>       

@endpush


@extends('frame.master')

@push('title')
    {{$data[0]->Name}}
@endpush

@push('subtitle')

    {{transex('Modificare utilizator')}}
    
@endpush


@push('masterscripts')
    <script type="text/javascript" src="{{asset('js/pages/myuser.js')}}"></script>
@endpush


@push('formcontent')


  
<div class="container">
    <div class="row">
        
        <input name="PersonId" id="PersonId" hidden>


        <div class= "position-relative form-group col-12 col-md-6">
            <label class= "form-label">Email</label>
            <input name="Email" id="Email" placeholder="{{transex('Email here')}}..." type="email" class="form-control " required>
        </div>


        <div class= "position-relative form-group col-12 col-md-6">
            <label class= "form-label">Nume intreg</label>
            <input name="Name" id="Name" placeholder="{{transex('Name here')}}..." type="text" class="form-control " required>
        </div>
    </div>

    <div class="row">  
    <div class="col-12 col-md-6">
            <div class="position-relative form-group  ">
                
                <label class= "" for="CountryId">{{transex('Tara')}}</label>
                
                <select name="CountryId" id="CountryId"  type="text" class="form-control" required >
                <option value=""></option>
                    @foreach($countries as $r)
                        <option value="{{$r->CountryId}}">{{$r->Name}}</option>
                    @endforeach
                </select>
            
                
            </div>
        </div>
    </div>

    
    <div class="row">  

        <div class="position-relative form-group col-12 col-md-6">
            <label class= "form-label">{{transex('Nume')}}</label>
            <input name="NickName" id="NickName" class="form-control real_input" >
        </div>

        <div class="position-relative form-group  col-12 col-md-6">
            
                <label class= "form-label" for="TeamId">{{transex('Team 2022')}}</label>
                
                <select name="TeamId" id="TeamId"  type="text" class="form-control"  >
                <option value=""></option>
                    @foreach($teams as $r)
                        <option value="{{$r->TeamId}}">{{$r->Name}}</option>
                    @endforeach
                </select>
            
                
        </div>

    </div>

    <!-- <div class="row">    
        <div class="position-relative form-group col-12 col-md-6">
            <label class= "form-label">Roluri</label>
            <input name="Role" id="Role" class="form-control real_input" disabled>
        </div>


    </div> -->

    <div class="row">
        <div class="position-relative form-group col-12 col-md-6">
            <label class= "form-label">{{transex('Serie si Nr CI')}}</label>
            <input name="SerieNrCI" id="SerieNrCI" class="form-control" >
        </div>
        <div class="position-relative form-group col-12 col-md-6">
            <label class= "form-label">{{transex('CNP')}}</label>
            <input name="CNP" id="CNP" class="form-control" >
        </div>
    </div >

     <div class="row">
            <div class="position-relative form-group col-12 col-md-6">
                <label class= "form-label">{{transex('Serie permis arma')}}</label>
                <input name="SeriePermisArma" id="SeriePermisArma" class="form-control" >
            </div>
            <div class="position-relative form-group col-12 col-md-6">
                <label class= "form-label">{{transex('Data expirare permis arma')}}</label>
                <input type = "date" name="DataExpPermis" id="DataExpPermis" class="form-control" >
            </div>
    </div>
        
    <div class="row">
            <div class="position-relative form-group col-12 col-md-6">
                <label class= "form-label"> {{transex('Marca arma')}} </label>
                <input name="MarcaArma" id="MarcaArma" class="form-control" >
            </div>
            <div class="position-relative form-group col-12 col-md-4">
                <label class= "form-label">{{transex('Serie arma')}}</label>
                <input name="SerieArma" id="SerieArma" class="form-control" >
            </div>
            <div class="position-relative form-group col-12 col-md-2">
                <label class= "form-label">{{transex('Calibru arma')}}</label>
                <input name="CalibruArma" id="CalibruArma" class="form-control" >
            </div>
    </div>

    



</div>
@endpush

@push('content_after')
    <form id="changemypassword" action="" class="passwordchange mt-3">
        <div class="container">
            <div class="row">
        
                <div class="col-md-12">
                    <div class="position-relative form-group  col-12 col-md-4"><input name="password" id="Password" placeholder="{{transex('Password here')}}..." type="password" class="form-control real_input" required></div>
                </div>
                <div class="col-md-12">
                    <div class="position-relative form-group  col-12 col-md-4"><input name="password2" id="Password2" placeholder="{{transex('Repeat Password here')}}..." type="password" class="form-control real_input" required></div>
                </div>

            </div>
        </div>
        <div class="text-left ">
            <button type="submit" class="btn-wide btn-pill btn-shadow btn-hover-shine btn btn-primary btn-lg">{{transex('Modifica parola')}}</button>
    
        </div>

    </form>

@endpush
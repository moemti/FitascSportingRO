@extends('frame.masterdetail')

@section('masterdetail')


    <script type="text/javascript" src="{{asset('js/pages/persoane.js')}}"> </script> 

  
    <script>
        let seasons = @JSON($seasons);     
        let shootercategories = @JSON($shootercategories);    
        let teams = @JSON($teams);    
        let roles = @JSON($roles);  
        let countries = @JSON($countries);
    </script>                   

@endsection




@push('detail')
    <input id="PersonId" name= "PersonId" hidden>
    <div class="form-row">
        <div class="col-md-12">
            <div class="position-relative form-group"><label for="name">Name</label><input name="Name" id="Name" type="text" class="form-control" required></div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="position-relative form-group"><label for="NicName">NickName</label><input name="NickName" id="NickName" class="form-control" ></div>
        </div>

        <div class="col-md-2">
            <div class="position-relative form-group"><label for="Code">Code</label><input name="Code" id="Code" class="form-control" ></div>
        </div>

        <div class="col-12 col-md-6">
            <div class="position-relative form-group  ">
                
                <label class= "" for="CountryId">Tara</label>
                
                <select name="CountryId" id="CountryId"  type="text" class="form-control" required >
                <option value=""></option>
                    @foreach($countries as $r)
                        <option value="{{$r->CountryId}}">{{$r->Name}}</option>
                    @endforeach
                </select>
            
                
            </div>
        </div>
        
        
        <div class="col-md-6">
          
            <div class="position-relative form-group"><label for="Email">Email</label><input name="Email" id="Email"  type="text" class="form-control" ></div>
        </div>

        
    </div>


    <div class="row">
        <div class="position-relative form-group col-12 col-md-6">
            <label class= "form-label">Serie si Nr CI</label>
            <input name="SerieNrCI" id="SerieNrCI" class="form-control" >
        </div>
        <div class="position-relative form-group col-12 col-md-6">
            <label class= "form-label">CNP</label>
            <input name="CNP" id="CNP" class="form-control" >
        </div>
    </div >

     <div class="row">
            <div class="position-relative form-group col-12 col-md-6">
                <label class= "form-label">Serie permis arma</label>
                <input name="SeriePermisArma" id="SeriePermisArma" class="form-control" >
            </div>
            <div class="position-relative form-group col-12 col-md-6">
                <label class= "form-label">Data expirare permis arma</label>
                <input type = "date" name="DataExpPermis" id="DataExpPermis" class="form-control" >
            </div>
    </div>
        
    <div class="row">
            <div class="position-relative form-group col-12 col-md-6">
                <label class= "form-label">Marca arma</label>
                <input name="MarcaArma" id="MarcaArma" class="form-control" >
            </div>
            <div class="position-relative form-group col-12 col-md-4">
                <label class= "form-label">Serie arma</label>
                <input name="SerieArma" id="SerieArma" class="form-control" >
            </div>
            <div class="position-relative form-group col-12 col-md-2">
                <label class= "form-label">Calibru arma</label>
                <input name="CalibruArma" id="CalibruArma" class="form-control" >
            </div>
    </div>

    <div class="form-row">
        <div class="col-md-2">
             <label for="HasUser">Are user</label><input name="HasUser" id="HasUser"  type="checkbox"  class="form-check-input" >
        </div>
        <div class="col-md-2">
            <label for="IsSuperUser">Este super user</label><input name="IsSuperUser" id="IsSuperUser"  type="checkbox" class="form-check-input" >
        </div>

        
    </div>



@endpush

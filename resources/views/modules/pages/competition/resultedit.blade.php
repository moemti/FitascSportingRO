@extends('frame.masterdetailOne')





@section('masterdetail')

    <script  type="text/javascript" src="{{asset('js/pages/competitie/resultedit.js')}}"></script>

   
@endsection


@push('DetailButtons')
        <a href="{{url('/clasament/').'/'.$CompetitionId}}" class="btn-wide btn btn-primary editable">Competitie</a>            
        <button id='btnDelete' class="btn-wide btn btn-danger editable">Delete</button>
@endpush


@push('detail')
    <input id="ResultId" name= "ResultId" hidden>
    <input id="CompetitionId" name= "CompetitionId" value= "{{$CompetitionId}}"hidden>
    <input id="PersonId" name= "PersonId" hidden>


    <div class="form-row row align-items-end">
        <div class="col-2 col-md-2">
            <div class="position-relative form-group"><label for="BIB">BIB</label>
                <input name="BIB" id="BIB" type="text" class="form-control" >     
            </div>
        </div>
        <div class="col-2 col-md-2">
            <div class="position-relative form-group">
                <label for="NrSerie">Serie</label>
                <input name="NrSerie" id="NrSerie" type="text" class="form-control" >
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12">
            <div class="position-relative form-group"><label for="name">Name</label><input name="Name" id="Name" type="text" class="form-control" disabled></div>
        </div>

    </div>

    <div class="form-row row align-items-end">

        <div class="col-2 col-md-3">
            <div class="position-relative form-group"><label for="ShooterCategoryId">Category</label>
            
                <select name="ShooterCategoryId" id="ShooterCategoryId"  type="text" class="form-control"  >
                <option value=""></option>
                    @foreach($categories as $r)
                        <option value="{{$r->ShooterCategoryId}}">{{$r->Name}}</option>
                    @endforeach
                </select>
        
            </div>
        </div>

        <div class="col-2 col-md-3">
            <div class="position-relative form-group"><label for="TeamId">Team</label>
            
                <select name="TeamId" id="TeamId"  type="text" class="form-control"  >
                <option value=""></option>
                    @foreach($teams as $r)
                        <option value="{{$r->TeamId}}">{{$r->Name}}</option>
                    @endforeach
                </select>
        
            </div>
        </div>

        <div class="col-2 col-md-2">
            <div class="position-relative form-group">
                <label for="TeamName">Este in echipa:</label>
                <input name="TeamName" id="TeamName"  class="form-control" >
             </div>
        </div>
    </div>
    
    <div class="form-row row align-items-end">
   
        <div class="col-2 col-md-2">
            <div class="position-relative form-group">
                <label for="Aborted">Renuntat</label>
                <input name="Aborted" id="Aborted"  type="checkbox"  class="form-check-input" >
             </div>
        </div>

    </div>

    <hr>
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


@endpush

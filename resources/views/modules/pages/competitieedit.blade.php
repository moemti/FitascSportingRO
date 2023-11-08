@extends('frame.masterdetail')

@section('masterdetail')


    <script type="text/javascript" src="{{asset('js/pages/competitieedit.js')}}"> </script> 

  
    <script>
        let poligoane = @JSON($poligoane);   
        let sportfields = @JSON($sportfields);     
    </script>                   

@endsection




@push('detail')
    <input id="CompetitionId" name= "CompetitionId" hidden>
    <div class="form-row">
        <div class="col-md-12">
            <div class="position-relative form-group"><label for="name">Titlu</label><input name="Name" id="Name" type="text" class="form-control" required></div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="position-relative form-group"><label for="StartDate">De la</label><input name="StartDate" id="StartDate" class="form-control" type="date" ></div>
        </div>
         <div class="col-md-3">
            <div class="position-relative form-group"><label for="EndDate">Pana la</label><input name="EndDate" id="EndDate" class="form-control" type="date" ></div>
        </div>
        <div class="col-6 col-md-6">
            <div class="position-relative form-group  ">
                
                <label class= "" for="RangeId">Poligon</label>
                
                <select name="RangeId" id="RangeId"  type="text" class="form-control" required >
                <option value=""></option>
                    @foreach($poligoane as $r)
                        <option value="{{$r->RangeId}}">{{$r->Name}}</option>
                    @endforeach
                </select>             
            </div>
        </div>     
    </div>

    <div class="row">

        <div class="col-md-2">
            <div class="position-relative form-group"><label for="Oficial">Competitie oficiala</label><input name="Oficial" id="Oficial" class="form-check-input" type="checkbox"></div>
        </div>
        <div class="col-md-2">
            <div class="position-relative form-group"><label for="IsEtapa">Etapa</label><input name="IsEtapa" id="IsEtapa" class="form-check-input" type="checkbox"></div>
        </div>
        <div class="col-md-2">
            <div class="position-relative form-group"><label for="IsFinala">Finala campionat</label><input name="IsFinala" id="IsFinala" class="form-check-input" type="checkbox"></div>
        </div>
        <div class="col-md-2">
            <div class="position-relative form-group"><label for="InSupercupa">Puncte supercupa</label><input name="InSupercupa" id="InSupercupa" class="form-check-input" type="checkbox"></div>
        </div>

     </div> 


      <div class="row">
        <div class="col-md-3">
            <div class="position-relative form-group"><label for="Targets">Nr talere</label><input name="Targets" id="Targets" class="form-control" type="number" ></div>
        </div>
      
        <div class="col-6 col-md-6">
            <div class="position-relative form-group  ">
                
                <label class= "" for="SportFieldId">Tip competitie</label>
                
                <select name="SportFieldId" id="SportFieldId"  type="text" class="form-control" required >
                <option value=""></option>
                    @foreach($sportfields as $r)
                        <option value="{{$r->SportFieldId}}">{{$r->Name}}</option>
                    @endforeach
                </select>             
            </div>
        </div>     
    </div>

      <div class="row">

        <div class="col-md-12">          
            <div class="position-relative form-group"><label for="Descriere">Descriere</label><textarea name="Descriere" id="Descriere"   class="form-control" ></textarea></div>
            
        </div>
       
    </div>






@endpush

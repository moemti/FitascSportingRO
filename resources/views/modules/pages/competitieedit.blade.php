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
             <label for="FirstDayStartTime">Ora incepere (Primul foc)</label>
            <div class="col-md-3">          
               <div class="position-relative form-group"><label for="FirstDayStartTime">Prima zi</label><input name="FirstDayStartTime" id="FirstDayStartTime" class="form-control" type="time" required></div>
            </div>
             <div class="col-md-3">          
               <div class="position-relative form-group"><label for="SecondDayStartTime">A doua zi</label><input name="SecondDayStartTime" id="SecondDayStartTime" class="form-control" type="time" required></div>
            </div>
           
        </div>

    <div class="row">
         <div class="col-3 col-md-3">
            <div class="position-relative form-group  ">
                
                <label class= "" for="ScheduleType">Tip tragere</label>
                
                <select name="ScheduleType" id="ScheduleType"  type="text" class="form-control" required >
                    <option value="Normal">Normal</option>
                    <option value="Condensat">Condensat</option>
                </select>             
            </div>
        </div>   
            <div class="col-md-3">          
               <div class="position-relative form-group"><label for="NrPoligoane">Nr poligoane</label><input name="NrPoligoane" id="NrPoligoane" class="form-control" type="number" required ></div>
            </div>
             <div class="col-md-3">          
               <div class="position-relative form-group"><label for="NrPosturiPoligon">Nr posturi pe poligon</label><input name="NrPosturiPoligon" id="NrPosturiPoligon" class="form-control" type="number" required ></div>
            </div>
             <div class="col-md-3">          
               <div class="position-relative form-group"><label for="ScheduleInterval">Interval tragere (minute)</label><input name="ScheduleInterval" id="ScheduleInterval" class="form-control" type="number" required></div>
            </div>
        
        </div>
           
            


    <div class="row">
        <div class="col-md-12">          
            <div class="position-relative form-group"><label for="Descriere">Descriere</label><textarea name="Descriere" id="Descriere"   class="form-control" ></textarea></div>
        </div>
    </div>






@endpush

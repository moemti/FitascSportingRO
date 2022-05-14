
<div class="detail detail_competitii ">

    <div class='row'>

        <span class="fi fi-rr-cross-small btn_close" ></span>
        
    </div>


    <div class='row'>
        <!-- <label for="input_competitie">Competitie</label> -->
 
        <div>
            <input id="input_competitie" value='{{$master[0]->Name}}' disabled> </input>
            <input id="input_sportfield" value='{{$master[0]->SportField}}'disabled> </input>
        </div>
    </div>


        
    <div class='row'>
        <!-- <label for="input_locatie">Locatie</label> -->
        <div>
             <input id="input_locatie" value='{{$master[0]->Range}}'disabled> </input>
        </div>
    </div>
    <div class='row'>
        <!-- <label for="input_startdate">Perioada</label> -->
        <div>
            <input id="input_startdate" value='{{$master[0]->StartDate}}'disabled> </input>
            <input id="input_enddate" value='{{$master[0]->EndDate}}'disabled> </input>
        </div>
    </div>

    <script> dsClasament = @Json($other['clasament']);</script>

    <h2> {{transex('Clasament')}}</h2>
   
    <div class='row'>
        <div class="gridcontainer">
        <button class="test">
        refresh
            </button>
             <smart-grid id="clasamentcompetitie"></smart-grid>
        </div>
    </div>


</div>


<div class="page_content page_content_master ">
        <h1>Utilizator de inregistrat</h1>

        <form class="" action="finishuser" method="POST">
            @csrf
            <input Name = "CompetitionId" id="CompetitionId" value='{{$CompetitionId}}' hidden> </input>



            <div class="position-relative form-group">
                <label class="form-label">Persoana existenta</label> 

                    <select Name='PersonId' id='PersonId' class="form-control real_input">
                        <option value = "-1">...</option>
                    @foreach ($persons as $person)
                        <option value = "{{$person->PersonId}}">{{$person->Name}}</option>
                    @endforeach
                    </select>
               
               
            </div>    

              
                <div class="position-relative form-group">
                     <label class="form-label">Nume intreg</label>
                    <input name="Name" id="Name" placeholder="Nume ..." type="text" class="form-control real_input" required>
                </div>

        </form>
</div>
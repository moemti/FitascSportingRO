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
                        <option value = "{{$person->PersonId}}" data-ShooterCategoryId = "{{$person->ShooterCategoryId}}" data-TeamId = "{{$person->TeamId}}">{{$person->Name}}</option>
                    @endforeach
                    </select>
               
               
            </div>    

              
            <div class="position-relative form-group">
                    <label class="form-label">Nume persoana noua</label>
                <input name="Name" id="Name" placeholder="Persoana noua" type="text" class="form-control real_input" required>
            </div>

            <div class="col-md-4">
            <div class="position-relative form-group"><label for="ShooterCategoryId">Category</label>
            
                <select name="ShooterCategoryId" id="ShooterCategoryId"  type="text" class="form-control"  >
                <option value=""></option>
                    @foreach($categories as $r)
                        <option value="{{$r->ShooterCategoryId}}" >{{$r->Name}}</option>
                    @endforeach
                </select>
        
            </div>
            </div>

            <div class="col-md-4">
                <div class="position-relative form-group"><label for="TeamId">Team</label>
                
                    <select name="TeamId" id="TeamId"  type="text" class="form-control"  >
                    <option value=""></option>
                        @foreach($teams as $r)
                            <option value="{{$r->TeamId}}">{{$r->Name}}</option>
                        @endforeach
                    </select>
            
                </div>
            </div>

            <div class="position-relative form-group">
                    <label class="form-label">Team new</label>
                <input name="Team" id="Team" placeholder="New Team" type="text" class="form-control real_input" required>
            </div>

        </form>
</div>
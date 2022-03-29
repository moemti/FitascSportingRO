<div id="addcompetitor" class="page_content page_content_master ">

        @if (!isset($PersonId)) 
            <h2>Persoana de inregistrat</h2>
        @else
            <h2>Ma inregistrez</h2>
        @endif

        <form class="" action="finishuser" method="POST">
            @csrf
            <input Name = "CompetitionId" id="CompetitionId" value='{{$CompetitionId}}' hidden> </input>

          

            <div class="position-relative form-group">
                <label class="form-label">Persoana existenta</label> 

                <select Name='PersonId' id='PersonId' class="form-control real_input" {{isset($PersonId)?'disabled':''}}>
                    <option value = "-1">...</option>
                @foreach ($persons as $person)
                    <option value = "{{$person->PersonId}}" data-ShooterCategoryId = "{{$person->ShooterCategoryId}}" data-TeamId = "{{$person->TeamId}}"  {{isset($PersonId) && $person->PersonId == $PersonId?'selected':''}}>{{$person->Name}} </option>
                @endforeach
                </select>
               
               
            </div>    


            @if (!isset($PersonId)) 
           
            <div class="position-relative form-group">
                    <label class="form-label">Nume persoana noua</label>
                <input name="Name" id="Name" placeholder="Persoana noua" type="text" class="form-control real_input" required>
            </div>

            
            
            @else
            
                <input Name='PersonId' id='PersonId' class="form-control real_input" value="{{$PersonId}}" hidden></input>
            
            @endif


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
                    <label class="form-label">New team</label>
                <input name="Team" id="Team" placeholder="New Team" type="text" class="form-control real_input" required>
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

            




        </form>
</div>
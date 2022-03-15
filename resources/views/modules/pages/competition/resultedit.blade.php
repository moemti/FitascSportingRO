@extends('frame.masterdetailOne')





@section('masterdetail')

    <script  type="text/javascript" src={{asset('js/pages/competitie/resultedit.js')}}></script>

   
@endsection



@push('detail')
    <input id="ResultId" name= "ResultId" hidden>
    <div class="form-row">
        <div class="col-md-12">
            <div class="position-relative form-group"><label for="name">Name</label><input name="Name" id="Name" type="text" class="form-control" disabled></div>
        </div>

    </div>
    <div class="form-row">

        <div class="col-md-4">
            <div class="position-relative form-group"><label for="ShooterCategoryId">Category</label>
            
                <select name="ShooterCategoryId" id="ShooterCategoryId"  type="text" class="form-control"  >
                <option value=""></option>
                    @foreach($categories as $r)
                        <option value="{{$r->ShooterCategoryId}}">{{$r->Name}}</option>
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

   
        <div class="col-md-2">
         <div class="position-relative form-group">
             <label for="Aborted">Renuntat</label>
             <input name="Aborted" id="Aborted"  type="checkbox"  class="form-check-input" >
             </div>
        </div>
     
        
       
        
    </div>


@endpush

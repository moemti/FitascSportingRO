@extends('frame.masterdetail')

@section('masterdetail')


    <script type="text/javascript" src="{{asset('js/pages/poligoaneedit.js')}}"> </script> 

  
    <script>
        let persons = @JSON($persons);   
        let countries = @JSON($countries);     
     
    </script>                   

@endsection




@push('detail')
    <input id="RangeId" name= "RangeId" hidden>
    <div class="form-row">
        <div class="col-md-12">
            <div class="position-relative form-group"><label for="name">Name</label><input name="Name" id="Name" type="text" class="form-control" required></div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="position-relative form-group"><label for="Address">Address</label><input name="Address" id="Address" class="form-control" ></div>
        </div>

        <div class="col-md-2">
            <div class="position-relative form-group"><label for="Contact">Contact</label><input name="Contact" id="Contact" class="form-control" ></div>
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
            <div class="position-relative form-group"><label for="Phone">Phone</label><input name="Phone" id="Phone"  type="text" class="form-control" ></div>
        </div>
    </div>


    <div class="row">
        <div class="position-relative form-group col-12 col-md-6">
            <label class= "form-label">Coordinates</label>
            <input name="Coordinates" id="Coordinates" class="form-control" >
        </div>
        <div class="position-relative form-group col-12 col-md-6">
            <label class= "form-label">Link</label>
            <input name="Link" id="Link" class="form-control" >
        </div>
    </div >




@endpush

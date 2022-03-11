@extends('frame.masterdetail')

@section('masterdetail')


    <script type="text/javascript" src={{asset('js/pages/persoane.js')}}> </script> 

  
    <script>
        let seasons = @JSON($seasons);     
        let shootercategories = @JSON($shootercategories);    
        let teams = @JSON($teams);    
        let roles = @JSON($roles);    
    </script>                   

@endsection




@push('detail')
    <input id="PersonId" name= "PersonId" hidden>
    <div class="form-row">
        <div class="col-md-12">
            <div class="position-relative form-group"><label for="name">Name</label><input name="Name" id="Name" type="text" class="form-control" required></div>
        </div>

    </div>
    <div class="form-row">
        <div class="col-md-4">
            <div class="position-relative form-group"><label for="NicName">NickName</label><input name="NickName" id="NickName" class="form-control" ></div>
        </div>
        <div class="col-md-2">
            <div class="position-relative form-group"><label for="Code">Code</label><input name="Code" id="Code" class="form-control" ></div>
        </div>
        
        
        <div class="col-md-6">
          
            <div class="position-relative form-group"><label for="Email">Email</label><input name="Email" id="Email"  type="text" class="form-control" ></div>
        </div>

        
    </div>

    <div class="form-row">
        <div class="col-md-2">
             <label for="HasUser">Are user</label><input name="HasUser" id="HasUser"  type="checkbox"  class="form-control" >
        </div>
        <div class="col-md-2">
            <label for="IsSuperUser">Este super user</label><input name="IsSuperUser" id="IsSuperUser"  type="checkbox"  class="form-control" >
        </div>

        
    </div>

@endpush

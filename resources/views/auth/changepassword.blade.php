@extends('layouts.base')
	
    @push('content')

    <div class="page_content page_content_master page_content_changepass">

                
                <h1>Modificare parola</h1>
               
                <form class="" action="changethepassword" method="POST">
                    @csrf

                    <input type="hidden" name = '_passtoken' value = "{{$_passtoken}}"> 
                    <div class="form-row">
                        
                        <div class="col-md-12">
                            <div class="position-relative form-group"><input name="password" id="password" placeholder="Parola..." type="password" class="form-control real_input" required></div>
                        </div>
                        <div class="col-md-12">
                            <div class="position-relative form-group"><input name="password2" id="password2" placeholder="Parola inca o data..." type="password" class="form-control real_input" required></div>
                        </div>
                    </div>

                    @if (isset($mesaj) && array_key_exists('mesaj',$mesaj))
                    <div class="col-md-12">
                        <span class="text-danger">
                            <strong>{{ $mesaj['mesaj'] }}</strong>
                        </span>
                        </div>
                    @endif



                    <div class="divider row"></div>

                  
                    <div class="d-flex align-items-right u-margin-top-medium">
                        <div class="ml-auto"><!--a href="javascript:void(0);" class="btn-lg btn btn-link">Recover Password</a-->
                            <button class="btn btn-primary btn-lg">Reseteaza</button>
                        </div>
                    </div>
                </form>
                  <div class="form-row">    
                        <div class="col-md-12">
                            <div><a href="{{url('/login')}}">Login</a></div>
                    </div>
                </div>
        </div>  

@endpush




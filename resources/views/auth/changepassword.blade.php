@extends('layouts.baseex')
	
    @push('content')

 
    <section class="content-termeni section section-tertiary section-no-border m-0">
    <div class="container">

                
                <h1>Modificare parola</h1>
               
                <form class="" action="changethepassword" method="POST">
                    @csrf

                    <input type="hidden" name = '_passtoken' value = "{{$_passtoken}}"> 
                    <div class="form-row">
                        
                        <div class="col-md-12">
                            <div class="position-relative form-group"><input name="password" id="password" placeholder="{{transex('Parola')}}..." type="password" class="form-control real_input" required></div>
                        </div>
                        <div class="col-md-12">
                            <div class="position-relative form-group"><input name="password2" id="password2" placeholder="{{transex('Parola inca o data')}}..." type="password" class="form-control real_input" required></div>
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
                            <button class="btn btn-primary btn-lg">{{transex('Reseteaza')}}</button>
                        </div>
                    </div>
                </form>
                  <div class="form-row">    
                        <div class="col-md-12">
                            <div><a href="{{url('/login')}}">{{transex('Login')}}</a></div>
                    </div>
                </div>
        </div>  
</section>
@endpush




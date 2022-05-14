
@extends('layouts.baseex')
	
    @push('content')

    <section class="content-termeni section section-tertiary section-no-border m-0">
    <div class="container">

        <form action="registerme" method="POST">

            @csrf
                    
                      
                            <h1>{{transex('Bine ati venit')}}</h1>
                            <h2>{{transex('Intruduceti toate datele pentru a va crea un cont')}}</h2>
                            
                              
                    <div class="row">
                        <div class="col-md-12">
                            <div class="position-relative form-group"><input name="Email" id="Email" placeholder="{{transex('Email')}}.." type="email" class="form-control real_input" required></div>
                        </div>
                        <div class="col-md-12">
                            <div class="position-relative form-group"><input name="Name" id="Name" placeholder="{{transex('Numele')}}..." type="text" class="form-control real_input" required></div>
                        </div>

                        <div class="col-md-12">
                            <div class="position-relative form-group"><input name="UserName" id="UserName" placeholder="{{transex('Club (daca sunteti membru)')}}..." type="text" class="form-control real_input" ></div>
                        </div>

                        <div class="col-md-12">
                            <div class="position-relative form-group"><input name="password" id="Password" placeholder="{{transex('Parola')}}..." type="password" class="form-control real_input" required></div>
                        </div>
                        <div class="col-md-12">
                            <div class="position-relative form-group"><input name="password2" id="Password2" placeholder="{{transex('Repetati parola')}}..." type="password" class="form-control real_input" required></div>
                        </div>
                    </div>


                    <div class="mt-3 position-relative form-check"><input name="check" id="Check" type="checkbox" class="form-check-input" required>
                            <label for="Check" class="form-check-label">{{transex('Acceptati')}} <a href="{{Route('termeni')}}">{{transex('Termenii si conditiile noastre')}}</a>.</label></div>
                  
                <div class=" d-block text-right u-margin-top-medium">
                    <button class="btn-wide btn-pill btn-shadow btn-hover-shine btn btn-primary btn-lg">{{transex('Creaza cont')}}</button>
                </div>
                </br>
                <div>

                @if (isset($mesaj) && array_key_exists('NotOK', $mesaj))
                    <div class="col-md-12">
                    <h6><span class="text-danger">
                        {{ $mesaj['NotOK'] }} 
                        </span>
                    </h6>
                    </div>
                @endif
                @if (isset($mesaj) && array_key_exists('OK', $mesaj))
                    <div class="col-md-12">
                    <h6><span class="text-succcess">
                        {{ $mesaj['OK'] }} 
                        </span>
                    </h6>
                    </div>
                @endif

                            
                </div>
            
        </form>
        
        <div class="row">   
        </br> 
                <div class="col-md-12">
                    <div><a href="{{url('/login')}}">{{transex('Login')}}</a></div>
                    
                </div>
        </div>
                     
</div>
</section>
@endpush
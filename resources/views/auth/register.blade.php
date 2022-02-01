
@extends('layouts.base')
	
    @push('content')

    <div class="page_content page_content_master page_content_register">

        <form action="registerme" method="POST">

            @csrf
                    
                      
                            <h1>Bine ati venit</h1>
                            <h2>Intruduceti toate datele pentru a va crea un cont</h2>
                            
                              
                    <div class="row">
                        <div class="col-md-12">
                            <div class="position-relative form-group"><input name="Email" id="Email" placeholder="Email here..." type="email" class="form-control real_input" required></div>
                        </div>
                        <div class="col-md-12">
                            <div class="position-relative form-group"><input name="Name" id="Name" placeholder="Name here..." type="text" class="form-control real_input" required></div>
                        </div>
                        <div class="col-md-12">
                            <div class="position-relative form-group"><input name="password" id="Password" placeholder="Password here..." type="password" class="form-control real_input" required></div>
                        </div>
                        <div class="col-md-12">
                            <div class="position-relative form-group"><input name="password2" id="Password2" placeholder="Repeat Password here..." type="password" class="form-control real_input" required></div>
                        </div>
                    </div>


                    <div class="mt-3 position-relative form-check"><input name="check" id="Check" type="checkbox" class="form-check-input" required>
                            <label for="Check" class="form-check-label">Acceptati <a href="javascript:void(0);">Termenii si conditiile noastre</a>.</label></div>
                  
                <div class=" d-block text-right u-margin-top-medium">
                    <button class="btn-wide btn-pill btn-shadow btn-hover-shine btn btn-primary btn-lg">Creaza cont</button>
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
                    <div><a href="{{url('/login')}}">Login</a></div>
                    
                </div>
        </div>
                     
</div>
@endpush
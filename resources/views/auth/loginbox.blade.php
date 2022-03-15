
  <section class="content-termeni section section-tertiary section-no-border m-0">
    <div class="container">
        <h1>Login</h1>

 
        <form class="" action="authenticate" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="position-relative form-group">
                        <input name="username" id="username" placeholder="Email..." type="email" class="form-control real_input" required>
                    </div>
                </div>
                @if (isset($mesaj) && array_key_exists('NumeUtilizator',$mesaj))
                <div class="col-md-12">
                    <span class="text-danger">
                        <strong>{{ $mesaj['NumeUtilizator'] }}</strong>
                    </span>
                    </div>
                @endif
                
            </div>
            <div class="row">    
                <div class="col-md-12">
                    <div class="position-relative form-group">
                        <input name="password" id="password" placeholder="Parola..." type="password" class="form-control real_input" required>
                    </div>
                </div>
                
                
                
                    @if (isset($mesaj) && array_key_exists('password', $mesaj))
                    <div class="col-md-12">
                    <span class="text-danger">
                        <strong>{{ $mesaj['password'] }}</strong>
                    </span>
                    </div>
                @endif
                
            </div>
            
              

            <div class="  text-right u-margin-top-medium">
                     <button class="btn-wide btn-pill btn-shadow btn-hover-shine btn btn-primary btn-lg">Login</button>
               
            </div>

            @if (isset($mesaj) && array_key_exists('mesaj', $mesaj))
                    <div class="col-md-12">
                    <span class="text-succcess">
                        <strong>{{ $mesaj['mesaj']}}</strong>
                    </span>
                    </div>
                @endif
        </form>

   
        </br>
        <div class="row">    
                
                    <div><a href="{{route('resetpassword')}}">Am uitat parola</a></div>
                   
                
        </div>

        </br>
        <div class="row">    
              
                    <div><a href="{{route('register')}}">Inregistrare</a></div>
                
        </div>
</div>
</section>
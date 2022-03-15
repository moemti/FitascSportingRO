@extends('layouts.baseex')
	
    @push('content')
    <section class="content-termeni section section-tertiary section-no-border m-0">
    <div class="container">

        <h1>Reseteaza parola</h1>
        <form class="" action="resetpassword" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="position-relative form-group">
                            <input name="email" id="email" placeholder="Email..." type="email" required class="form-control real_input" >
                        </div>
                    </div>
                    @if (isset($mesaj) && array_key_exists('email',$mesaj))
                    <div class="col-md-12">
                        <span class="text-danger">
                            <strong>{{ $mesaj['email'] }}</strong>
                        </span>
                    </div>
                    @endif
                    
                </div>


                <div class="row">   
                    <div class=" d-block text-right u-margin-top-medium">
                        <button class="btn-wide btn-pill btn-shadow btn-hover-shine btn btn-primary btn-lg">Reseteaza</button>
                    </div>
                    </br>
                    <div>
                        <h6 class="text-succcess"><span>Dupa resetare veti primi un email si apasati pe link-ul din continut</span></h6>
                                
                    </div>
                </div>
                
            </form>



            <div class="form-row">    
                    <div class="col-md-12">
                        <div><a href="{{route('login')}}">Login</a></div>
                        
                    </div>
            </div>
</div>
</section>
@endpush








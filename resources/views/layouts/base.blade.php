<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{csrf_token()}}">
        
        <title>SPORTING ROMANIA</title>

        <script type="text/javascript">
             var APP_URL = {!! json_encode(url('/')) !!}
             var baseUrl = APP_URL;
             let IsSuperUser = 0;
             let MyName = '{{session("name")}}';
             @if (session("IsSuperUser") == 1)
                IsSuperUser = 1;
             @endif
             
        </script>

        @stack('css')

       <link rel="stylesheet" href="{{asset('css/bootstrap/bootstrap.min.css')}}" type="text/css" /> 

        <link rel="apple-touch-icon" sizes="180x180" href="{{asset('img/apple-touch-icon.png')}}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{asset('img/favicon-32x32.png')}}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{asset('img/favicon-16x16.png')}}">
        <link rel="manifest" href="{{asset('img/site.webmanifest')}}">

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet">

  
        <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900" rel="stylesheet">
        <!-- <link rel="shortcut icon" type="image/png" href="img/favicon.png"> -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- smart grid -->
       
        <script type="module" src="{{asset('js/components/smart/source/modules/smart.grid.js')}}"></script>
        <script type="module">
            window.Smart.License = "8414516F-15A2-4D84-A7AF-A9A72400DB02";
        </script>

        <link rel="stylesheet" type="text/css" href="{{asset('js/components/smart//source/styles/smart.default.css')}}" />


        <script src="{{asset('js/app.js')}}"></script>
        <link rel="stylesheet" href={{asset("css/style.css")}}>
        <link rel="stylesheet"  href={{asset("css/uicons-regular-rounded.css")}} >
    
        <script type="text/javascript" src="{{asset('js/bootstrap/bootstrap.min.js')}}"></script> 
        <script src={{asset("js/scripts-init/toastr-fromsite.js")}}></script>
        <script src={{asset("js/scripts-init/toastr.js")}}></script>

        <!--SweetAlert2-->

		<script src={{asset("js/scripts-init/sweet-alerts-fromsite.js")}}></script>
        <script src={{asset("js/scripts-init/sweet-alerts.js")}}></script>

        <script src={{asset("js/scripts-init/blockui.min.js")}}></script>
  

        @stack('scripts')
        
    </head>
    <body>
        @CSRF
        @stack('scripts_body')
        <div class="bodycontent">
            <header class="header">
                
                    <div class="header__title">
                        <h1 >
                            Sporting Romania
                        </h1> 
                    </div>

                    <div class="header__userlogin">
                        @include('modules.userloginheader')
                    </div>
                
                    <div class="header__user">
                        @if (session("PersonId") > 0)
       
                            <h2 >
                               <a href="{{Route('myuser')}}"> {{session("name") }}</a>
                            </h2>

                        @endif
                    </div>
            
            </header>
            @include('modules.navigation')
            <div class="container">

                <div class="content">
                    
                    @stack('content')
                </div>
                
                <div class="sidebar">
                        @stack('sidebar_right')
                </div>
            </div>

            <footer class="footer">
                   
                    @stack('footer')
                    <div class="footer__content">
                        @include('modules.footer')
                    </div>

                    <div class="footer__copyright">
                        © <span class='copyright__company'>Sporting Romania</span> 
                    </div>
            </footer>
        </div>

        <div id="loaderLeft">&nbsp;</div>
        <div id="loaderRight">&nbsp;</div>
  

    	@include('frame.bodyfooter')
    </body>
</html>

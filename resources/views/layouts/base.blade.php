<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SPORTING ROMANIA</title>

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet">

        <link rel="stylesheet" href={{asset("css/style.css")}}>
        <link href={{asset("icons/css/uicons-regular-rounded.css")}} rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900" rel="stylesheet">
        <link rel="shortcut icon" type="image/png" href="img/favicon.png">
        <script src="{{asset('js/app.js')}}"></script>
        
    </head>
    <body>
        <div class="bodycontent">
            <header class="header">
                    <div class="header__logo-box">
                    
                            <!-- <img src="{{asset('img/logo.png')}}" alt="trillo logo" class="header__logo">     -->
                    </div>   
                    <div class="header__title">
                        <h1 >
                            Sporting Romania
                        </h1> 
                    </div>

                    <div class="header__userlogin">
                    
                        @include('modules.userloginheader')
                    

                    </div>
                    
                     @include('modules.navigation')
                    

            </header>
            <div class="container">
                


                <div class="content">
                    
                        @stack('content')
                    
                </div>

                <div class="sidebar">
                    
                        @stack('sidebar')

                    
                </div>

            
            </div>

            <footer class="footer">
                   
                    @stack('footer')
                    <div class="footer__content">
                        @include('modules.footer')
                    </div>

                    <div class="footer__copyright">
                        © Copyright by <span class='copyright__company'>Molland soft</span> 
                    </div>
            </footer>
        </div>

        <div id="loaderLeft">&nbsp;</div>
        <div id="loaderRight">&nbsp;</div>

    </body>
</html>

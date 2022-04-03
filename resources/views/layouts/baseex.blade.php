<!DOCTYPE html>
<html>
	<head>

		<!-- Basic -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">	

		<title>Sporting Romania</title>	

		<meta name="keywords" content="Sporting romania" />
		<meta name="description" content="Sporting Romania">
		<meta name="author" content="Molland soft">
        <meta name="csrf-token" content="{{csrf_token()}}">

     

		<!-- Favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{asset('img/apple-touch-icon.png')}}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{asset('img/favicon-32x32.png')}}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{asset('img/favicon-16x16.png')}}">
        <link rel="manifest" href="{{asset('img/site.webmanifest')}}">


		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

		<!-- Web Fonts  -->
		<link id="googleFonts" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800%7CPlayfair+Display:400,400i,700%7CSintony:400,700,800&display=swap" rel="stylesheet" type="text/css">

     
		<!-- Vendor CSS -->
		<link rel="stylesheet" href="{{asset('js/theme/vendor/bootstrap/css/bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{asset('js/theme/vendor/fontawesome-free/css/all.min.css')}}">
		<link rel="stylesheet" href="{{asset('js/theme/vendor/animate/animate.compat.css')}}">
		<link rel="stylesheet" href="{{asset('js/theme/vendor/simple-line-icons/css/simple-line-icons.min.css')}}">
		<link rel="stylesheet" href="{{asset('js/theme/vendor/owl.carousel/assets/owl.carousel.min.css')}}">
		<link rel="stylesheet" href="{{asset('js/theme/vendor/owl.carousel/assets/owl.theme.default.min.css')}}">
		<link rel="stylesheet" href="{{asset('js/theme/vendor/magnific-popup/magnific-popup.min.css')}}">

		<!-- Theme CSS -->
		<link rel="stylesheet" href="{{asset('css/theme/theme.css')}}">
		<link rel="stylesheet" href="{{asset('css/theme/theme-elements.css')}}">
		<link rel="stylesheet" href="{{asset('css/theme/theme-blog.css')}}">
		<link rel="stylesheet" href="{{asset('css/theme/theme-shop.css')}}">

        <script type="module" src="{{asset('js/components/smart/source/modules/smart.grid.js')}}"></script>
        <script type="module">
            window.Smart.License = "8414516F-15A2-4D84-A7AF-A9A72400DB02";
        </script>

        
			<!-- Global site tag (gtag.js) - Google Analytics -->
			<script async src="https://www.googletagmanager.com/gtag/js?id=G-6F7LNKW6T2"></script>
			<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());

			gtag('config', 'G-6F7LNKW6T2');
			</script>



		<!-- Demo CSS -->
		<link rel="stylesheet" href="{{asset('css/theme/demo-church.css')}}">

		<!-- Skin CSS -->
		<link id="skinCSS" rel="stylesheet" href="{{asset('css/theme/skins/skin-church.css')}}">

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="{{asset('css/theme/custom.css')}}">

		<!-- Head Libs -->
		<script src="{{asset('js/theme/vendor/modernizr/modernizr.min.js')}}"></script>

        <script type="text/javascript">
             var APP_URL = {!! json_encode(url('/')) !!}
             var baseUrl = APP_URL;
             let IsSuperUser = 0;
			 let PersonId = 0;
			 @if (session()->has('PersonId'))
			 	PersonId = {{session('PersonId')}};
			 @endif
             let MyName = '{{session("name")}}';
             @if (session("IsSuperUser") == 1)
                IsSuperUser = 1;
             @endif
             
        </script>

        @stack('css')
        @stack('scripts')

	</head>
	<body>

    @php 
      $menus = config('navigation.MENU') 
    @endphp
		<div class="body">
			<header id="header" class="header-effect-shrink" data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyChangeLogo': false, 'stickyStartAt': 100, 'stickyHeaderContainerHeight': 70}">
				<div class="header-body border-top-0">
					<div class="header-top">
						<div class="container">
							<div class="row justify-content-between">
								<div class="col-auto">
									<!-- <p class="custom-secondary-font font-weight-bold custom-text-color-1 text-6 mb-0">Sporting Romania</p> -->
								</div>
								<div class="col-auto d-flex align-items-center">
									<nav>
										<ul class="list list-unstyled d-flex text-1 mb-0  social-icons-medium  me-2 mb-0 ms-1">
											
                                            @if (session("PersonId") > 0)
                                                <li class="mb-0"><a href="{{Route('myuser')}}" class="alternative-font-4 text-decoration-none text-3-5 font-weight-bold">{{session("name") }}</a></li>
                                         
                                            @endif
                                        
											<!-- <li class="mb-0 ms-4-5 d-none d-sm-block"><a href="demo-church-events.html" class="alternative-font-4 text-decoration-none text-3-5 font-weight-bold">CALENDAR</a></li> -->
										</ul>
                                    </nav>
                                        <div class="header-nav-features  ms-5-5">
                                            <ul class="header-social-icons social-icons social-icons-clean social-icons-icon-dark-2 social-icons-medium me-2 mb-0 d-sm-block ms-1">
                                            <li class="social-icons-googleplus">
                                                    @if (session("PersonId") > 0)
                                                    <a href="{{Route('logout')}}" class="">
                                                        <i class="fas fa-user-slash"></i>
                                                    </a>
                                                    @else
                                                    <a href="{{Route('login')}}" class="">
                                                        <i class="fas fa-user"></i>
                                                    </a>
                                                    @endif  
                                            </li>
                                            </ul>
                                        </div>
								</div>
							</div>
						</div>
					</div>

					
					<div class="header-container container">
						<div class="header-row">
							<div class="header-column">
								<div class="header-row">
									<div class="header-logo mt-1">
										<a href="{{Route('welcome')}}">
											<img alt="Logo" width="200" src="{{asset('img/coollogo_com-329832.png')}}">
										</a>
									</div>
								</div>
							</div>
							<div class="header-column justify-content-end">
								<div class="header-row">
									<div class="header-nav order-2 order-lg-1 alternative-font-4">
										<div class="header-nav-main header-nav-main-square header-nav-main-dark-text header-nav-main-effect-1 header-nav-main-sub-effect-1">
											<nav class="collapse">
												<ul class="nav nav-pills" id="mainNav">
                                                @php
                                                        foreach($menus as $menu){
                                                @endphp
                                                    @if ((count($menu) === 2) || (($menu[2] == 'super') && (session('IsSuperUser') == 1) ) )
                                                        <li 
                                                                @if (is_array($menu[0]))
                                                                        class="dropdown dropdown-full-color dropdown-primary">
														
                                                                        <a href='#' class="dropdown-item dropdown-toggle">{{$menu[1]}}</a>
                                                                        <ul class="dropdown-menu">
                                                                    
                                                                        @php
                                                                                foreach($menu[0] as $submenu){
                                                                        @endphp
															                     <li>
                                                                                <a href={{url($submenu[0])}} class="dropdown-item" >{{$submenu[1]}}</a> 
                                                                                </li>

                                                                        @php
                                                                                }
                                                                        @endphp 
                                                                        </ul>  
                                                                @else
                                                                   >
                                                                    <a href={{url($menu[0])}} class="navmenu">{{$menu[1]}}</a>
                                                                @endif
                                                        </li>

                                                    @endif

                                                    @php
                                                            }
                                                    @endphp  
                                                 


												</ul>
											</nav>
										</div>
										<button class="btn header-btn-collapse-nav" data-bs-toggle="collapse" data-bs-target=".header-nav-main nav">
											<i class="fas fa-bars"></i>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>




				</div>
			</header>

			<div role="main" class="main">

 

                <section id="marketing" class=" section-no-border m-0 p-0">
					<div class="container_">
					    <div class="row justify-content-center text-center align-items-center ">
								@php

							

								function outputFiles($path){
								
								

									if(file_exists($path) && is_dir($path)){
									
									
										$result = scandir($path);
										
									

										$files = array_diff($result, array('.', '..'));
										
									
										if(count($files) > 0){
										
											foreach($files as $file){

											

												if(is_file("$path/$file")){
												
													$url = url($path.'/'.$file);
													$link = basename($path);
												
													echo " <div class='col-lg-2 col-sm-8 mb-3 mb-lg-0' 
													style=' max-width: 100%; height: auto;  overflow: hidden;'>
													<a href='//www.$link' target='_blank'>  
														<img style='    width: 120px;
				
														float: center;
														margin: 0px;
														padding: 0px;' src= '$url'>
													</a>
												</div>";


												} else {

												

												
														outputFiles("$path/$file");
													
												}
											}
										} 
									}
								}
								
								outputFiles("img/marketing");

						
                                @endphp
							
						
                        </div>	
					</div>
                 </section>




                 <div id = "marketingphone"  class="owl-carousel owl-carousel-light owl-carousel-light-init-fadeIn owl-theme manual dots-inside dots-horizontal-center show-dots-hover show-dots-xs show-dots-sm 
                 show-dots-md nav-inside nav-inside-edge show-nav-hover custom-carousel-arrows-style-1 mb-1" data-plugin-options="{'autoplayTimeout': 5000}"  style="height: 8vh;">
                    <div class="owl-stage-outer">
                        <div class="owl-stage">

                        


                            @php
								



							function outputFiles2($path){
								
								

								if(file_exists($path) && is_dir($path)){
								
								
									$result = scandir($path);
									
								

									$files = array_diff($result, array('.', '..'));
									
								
									if(count($files) > 0){
									
										foreach($files as $file){

										

											if(is_file("$path/$file")){
											
												$url = url($path.'/'.$file);
												$link = basename($path);
											
												echo "  <div class='owl-item position-relative overflow-hidden text-center'>
															<div class='container position-relative z-index-3 h-100'>
															<a href='//www.$link' target='_blank' style='display: inline-flex;    float: center;'> 
																<img style='   height: 8vh;
                        
																	float: center;
																	margin: 0px;
																	padding: 0px;' src= '$url'>
															</a>
															</div>
														</div>";


											} else {

											

											
													outputFiles2("$path/$file");
												
											}
										}
									} 
								}
							}
							
							outputFiles2("img/marketing");

							@endphp
                          
                        </div>
                    </div>

                </div>





                 @stack('content')

				 <div class="row justify-content-center text-center align-items-center section section-default bg-color-light-scale-1">
						 <div class="row justify-content-center text-center align-items-center ">
							<p class="alternative-font-4 text-3-5 mb-0">
								<strong class="d-block text-color-dark custom-secondary-font text-5-5 line-height-8 mb-0">Parteneri</strong>
								
							</p>
						</div>
						<div class="col-lg-3 custom-sm-margin-bottom-1 pb-3">
                            <!-- <a href="{{Route('welcome')}}" class="alternative-font-4 text-decoration-none text-5-5 font-weight-bold">Sporting Romania</a> -->
							
                                    <a href="//www.fitasc.com" target="_blank">  
                                        <img style="    width: 100px;
   
                                        float: center;
                                        margin: 0px;
                                        padding: 0px;" src=" {{url('img/parteneri/fitasc.png')}}">
                                    </a>
                              
						</div>
						<div class="col-lg-3 custom-sm-margin-bottom-1 pb-3">
                            <!-- <a href="{{Route('welcome')}}" class="alternative-font-4 text-decoration-none text-5-5 font-weight-bold">Sporting Romania</a> -->
							
                                    <a href="//www.arw.ro" target="_blank">  
                                        <img style="    width: 100px;
   
                                        float: center;
                                        margin: 0px;
                                        padding: 0px;" src=" {{url('img/parteneri/arrow.png')}}">
                                    </a>
                              
						</div>
						<div class="col-lg-3 custom-sm-margin-bottom-1 pb-3">
                            <!-- <a href="{{Route('welcome')}}" class="alternative-font-4 text-decoration-none text-5-5 font-weight-bold">Sporting Romania</a> -->
							
                                    <a href="//www.agvps.ro" target="_blank">  
                                        <img style="    width: 160px;
   
                                        float: center;
                                        margin: 0px;
                                        padding: 0px;" src=" {{url('img/marketing/agvps.ro/agvps.png')}}">
                                    </a>
                              
						</div>
						<div class="col-lg-3 custom-sm-margin-bottom-1 pb-3">
                            <!-- <a href="{{Route('welcome')}}" class="alternative-font-4 text-decoration-none text-5-5 font-weight-bold">Sporting Romania</a> -->
							
                                    <a href="//www.frts.ro" target="_blank">  
                                        <img style="    width: 100px;
                                        float: center;
                                        margin: 0px;
										
                                        padding: 0px;" src=" {{url('img/parteneri/frts.png')}}">
                                    </a>
                              
						</div>
					</div>

			<footer id="footer" class="bg-color-secondary custom-footer m-0" style="background: url({{asset('img/theme/footer-bg.jpg')}}); background-size: cover;">
				<div class="container pt-3">
					
					


					<hr class="solid tall custom-hr-color-1">
					<div class="row justify-content-center text-center">
						<div class="col-lg-3 custom-sm-margin-bottom-1">
							<i class="fas fa-map-marker-alt text-color-primary custom-icon-size-1"></i>
							<p class="custom-text-color-2 alternative-font-4 text-3-5">
								<strong class="d-block text-color-light custom-secondary-font text-5-5 line-height-8 mb-1">Localizare</strong>
								FRTS, Str. Vadul Moldovei, Nr. 14, Sector 1, 014033  </br>Bucuresti ROMANIA
							</p>
						</div>
						<div class="col-lg-4 custom-sm-margin-bottom-1">
		
                            <i class="fas fa-align-justify text-color-primary custom-icon-size-1"></i>
							<p class="custom-text-color-2 alternative-font-4 text-3-5">
								<strong class="d-block text-color-light custom-secondary-font text-5-5 line-height-8 mb-1">Termeni si conditii</strong>
								 <br>
								<a href="{{Route('termeni')}}">Vezi termenii si conditiile de utilizare</a>
							</p>
						</div>
						<div class="col-lg-3">
							<i class="fas fa-phone-volume text-color-primary custom-icon-size-1"></i>
							<p class="alternative-font-4 text-3-5">
								<strong class="d-block text-color-light custom-secondary-font text-5-5 line-height-8 mb-1">Contact</strong>
								<a href="tel:+" class="text-decoration-none custom-text-color-2">Telefon : </a></br>
								<a href="mail:admin@fitascsporting.ro" class="text-decoration-none custom-text-color-2">Email : admin@fitascsporting.ro</a>
							</p>
						</div>
					</div>
					<hr class="solid tall custom-hr-color-1">
					<div class="row text-center pb-5">
						<div class="col">
							<ul class="social-icons social-icons-clean custom-social-icons mb-3">
								<li class="social-icons-facebook"><a href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
								<li class="social-icons-googleplus"><a href="http://www.google.com/" target="_blank" title="Google Plus"><i class="fab fa-google-plus-g"></i></a></li>
								<li class="social-icons-twitter"><a href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a></li>
								<li class="social-icons-instagram"><a href="http://www.instagram.com/" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a></li>
							</ul>
							<p class="alternative-font-4 text-3 text-color-light opacity-7">© Copyright 2022. All Rights Reserved.</p>
						</div>
					</div>
				</div>
			</footer>
		</div>

		<!-- Vendor -->
		<script src="{{asset('js/theme/vendor/jquery/jquery.min.js')}}"></script>
		<script src="{{asset('js/theme/vendor/jquery.appear/jquery.appear.min.js')}}"></script>
		<script src="{{asset('js/theme/vendor/jquery.easing/jquery.easing.min.js')}}"></script>
		<script src="{{asset('js/theme/vendor/jquery.cookie/jquery.cookie.min.js')}}"></script>
		
        <!-- <script src="{{asset('js/bootstrap/bootstrap.min.js')}}"></script>   -->
       
     

		<script src="{{asset('js/theme/vendor/jquery.validation/jquery.validate.min.js')}}"></script>
		<script src="{{asset('js/theme/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js')}}"></script>
		<script src="{{asset('js/theme/vendor/jquery.gmap/jquery.gmap.min.js')}}"></script>
		<script src="{{asset('js/theme/vendor/lazysizes/lazysizes.min.js')}}"></script>
		<script src="{{asset('js/theme/vendor/isotope/jquery.isotope.min.js')}}"></script>
		<script src="{{asset('js/theme/vendor/owl.carousel/owl.carousel.min.js')}}"></script>
		<script src="{{asset('js/theme/vendor/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
		<script src="{{asset('js/theme/vendor/vide/jquery.vide.min.js')}}"></script>
		<script src="{{asset('js/theme/vendor/vivus/vivus.min.js')}}"></script>
		<script src="{{asset('js/theme/vendor/jquery.countdown/jquery.countdown.min.js')}}"></script>

        <script src="{{asset('js/theme/vendor/bootstrap/js/bootstrap.js')}}"></script> 
        <script src="{{asset('js/theme/vendor/bootstrap/js/modal.js')}}"></script> 

		<!-- Theme Base, Components and Settings -->
		<script src="{{asset('js/theme/theme.js')}}"></script>

		<!-- Current Page Vendor and Views -->
		<script src="{{asset('js/theme/view.contact.js')}}"></script>

		<!-- Demo -->
		<script src="{{asset('js/theme/demo-church.js')}}"></script>

		<!-- Theme Custom -->
		<script src="{{asset('js/theme/custom.js')}}"></script>

		<!-- Theme Initialization Files -->
		<script src="{{asset('js/theme/theme.init.js')}}"></script>

        <script src="{{asset('js/app.js')}}"></script>
  
    
        <script src="{{asset('js/scripts-init/toastr-fromsite.js')}}"></script>
        <script src="{{asset('js/scripts-init/toastr.js')}}"></script>

        <!--SweetAlert2-->

        <script src="{{asset('js/scripts-init/sweet-alerts-fromsite.js')}}"></script>
        <script src="{{asset('js/scripts-init/sweet-alerts.js')}}"></script>

        <script src="{{asset('js/scripts-init/blockui.min.js')}}"></script>

        
        <link rel="stylesheet" href="{{asset('css/style.css')}}">

	    @stack('footerscripts')

	    @include('frame.bodyfooter')
	</body>
</html>
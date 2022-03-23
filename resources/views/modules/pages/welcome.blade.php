@extends('layouts.baseex')

@push('footerscripts')


<script src="{{asset('js/pages/welcome.js')}}"></script>

@endpush


@push('content')

    <div class="container">
        <div class="announcement row alert alert-quaternary alert-sm justify-content-center"><a href="{{url('/regulamente')}}">ATENTIE - Regulament intern 18-03-2022</a></div>
        
    </div>

    <div class="owl-carousel owl-carousel-light owl-carousel-light-init-fadeIn owl-theme manual dots-inside dots-horizontal-center show-dots-hover show-dots-xs show-dots-sm show-dots-md full-width nav-inside nav-inside-edge show-nav-hover custom-carousel-arrows-style-1 mb-0" data-plugin-options="{'autoplayTimeout': 7000}" data-dynamic-height="['600px','600px','600px','500px','500px']" style="height: 50vh;">
        <div class="owl-stage-outer">
            <div class="owl-stage">

                <!-- Carousel Slide 1 -->
                <div class="owl-item position-relative overflow-hidden" style="background-image:  url(img/gallery/competitions/13/9.jpeg); background-size: cover; background-position: 60% 40%; background-position: 60% 40%;">
                    <div class="container position-relative z-index-3 h-100">
                        <div class="row align-items-center justify-content-center h-100">
                            <div class="col-lg-7">
                                <div class="d-flex flex-column justify-content-center align-items-center text-center h-100">
                                    <span class="position-relative text-color-light text-6 line-height-5 font-weight-medium custom-secondary-font pe-4 mb-0 " data-appear-animation="fadeInDownShorter" data-appear-animation-delay="500" data-plugin-options="{'minWindowWidth': 0}">
                                        Etapa 1 Ludus 19-20 Martie
                                    </span>
                                    <h1 class="text-color-light font-weight-extra-bold text-13 line-height-1 mb-2" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="750" data-plugin-options="{'minWindowWidth': 0}">Prima competitie a anului</h1>
                                    <p class="text-5 text-color-light font-weight-light custom-secondary-font mb-5 " data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1000">Vezi clasament si galeria de poze</p>
                                    <a href="{{url('/clasamentdata/2022-03-19')}}" class="btn btn-primary font-weight-bold btn-py-2 btn-px-4 " data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1250">Vezi mai mult</a> 
                                    <a class="text-5  text-color-light appear-animation"    data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1350" href="https://www.facebook.com/poligon.opristiberiu" target="_blank" title="Facebook">
                                    <i style="color:blue !important;" class="fab fa-facebook-f"></i>Facebook</a>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carousel Slide 2 -->
                <div class="owl-item position-relative overflow-hidden" style="background-image:   url(img/gallery/competitions/13/1.jpeg); background-size: cover; background-position: 60% 40%; background-position: 60% 40%;">
                    <div class="container position-relative z-index-3 h-100">
                        <div class="row align-items-center justify-content-center h-100">
                            <div class="col-lg-7">
                                <div class="d-flex flex-column justify-content-center align-items-center text-center h-100">
                                    <span class="position-relative text-color-light text-6 line-height-5 font-weight-medium custom-secondary-font pe-4 mb-0 appear-animation" data-appear-animation="fadeInDownShorter" data-appear-animation-delay="500" data-plugin-options="{'minWindowWidth': 0}">
                                        Etapa 1 Ludus 19-20 Martie
                                    </span>
                                    <h1 class="text-color-light font-weight-extra-bold text-13 line-height-1 mb-2 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="750" data-plugin-options="{'minWindowWidth': 0}">Prima competitie a anului</h1>
                                    <p class="text-5 text-color-light font-weight-light custom-secondary-font mb-5 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1000">Vezi clasament si galeria de poze</p>
                                    <a href="{{url('/clasamentdata/20220319')}}" class="btn btn-primary font-weight-bold btn-py-2 btn-px-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1250">Vezi mai mult</a> 
                                    <a class="text-5  text-color-light appear-animation"    data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1350" href="https://www.facebook.com/poligon.opristiberiu" target="_blank" title="Facebook">
                                    <i style="color:blue !important;" class="fab fa-facebook-f"></i>Facebook</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                           <!-- Carousel Slide 2 -->
                <div class="owl-item position-relative overflow-hidden" style="background-image:   url(img/gallery/competitions/13/71.jpeg); background-size: cover; background-position: 60% 40%; background-position: 60% 40%;">
                    <div class="container position-relative z-index-3 h-100">
                        <div class="row align-items-center justify-content-center h-100">
                            <div class="col-lg-7">
                                <div class="d-flex flex-column justify-content-center align-items-center text-center h-100">
                                    <span class="position-relative text-color-light text-6 line-height-5 font-weight-medium custom-secondary-font pe-4 mb-0 appear-animation" data-appear-animation="fadeInDownShorter" data-appear-animation-delay="500" data-plugin-options="{'minWindowWidth': 0}">
                                        Etapa 1 Ludus 19-20 Martie
                                    </span>
                                    <h1 class="text-color-light font-weight-extra-bold text-13 line-height-1 mb-2 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="750" data-plugin-options="{'minWindowWidth': 0}">Prima competitie a anului</h1>
                                    <p class="text-5 text-color-light font-weight-light custom-secondary-font mb-5 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1000">Vezi clasament si galeria de poze</p>
                                    <a href="{{url('/clasamentdata/20220319')}}" class="btn btn-primary font-weight-bold btn-py-2 btn-px-4 appear-animation mb-2" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1250">Vezi mai mult</a> 
                                    <a class="text-5  text-color-light appear-animation"    data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1350" href="https://www.facebook.com/poligon.opristiberiu" target="_blank" title="Facebook">
                                    <i style="color:blue !important;" class="fab fa-facebook-f"></i>Facebook</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="owl-nav">
            <button type="button" role="presentation" class="owl-prev"></button>
            <button type="button" role="presentation" class="owl-next"></button>
        </div>
    </div>
    



    <section class="section section-no-border bg-color-light m-0">
					<div class="container">
						<div class="row justify-content-center">
							<div class="col-lg-6 mb-4 mb-lg-0">
								<h2 class="font-weight-bold">Urmatorul eveniment</h2>


                                @if (isset($competitions) && isset($competitions[0]))
								<article class="thumb-info custom-thumb-info custom-box-shadow">
									<span class="thumb-info-wrapper">
                                    <div class="post-event-date bg-color-primary text-center">
										<span class="month text-uppercase custom-secondary-font text-color-light">{{$competitions[0]->Month}}</span>
										<span class="day font-weight-bold text-color-light">{{$competitions[0]->Day}}</span>
										<span class="year text-color-light">{{$competitions[0]->Year}}</span>
									</div>
									</span>
                                   
									<span class="thumb-info-caption">
										<span class="custom-event-infos">
											<ul>
												<li>
													<i class="far fa-clock"></i>
													 8:00 AM
												</li>
												<li class="text-uppercase">
													<i class="fas fa-map-marker-alt"></i>
													{{$competitions[0]->Range}}
												</li>
											</ul>
										</span>
										<span class="thumb-info-caption-text">
											<h4 class="font-weight-bold mb-2">
												<a href="{{url('/clasament/') .'/'.$competitions[0]->CompetitionId}}" class="text-decoration-none custom-secondary-font text-color-dark">
                                                    {{$competitions[0]->NumeLung}}
												</a>
											</h4>
											    <a href='{{$competitions[0]->Coordinates}}' target="_blank" class="a a__medium text-decoration-none">
                                                    <i class="fas fa-map-marker-alt text-color-primary custom-icon-size-1"></i>
                                                    Vezi harta
                                                    <p class="custom-text-color-2 alternative-font-4 text-3-5">
                                                        {{$competitions[0]->Address}}  {{$competitions[0]->Country}}
                                                    </p>

                                                </a>
                                                <i class="fas fa-phone-volume text-color-primary custom-icon-size-1"></i>
                                                <a href="tel:+" class="text-decoration-none custom-text-color-2">Telefon :  {{$competitions[0]->Phone}}</a></br>
                                                   

										</span>
									</span>

                                  <div class = "p-2">

                                    @switch($competitions[0]->Status)
                                        @case('Closed')
                                            <button id="btnUnRegister" class = "btn-register btn btn-danger btn-outline mb-2" >Inchis</button>
                                           
                                            @break
                                        @case('Open')


                                

                                        @if (session("PersonId"))
                                    
                                            @php 

                                                $exists = $competitions[0]->Inscris == '1';


                                            @endphp    
                                            @if ($exists)
                                                <button id="btnUnRegister" class = "btn-register btn btn-success btn-outline mb-2" >Sunt inregistrat</button>
                                            @else
                                                <button id="btnRegister" onclick="registerMe({{$competitions[0]->CompetitionId}});"  class = "btn-register btn btn-primary btn-outline mb-2" >Ma inscriu</button>
                                            @endif

                                        @else
                                            <button id="btnLogin" onclick="location.href='{{url('/login')}}';" class = "btn-register btn btn-secondary btn-outline mb-2" >Login pentru inscriere</button>      
                                            <button id="btnRegisterUser" onclick="location.href='{{url('/register')}}';" class = "btn-register btn btn-secondary btn-outline mb-2" >Inregistreaza-te daca nu ai cont</button>          
                                            
                                        @endif
                                        @break

                                    @case('Progress')     
                                            <button  class = "btn-register btn btn-danger btn-outline mb-2" >In progress</button>

                                        @break


                                    @case('Finished')
                                    
                                            <button  class = "btn-register btn btn-danger btn-outline mb-2" >Terminat</button>
                                        @break

                                    @endswitch
                                </div>




								</article>
                                @endif

							</div>
							<div class="col-lg-6">
								<h2 class="font-weight-bold">Evenimente viitoare</h2>


                                @foreach($competitions as $comp)
                                    @if ($loop->first)
                                       @continue
                                    @endif

								<article class="custom-post-event">
									<div class="post-event-date bg-color-primary text-center">
										<span class="month text-uppercase custom-secondary-font text-color-light">{{$comp->Month}}</span>
										<span class="day font-weight-bold text-color-light">{{$comp->Day}}</span>
										<span class="year text-color-light">{{$comp->Year}}</span>
									</div>
									<div class="post-event-content custom-margin-1">
										<span class="custom-event-infos">
											<ul>
												<li>
													<i class="far fa-clock"></i>
													8:00 AM
												</li>
												<li class="text-uppercase">
                                                    <a href='{{$comp->Coordinates}}' target="_blank" class="a a__medium text-decoration-none">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        {{$comp->Range}}
                                                    </a>
												</li>
                                                
                                                
											</ul>
										</span>
										<h4 class="font-weight-bold">
											<a href="{{url('/clasament/') .'/'.$comp->CompetitionId}}" class="text-decoration-none custom-secondary-font text-color-dark">	{{$comp->NumeLung}}</a>
										</h4>
										<p>{{$comp->Perioada}}</p>
									</div>
								</article>
								<hr class="solid">

                                @endforeach


								<a href="{{url('/competitii')}}" class="btn btn-primary custom-btn-style-1 text-uppercase custom-margin-1 mt-4">Toate competitiile</a>
							</div>
						</div>
					</div>
				</section>

                <section class="section section-secondary section-no-border m-0">
					<div class="container">
						<div class="row justify-content-center text-center custom-negative-margin-1">
							<div class="col">
								<div class="countdown custom-newcomers-class custom-secondary-font custom-box-shadow font-weight-bold text-color-dark" data-plugin-countdown data-plugin-options="{'date': '2022/01/01 12:00:00', 'numberClass': 'font-weight-bold text-color-primary', 'wrapperClass': 'text-color-dark line-height-4', 'insertHTMLbefore': 'Newcomers Class', 'textDay': 'Day', 'textHour': 'Hrs', 'textMin': 'Min', 'textSec': 'Sec', 'uppercase': false}"></div>
							</div>
						</div>
						<div class="row justify-content-center text-center">
							<div class="col-lg-4 col-sm-8 mb-4 mb-lg-0">
								<img src="i" alt class="img-repsonsive" />
								<a href="{{url('/regulamente')}}" class="text-decoration-none "><h2 class="font-weight-bold text-color-light">Regulamente</h2>
								<p class="custom-text-color-2">Sectiune in care dorim sa adunam regulamentele pentru disciplinele sportive legate de tirul vanatoresc</br> Fii un sportiv informat</p> </a>
							</div>
							<div class="col-lg-4 col-sm-8 mb-4 mb-lg-0">
								<img src="" alt class="img-repsonsive" />
								<a href="{{url('/clasamente')}}" class="text-decoration-none "><h2 class="font-weight-bold text-color-light">Clasamente</h2>
								<p class="custom-text-color-2">Clasamentele din anul curent si din anul precedent</br> </p></a>
							</div>
							<div class="col-lg-4 col-sm-8">
								<img src="" alt class="img-repsonsive" />
								<h2 class="font-weight-bold text-color-light">Alte informatii utile</h2>
								<a href="{{url('/poligoane')}}" class="text-decoration-none "><strong>Poligoane</strong><p class="custom-text-color-2">O lista de poligoane din Romania si alte tari </br> Informatii despre lolocalizare, contact</p></a>
                                <a href="{{url('/linkuri')}}" class="text-decoration-none "><strong>Linkuri utile</strong><p class="custom-text-color-2">O lista de linkuri catre situri utile pentru tirul vanatoresc</p></a>
							</div>
						</div>
					</div>
				</section>



				

				
                @if (!session("PersonId"))
				
                <section class="section section-tertiary section-no-border m-0">
					<div class="container">
						<div class="row align-items-center">
							<div class="col-lg-10">
								<span class="custom-secondary-font font-weight-bold custom-text-color-1 text-4">Esti vanator sau pasionat de tir vanatoresc</span>
								<h2 class="font-weight-bold custom-text-color-1 m-0">Descopera comunitatea noastra <span class="font-weight-normal custom-secondary-font custom-font-italic"></br>Hai cu noi!</span></h2>
							</div>
							<div class="col-lg-2 mt-4 mt-lg-0">
								<a href="{{Route('register')}}" class="btn btn-primary custom-btn-style-1 text-uppercase">Vreau sa ma inregistrez</a>
                  
                                <span class="arrow hlb d-none d-md-block appear-animation animated rotateInUpLeft appear-animation-visible" data-appear-animation="rotateInUpLeft" style="left: 100%; top: -32px; animation-delay: 100ms;"></span>
							</div>
						</div>
					</div>
				</section>

                @endif
                <div id = "marketingphoneall"  class="owl-carousel owl-carousel-light owl-carousel-light-init-fadeIn owl-theme manual dots-inside dots-horizontal-center show-dots-hover show-dots-xs show-dots-sm 
                 show-dots-md nav-inside nav-inside-edge show-nav-hover custom-carousel-arrows-style-1 m-1" data-plugin-options="{'autoplayTimeout': 5000}"  style="height: 8vh;">
                    <div class="owl-stage-outer">
                        <div class="owl-stage">

                        


                            @php

                                    $images = scandir("img/marketing/arrow");                     
                                    foreach ($images as $image){

                                        if (!in_array($image , ['.', '..'])){
                            @endphp
                                        
                                            <div class="owl-item position-relative overflow-hidden text-center">
                                              
                                                    <div class="container position-relative z-index-3 h-100">
                                                        <!-- <div class="col-lg-3 col-sm-8 mb-3 mb-lg-0" style=" max-width: 100%; height: auto;  overflow: hidden;"> -->
                                                            <a href="//www.arw.ro" target="_blank" style="display: inline-flex;    float: center;">  
                                                                <img style="    height: 8vh;
                        
                                                                float: center;
                                                                margin: 0px;
                                                                padding: 0px;" src=" {{url('img/marketing/arrow').'/'.$image}}">
                                                            </a>
                                                        <!-- </div> -->
                                                    </div>
                                               
                                            </div>
                                    
                                                                            
                            @php
                                        }
                                    }
                            @endphp
                          
                        </div>
                    </div>

                </div>


			

@endpush


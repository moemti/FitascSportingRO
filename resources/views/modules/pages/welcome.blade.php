@extends('layouts.baseex')

@push('footerscripts')


<script src="{{asset('js/pages/welcome.js')}}"></script>


@endpush


@push('content')

    <div class="container">
        <!-- <div class="announcement row alert alert-quaternary alert-sm justify-content-center"><a href="{{url('/regulamente')}}">{{transex('ATENTIE - Regulament intern 18-03-2022')}}</a></div>
         -->
    </div>

    <div class="owl-carousel owl-carousel-light owl-carousel-light-init-fadeIn_ owl-theme manual dots-inside dots-horizontal-center show-dots-hover show-dots-xs show-dots-sm show-dots-md full-width nav-inside nav-inside-edge show-nav-hover custom-carousel-arrows-style-1 mb-0" data-plugin-options="{'autoplayTimeout': 9000000}" 
                data-dynamic-height="['600px','600px','600px','500px','500px']" style="height: 40vh;">
        <div class="owl-stage-outer">
            <div class="owl-stage">

                @php
                       $current = getCurrentCompetition();
                @endphp

                <!-- Carousel Slide 1 -->

                @foreach ($current as $cur)
                    @php
                        if (isset($cur->Image))
                            $image = "img/gallery/competitions/".$cur->CompetitionId."/".$cur->Image;
                        else   
                            $image = "img/gallery/competitions/13/12.jpeg";
                    @endphp


                    <div class="owl-item position-relative overflow-hidden" style="background-image:  url('{{$image}} '); background-size: cover; background-position: 60% 40%; background-position: 60% 40%;">
                        <div class="container position-relative z-index-3 h-100">
                            <div class="row align-items-center justify-content-center h-100">
                                <div class="col-lg-7">
                                    <div class="d-flex flex-column justify-content-center align-items-center text-center h-100">
                                        <h1 class="text-color-light welcome-text font-weight-extra-bold text-13 line-height-1 mb-2 welcome-text " data-appear-animation="fadeInUpShorter" data-appear-animation-delay="750" data-plugin-options="{'minWindowWidth': 0}">

                                        @if (isset($cur->CompetitionId)) 
                                              {{transex('Competitiile continua')}}
                                        @else
                                               {{transex($cur->NumeSuperLung)}}
                                        @endif
                                        </h1>

                                        @if (isset($cur->CompetitionId)) 

                                            <p class="text-5 text-color-light font-weight-light custom-secondary-font mb-5 " data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1000">
                                                {{transex($cur->Mesaj)}}
                                            </p>
                                            <span class="position-relative text-color-light text-6 line-height-5 font-weight-medium custom-secondary-font pe-4 mb-0 welcome-text " data-appear-animation="fadeInDownShorter" data-appear-animation-delay="500" data-plugin-options="{'minWindowWidth': 0}">
                                                    {{$cur->NumeSuperLung}}
                                            </span>

                                            <a href="{{url('/clasament/'.$cur->CompetitionId)}}" class="btn btn-primary font-weight-bold btn-py-2 btn-px-4 " data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1250">{{transex('Vezi mai mult')}}</a> 
                                        @else
                                            <a href="{{url('/competitii')}}" class="btn btn-primary custom-btn-style-1 text-uppercase">{{transex('Toate competitiile')}}</a>
                                        @endif

                                        @if(isset($cur->CompetitionId)) 
                                            @php
                                                $attachments = getCompetitionAttachments($cur->CompetitionId);
                                            @endphp  

                                                @foreach($attachments as $att)

                                                        <a class="text-5  text-color-light appear-animation btn "    data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1350" href="{{url('/competitionattachment/'.$att->CompetitionattachId)}}" target="_blank" title="{{transex($att->Name)}}">

                                                       <p style ="color: blue !important;
                                                                text-shadow: rgb(256, 256, 256) -1px 1px !important;
                                                                background: rgba(256,256,256,0.4); "> {{transex($att->Name)}}</p>
                                                        </a>
                                                @endforeach


                                        @endif

                                        @if (isset($cur->Link))
                                            <a class="text-5  text-color-light appear-animation"    data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1350" href="{{$cur->Link}}" target="_blank" title="Facebook">
                                            <i style="color:blue !important;" class="fab fa-facebook-f"></i>Facebook</a> 
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    



    <section class="section section-no-border bg-color-light m-0">
					<div class="container">
						<div class="row justify-content-center">
							<div class="col-lg-6 mb-4 mb-lg-0">
								<h2 class="font-weight-bold">{{transex('Urmatorul eveniment')}}</h2>


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
                                                    {{transex('Vezi harta')}}
                                                    <p class="custom-text-color-2 alternative-font-4 text-3-5">
                                                        {{$competitions[0]->Address}}  {{$competitions[0]->Country}}
                                                    </p>

                                                </a>
                                                <i class="fas fa-phone-volume text-color-primary custom-icon-size-1"></i>
                                                <a href="tel:+" class="text-decoration-none custom-text-color-2">{{transex('Telefon')}} :  {{$competitions[0]->Phone}}</a></br>
                                                   

										</span>

                                        @php
                                            $attachments = getCompetitionAttachments($competitions[0]->CompetitionId);
                                        @endphp  

                                        @foreach($attachments as $att)
                                            <span class="thumb-info-caption-text">
                                                <a class="text-2  text-color-light  btn "  href="{{url('/competitionattachment/'.$att->CompetitionattachId)}}" target="_blank" title="{{transex($att->Name)}}">

                                                <p style ="color: blue !important;
                                                        text-shadow: rgb(256, 256, 256) -1px 1px !important;
                                                        background: rgba(256,256,256,0.4); "> {{transex($att->Name)}}</p>
                                                </a>
                                                </span>
                                        @endforeach
									</span>

                                  <div class = "p-2">
                                    @switch($competitions[0]->Status)
                                        @case('Closed')
                                            <button id="btnUnRegister" class = "btn-register btn btn-danger btn-outline mb-2" >{{transex('Inchis')}}</button>
                                           
                                            @break
                                        @case('Open')

                                        @if (session("PersonId"))
                                            @php 
                                                $exists = $competitions[0]->Inscris == '1';
                                            @endphp    
                                            
                                            @if ($exists)
                                                <button id="btnUnRegister" class = "btn-register btn btn-success btn-outline mb-2" >{{transex('Sunt inregistrat')}}</button>
                                            @else
                                                <button id="btnRegister" onclick="registerMe({{$competitions[0]->CompetitionId}});"  class = "btn-register btn btn-primary btn-outline mb-2" >{{transex('Ma inscriu')}}</button>
                                            @endif

                                        @else
                                            <button id="btnLogin" onclick="location.href='{{url('/login')}}';" class = "btn-register btn btn-secondary btn-outline mb-2" >{{transex('Login pentru inscriere')}}</button>      
                                            <button id="btnRegisterUser" onclick="location.href='{{url('/register')}}';" class = "btn-register btn btn-secondary btn-outline mb-2" >{{transex('Inregistreaza-te daca nu ai cont')}}</button>          
                                            
                                        @endif
                                        @break

                                    @case('Progress')     
                                            <button  class = "btn-register btn btn-danger btn-outline mb-2" >{{transex('In progress')}}</button>

                                        @break


                                    @case('Finished')
                                    
                                            <button  class = "btn-register btn btn-danger btn-outline mb-2" >{{transex('Terminat')}}</button>
                                        @break

                                    @endswitch
                                </div>




								</article>
                                @endif

							</div>
							<div class="col-lg-6">
								<h2 class="font-weight-bold">{{transex('Evenimente viitoare')}}</h2>


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


								<a href="{{url('/competitii')}}" class="btn btn-primary custom-btn-style-1 text-uppercase custom-margin-1 mt-4">{{transex('Toate competitiile')}}</a>
							</div>
						</div>
					</div>
				</section>

                <section class="section section-secondary section-no-border m-0">
					<div class="container">
					
						<div class="row justify-content-center text-center">
							<div class="col-lg-4 col-sm-8 mb-4 mb-lg-0">
								<img src="i" alt class="img-repsonsive" />
								<a href="{{url('/regulamente')}}" class="text-decoration-none "><h2 class="font-weight-bold text-color-light">{{transex('Regulamente')}}</h2>
								<p class="custom-text-color-2">{{transex('Sectiune in care dorim sa adunam regulamentele pentru disciplinele sportive legate de tirul vanatoresc')}}</br> {{transex('Fii un sportiv informat')}}</p> </a>
							</div>
							<div class="col-lg-4 col-sm-8 mb-4 mb-lg-0">
								<img src="" alt class="img-repsonsive" />
								<a href="{{url('/clasamente')}}" class="text-decoration-none "><h2 class="font-weight-bold text-color-light">{{transex('Clasamente')}}</h2>
								<p class="custom-text-color-2">{{transex('Clasamentele din anul curent si din anul precedent')}}</br> </p></a>
							</div>
							<div class="col-lg-4 col-sm-8">
								<img src="" alt class="img-repsonsive" />
								<h2 class="font-weight-bold text-color-light">{{transex('Alte informatii utile')}}</h2>
								<a href="{{url('/poligoane')}}" class="text-decoration-none "><strong>{{transex('Poligoane')}}</strong><p class="custom-text-color-2">{{transex('O lista de poligoane din Romania si alte tari')}} </br> {{transex('Informatii despre lolocalizare, contact')}}</p></a>
                                <a href="{{url('/utile')}}" class="text-decoration-none "><strong>{{transex('Linkuri utile')}}</strong><p class="custom-text-color-2">{{transex('O lista de linkuri catre situri utile pentru tirul vanatoresc')}}</p></a>
							</div>
						</div>
					</div>
				</section>



				

				
                @if (!session("PersonId"))
				
                <section class="section section-tertiary section-no-border m-0">
					<div class="container">
						<div class="row align-items-center">
							<div class="col-lg-10">
								<span class="custom-secondary-font font-weight-bold custom-text-color-1 text-4">{{transex('Esti vanator sau pasionat de tir vanatoresc')}}</span>
								<h2 class="font-weight-bold custom-text-color-1 m-0">{{transex('Descopera comunitatea noastra')}} <span class="font-weight-normal custom-secondary-font custom-font-italic"></br>{{transex('Hai cu noi!')}}</span></h2>
							</div>
							<div class="col-lg-2 mt-4 mt-lg-0">
								<a href="{{Route('register')}}" class="btn btn-primary custom-btn-style-1 text-uppercase">{{transex('Vreau sa ma inregistrez')}}</a>
                  
                                <span class="arrow hlb d-none d-md-block appear-animation animated rotateInUpLeft appear-animation-visible" data-appear-animation="rotateInUpLeft" style="left: 100%; top: -32px; animation-delay: 100ms;"></span>
							</div>
						</div>
					</div>
				</section>

                @endif
                


			

@endpush


@stack('header_start')
 <div class="app-header header-shadow">
    
        <div class="app-header__logo">
            <div class="logo-src">
                <div class="logo" style="margin-top:-100px;margin-top: -30px;">
                        <a href="{{url('/')}}"> <img src="{{url('assets/images/logo_molland.svg')}}"  height="87" width="100" > </a>
                 

                </div>
            </div>
            <div class="header__pane ml-auto">
                <div>
                    <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="app-header__mobile-menu">
            <div>
                <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
        <div class="app-header__menu">
            <span>
                <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                    <span class="btn-icon-wrapper">
                        <i class="fa fa-ellipsis-v fa-w-6"></i>
                    </span>
                </button>
            </span>
        </div>

   

        <div class="app-header__content">
            <div>
                <button class="mb-0 ml-4 mr-2 btn btn-gradient-info active">@session(organization)</button>
            </div>
            
            <div class="app-header-right">
                <div class="header-dots">

                    <div class="dropdown mr-n4 mb-n3">
                        
                        <button class=" btn-icon btn-pill btn btn-outline-link" data-toggle="dropdown">
                            <i class=" btn-icon-wrapper language-icon flag medium {{Cookie::get('lang-symbol')}}"> </i>
                        </button>
                        <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu dropdown-menu-right">
                            <div class="dropdown-menu-header">
                                <div class="dropdown-menu-header-inner pt-4 pb-4 bg-focus">
                                    <div class="menu-header-image opacity-05" style="background-image: url('assets/images/dropdown-header/city2.jpg');"></div>
                                    <div class="menu-header-content text-center text-white">
                                        <h6 class="menu-header-subtitle mt-0">
                                            Choose Language
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <h6 tabindex="-1" class="dropdown-header">
                                Languages
                            </h6>

                            @include('partials.admin.languages')

                        </div>
                    </div>

                </div>

                <div class="header-btn-lg pr-0">
                    <div class="widget-content p-0" id="headuser">

                 	@include('partials.admin.loginheader')

                    </div>
                </div>
                <div class="header-btn-lg">
                    <button type="button" class="hamburger hamburger--elastic open-right-drawer">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

@stack('header_end')

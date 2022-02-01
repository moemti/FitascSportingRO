		@push('footerjs')

		<script src={{asset("/assets/scripts/modules/auth/auth.js")}}></script>

		@endpush


		<div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="btn-group">
                                @if (session("PersonId") > 0)
                                    <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn mt-3">
                                 @else
                                    <a class="p-0 btn mt-3" href = "{{url('/login')}}" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Login">

                                  

                                 @endif  

                                    <div class="font-icon-wrapper font-icon-md"> 
                                        <i class="lnr-user icon-gradient bg-ripe-malin"> </i>
                                        @if (session("PersonId") > 0)
                                        <i class="fa fa-angle-down opacity-8"></i>
                                           
                                        @if (session("IsSuperUser") == 1)
                                            <button class="mb-0 mr-2 mt-0 ml-4 btn-icon btn-shadow btn-dashed btn btn-outline-danger">
                                            <i class="lnr-magic-wand btn-icon-wrapper"> </i>Super user</button>                      
                                        @endif

                                        @endif
                                        </div>

                                    </a>

                                    
                                    <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
                                        <div class="dropdown-menu-header">
                                            <div class="dropdown-menu-header-inner bg-info">
                                                <div class="menu-header-image opacity-2" style="background-image: url('assets/images/dropdown-header/city3.jpg');"></div>
                                                <div class="menu-header-content text-left">
                                                    <div class="widget-content p-0">
                                                        <div class="widget-content-wrapper">
                                                        @if (session("PersonId") > 0)
                                                            <div class="widget-content-left mr-3">
                                                            <div class="font-icon-wrapper font-icon-lg"><i class="lnr-user icon-gradient bg-ripe-malin"> </i></div>
                                                            </div>
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">@session(name)
                                                                </div>
                                                                @if (session("IsSuperUser") == 1)
                                                               
                                                                
                                                                    <button class="btn-icon-vertical  btn btn-outline-danger">
                                                                        <i class="lnr-magic-wand btn-icon-wrapper"> </i>Super user
                                                                    </button>

                                                                @endif
                                                                <div class="widget-subheading opacity-8">@session(function), @session(organization)
                               									</div>
                                                            </div>
                                                            <div class="widget-content-right mr-2">
                                                                <button id="logoutbutton" class="btn-pill btn-light btn btn-focus active" >Logout
                                                                </button>
                                                            </div>
                                                            @else
                                                            <div class="widget-content-right mr-2">
                                                                <button id="loginbutton" class="mb-2 mr-2 btn-icon btn-pill btn btn-primary"><i class="lnr-user btn-icon-wrapper"> </i>Login</button>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        @if (session("PersonId") > 0)
                                        <div class="scroll-area-xs" style="height: 170px;">
                                            <div class="scrollbar-container ps">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item-header nav-item">Activity
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="javascript:void(0);" class="nav-link">My rank
                                                            <div class="ml-auto badge badge-pill badge-info">B
                                                            </div>
                                                        </a>
                                                    </li>
                                                    
                                                    <li class="nav-item-header nav-item">My Account
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="{{url('/userperson')}}" class="nav-link">My profile
                                                            <div class="ml-auto badge badge-success">Profile
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="{{url('/changemypass')}}" class="nav-link">Change password
                                                            <div class="ml-auto badge badge-danger">Password
                                                            </div>
                                                        </a>
                                                    </li>
                                                
                                                </ul>
                                            </div>
                                        </div>
                                        @endif
                                        
                                    </div>
                                  
                                </div>
                            </div>

                            @if (session("PersonId") > 0)
                            <div class="widget-content-left  ml-3 header-user-info">
                                <div class="widget-heading">
                                    @session(username)
                                </div>

                                <div class="widget-subheading">
                                    @session(function)
                                </div>

                            </div>
                            @endif

        </div>

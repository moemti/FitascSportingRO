@php 
      $menus = config('navigation.MENU') 

@endphp


<div class="navigation">

       
        <div class="navigation__content">
     
                
        @php
                foreach($menus as $menu){
        @endphp

               
                @if ((count($menu) === 2) || (($menu[2] == 'super') && (session('IsSuperUser') == 1) ) )
                        @if (is_array($menu[0]))
                                <div class="menu_container">
                                 <a href='#' class="navmenu">{{$menu[1]}}</a>
                               
                                @php
                                        foreach($menu[0] as $submenu){
                                @endphp
                                <div class="submenu">
                                         <a href={{url($submenu[0])}} class="navmenu">{{$submenu[1]}}</a> 
                                </div>

                                @php
                                        }
                                @endphp 


                                </div>  
                        @else

                            <a href={{url($menu[0])}} class="navmenu">{{$menu[1]}}</a>
                        @endif
                        
                @endif

        @php
                }
        @endphp      

        </div>

        <input type="checkbox" class="navigation__checkbox" class="form-check-input"  id="navi-toggle">

        <label for="navi-toggle" class="navigation__button">
        <span class="navigation__icon">&nbsp;</span>
        </label>

        <div class="navigation__background">&nbsp;

        </div>
        <div class="navigation__nav">
                <ul class="navigation__list">

                @php
                        foreach($menus as $menu){
                @endphp
                        <li class="navigation__item ">
                      
                                @if ((count($menu) === 2) || (($menu[2] == 'super') && (session('IsSuperUser') == 1) ) )

                                @if (is_array($menu[0]))
                                         <div class="navmenu">{{$menu[1]}}



                                         </div> 
                                @else  

                                        <a href="{{url($menu[0])}}" class="navmenu navigation__link">{{$menu[1]}} </a>
                                @endif

                                @endif

                        </li>
                @php
                        }
                @endphp  
                </ul>

        </div>

</div>


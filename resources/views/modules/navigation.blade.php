@php 
      $menus = config('navigation.MENU') 

@endphp


<div class="navigation">

       
        <div class="navigation__content">
     
                
        @php
                foreach($menus as $menu){
        @endphp

                <a href={{url($menu[0])}} class="navmenu">{{$menu[1]}}</a>
              
                
        @php
                }
        @endphp      

        </div>

        <input type="checkbox" class="navigation__checkbox"  id="navi-toggle">

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
                                <a href="{{url($menu[0])}}" class="navmenu navigation__link">{{$menu[1]}}</a>
                        </li>
                @php
                        }
                @endphp  
                </ul>

        </div>

</div>


@php 
echo "<script> var navigation = ";
echo json_encode(Session::get('navhistory'));
echo "; </script>"
@endphp


@stack('menu_start')



           	<div class="app-sidebar sidebar-shadow">
                <div class="app-header__logo">
                    <div class="logo-src"></div>
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
                

                <div class="scrollbar-sidebar">
                    <div class="app-sidebar__inner">
                        <ul class="vertical-nav-menu">

                          <!--  
                            <li>
                                <div id= 'searchedit'class="search-wrapper">
                                    <div class="input-holder">
                                    
                                        <input id="menusearch" type="text" class="search-input" placeholder="Type to search">
                                        <button class="search-icon"><span></span></button>
                                       
                                    </div>
                                    
                                </div>

                                <ul id = "allmenus_ul">

                                </ul> 
                             
                            
                            </li>

                            


                            <li class="app-sidebar__heading">{{trans('menu.menuhistory')}}</li>
                            <li>
                              

                                <a class="" href="#">
                                    <i class="metismenu-icon pe-7s-diamond"></i>
                                    {{trans('menu.lastmenus')}}
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                                <ul id = "lastmenus_ul">
                             
                                </ul>
                            </li>
                            -->
                            <li class="app-sidebar__heading"> 
                                    <i class="metismenu-icon pe-7s-keypad"></i>
                                    @MainMenu(welcome, menu.dashboard)
                            </li>

                            
                            @if (session("PersonId") > 0)

                            <li class="app-sidebar__heading"> {{trans('menu.competitions')}}</li>

                                @Menu(competitions, menu.competitions, '',) 
                               {{-- @Menu(compresults, menu.compresults,  '',) --}}      


                            <li class="app-sidebar__heading"> {{trans('menu.trainings')}}</li>
                                @Menu(trainings, menu.mytrainings,mytrainings,)
                                @Menu(training25s, menu.training25,training25,)


                                             


                            <li class="app-sidebar__heading"> {{trans('menu.finance')}}</li>
                                @Menu(training25finance, menu.training25finance,training25finance, )


                            @endif


                            @if (session("IsSuperUser") == 1)

                                <li class="app-sidebar__heading"> {{trans('menu.dictionaries')}}</li>

                               
                                        <li>
                                        <a class="" href="#">
                                                <i class="metismenu-icon pe-7s-user"></i>
                                                {{trans('menu.users')}}
                                                <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                            </a>
                                            <ul>
                                                @Menu(roles, menu.roles,roles,)
                                                @Menu(persons, menu.persons,persons,)
                                                @Menu(users, menu.users,users,)
                                            </ul>
                                        </li>
                                        <li>
                                        <a class="" href="#">
                                                <i class="metismenu-icon pe-7s-user"></i>
                                                {{trans('menu.security')}}
                                                <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                            </a>
                                            <ul>
                                                @Menu(permissions, menu.permissions,permissions,)
                                              
                                            </ul>
                                        </li>
                                 
                            @endif    
                                
                            @if (session("PersonId") > 0)
                            <li class="app-sidebar__heading">{{trans('menu.reports')}}</li>
                             
                           
                            
                            <li class="app-sidebar__heading_mol"> 

                                @if (session("IsSuperUser") == 1)

                                     <a class="" href="#">
                                        <i class="metismenu-icon pe-7s-car"></i>
                                        {{trans('menu.settings')}}
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul>
                                        @Menu(reportcategories, menu.reportcategories,reportcategories,)
                                        @Menu(reportdefinitions, menu.reportdefinitions,reportdefinitions,)
                                       
                                    </ul>

                                 @endif  
                                </li>

                                @Menu(reportsrun, menu.reportsrun,reportsrun,)
                           
                            @endif

                        </ul>
                    </div>
                </div>
            </div>
@stack('menu_end')


<script>
$(document).ready(function() {

    // punem istoricul 


    if (navigation)
        navigation.forEach(function(item, index){
            i = $('a[href="'+ item.Location  + '"]').clone();
            i.addClass('history');
            i.appendTo($("#lastmenus_ul"));
        });

    // punem toate meniurile

    i = $('.sidemenu').not('.history').closest('li').clone().addClass('searchmenu');;
    i.appendTo($("#allmenus_ul"));


    // Search wrapper trigger

    putMenuEvents();
   

});




function putMenuEvents(){
        $('#menusearch').on('keyup', function(event){
            var sea = $('#menusearch').val();
            filterMenu(sea);
    
        });

        setTimeout(function () {
            $(".vertical-nav-menu").metisMenu({onTransitionEnd:CloseSearch});
            filterMenu($('#menusearch').val()); 
        }, 100);

        

        $('.search-icon').click(SearchClick);

    }

    function CloseSearch(){
        $('#searchedit').removeClass('active');
        $('#menusearch').val('');
        $('#allmenus_ul').height('auto');
        filterMenu('');

    }

    function SearchClick() {
            if ($(this).parent().parent().hasClass('active')){
                $(this).parent().parent().removeClass('active');
               
                // punem si evenimentele inapoi
               // putMenuEvents();
                
            }
            else{
             
                $(this).parent().parent().addClass('active');
                $('#menusearch').focus();
               
            }

            filterMenu($('#menusearch').val()); 
        }

    function filterMenu(val){
        if  (val == ''){
            $('#allmenus_ul').removeClass('mm-show');
            $('#allmenus_ul').addClass('mm-collapse');
        }
            
        else{    
            $('#allmenus_ul').addClass('mm-show');
            $('#allmenus_ul').removeClass('mm-collapse');
        }
        // $('.vertical-nav-menu').find('a .searchmenu').attr('aria-expanded', "true");

        // $('.vertical-nav-menu').find('.mm-collapse').addClass('mm-show');
        // $('.sidemenu').addClass('mm-active').attr('hidden','true');
        // $('.sidemenu').parents('li').addClass('mm-active');
        
        $('.searchmenu').each(function(){
            if ($(this).text().toUpperCase().search(val.toUpperCase()) != -1) 
                $(this).removeAttr('hidden','false')
            else    
                $(this).attr('hidden','true')

        });
        
       

    }   
</script>

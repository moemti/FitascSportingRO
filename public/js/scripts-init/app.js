// Demo Theme Options

var lastMenu = "";

$(function () {


    //    $('.btn-open-options').click(function () {
            //$('.ui-theme-settings').toggleClass('settings-open');
        //});
    
        $('.close-sidebar-btn').click(function () {
    
            var classToSwitch = $(this).attr('data-class');
            var containerElement = '.app-container';
            $(containerElement).toggleClass(classToSwitch);
    
            var closeBtn = $(this);
    
            if (closeBtn.hasClass('is-active')) {
                closeBtn.removeClass('is-active');
            } else {
                closeBtn.addClass('is-active');
            }
            
            if ($('.footer-dots').hasClass('small')) {
                $('.footer-dots').removeClass('small');
            } else {
                $('.footer-dots').addClass('small');
            }
            
        });
    
        $('.switch-container-class').on('click', function () {
    
            var classToSwitch = $(this).attr('data-class');
            var containerElement = '.app-container';
            $(containerElement).toggleClass(classToSwitch);
    
            $(this).parent().find('.switch-container-class').removeClass('active');
            $(this).addClass('active');
    
        });
    
        $('.switch-theme-class').on('click', function () {
    
            var classToSwitch = $(this).attr('data-class');
            var containerElement = '.app-container';
    
            if (classToSwitch == 'app-theme-white') {
                $(containerElement).removeClass('app-theme-gray');
                $(containerElement).addClass(classToSwitch);
            }
    
            if (classToSwitch == 'app-theme-gray') {
                $(containerElement).removeClass('app-theme-white');
                $(containerElement).addClass(classToSwitch);
            }
    
            if (classToSwitch == 'body-tabs-line') {
                $(containerElement).removeClass('body-tabs-shadow');
                $(containerElement).addClass(classToSwitch);
            }
    
            if (classToSwitch == 'body-tabs-shadow') {
                $(containerElement).removeClass('body-tabs-line');
                $(containerElement).addClass(classToSwitch);
            }
    
            $(this).parent().find('.switch-theme-class').removeClass('active');
            $(this).addClass('active');
    
        });
    
        $('.switch-header-cs-class').on('click', function () {
            var classToSwitch = $(this).attr('data-class');
            var containerElement = '.app-header';
    
            $('.switch-header-cs-class').removeClass('active');
            $(this).addClass('active');
    
            $(containerElement).attr('class', 'app-header');
            $(containerElement).addClass('header-shadow ' + classToSwitch);
            
            createCookie('.app-header', 'header-shadow ' + classToSwitch, 20000);
            
            
    
        });
    
        $('.switch-sidebar-cs-class').on('click', function () {
            
            var classToSwitch = $(this).attr('data-class');
            var containerElement = '.app-sidebar';
    
            $('.switch-sidebar-cs-class').removeClass('active');
            $(this).addClass('active');
    
            $(containerElement).attr('class', 'app-sidebar');
            $(containerElement).addClass('sidebar-shadow ' + classToSwitch);
    
            $('.app-main__inner').attr('class', 'app-main__inner');
            $('.app-main__inner').addClass('sidebar-shadow ' + classToSwitch);
    
            createCookie('.app-sidebar', 'sidebar-shadow ' + classToSwitch, 20000);
    
        });
    });
    
    
    


 	function createCookie(name, value, expires) {
        var cookie = name + "=" + value.replace(';', '##_##') + ";";

        if (expires) {
            // If it's a date
            if(expires instanceof Date) {
            // If it isn't a valid date
            	if (isNaN(expires.getTime()))
            		expires = new Date(new Date().getTime() + parseInt(expires) * 1000 * 60 * 60 * 24);
            }
            else
            	expires = new Date(new Date().getTime() + parseInt(expires) * 1000 * 60 * 60 * 24);

            cookie += "expires=" + expires.toGMTString() + ";";
        }


        cookie += "path=/;";


        document.cookie = cookie;
    }


    function getCookie(name) {
        var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for(var i=0;i < ca.length;i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1,c.length);
                if (c.indexOf(nameEQ) == 0)
                    return c.substring(nameEQ.length,c.length).replace('##_##', ';');
            }

        return null;


    }


    function filterMenu(val){
        $('.vertical-nav-menu').find('a').attr('aria-expanded', "true");

        $('.vertical-nav-menu').find('.mm-collapse').addClass('mm-show');
        $('.sidemenu').addClass('mm-active').attr('hidden','true');
        $('.sidemenu').parents('li').addClass('mm-active');
        
        $('.sidemenu').each(function(){
            if ($(this).text().search(val) != -1) 
            $(this).removeAttr('hidden','false');

        });
        
       

    }



$( document ).ready(function() {




    // $('.search-wrapper .close').click(function () {

    //     $(this).parent().removeClass('active');
    // });

    // BS4 Popover

    $('[data-toggle="popover-custom-content"]').each(function (i, obj) {

        $(this).popover({
            html: true,
            placement: 'auto',
            template: '<div class="popover popover-custom" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
            content: function () {
                var id = $(this).attr('popover-id');
                return $('#popover-content-' + id).html();
            }
        });

    });

    // Stop Bootstrap 4 Dropdown for closing on click inside

    $('.dropdown-menu').on('click', function (event) {
        var events = $._data(document, 'events') || {};
        events = events.click || [];
        for (var i = 0; i < events.length; i++) {
            if (events[i].selector) {

                if ($(event.target).is(events[i].selector)) {
                    events[i].handler.call(event.target, event);
                }

                $(event.target).parents(events[i].selector).each(function () {
                    events[i].handler.call(this, event);
                });
            }
        }
        event.stopPropagation(); //Always stop propagation
    });


    $('[data-toggle="popover-custom-bg"]').each(function (i, obj) {

        var popClass = $(this).attr('data-bg-class');

        $(this).popover({
            trigger: 'focus',
            placement: 'top',
            template: '<div class="popover popover-bg ' + popClass + '" role="tooltip"><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
        });

    });

    $(function () {
        $('[data-toggle="popover"]').popover();
    });

    $('[data-toggle="popover-custom"]').each(function (i, obj) {

        $(this).popover({
            html: true,
            container: $(this).parent().find('.rm-max-width'),
            content: function () {
                return $(this).next('.rm-max-width').find('.popover-custom-content').html();
            }
        });
    });

    $('body').on('click', function (e) {
        $('[rel="popover-focus"]').each(function () {
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });

    $('.header-megamenu.nav > li > .nav-link').on('click', function (e) {
        $('[data-toggle="popover-custom"]').each(function () {
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });

    // BS4 Tooltips

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    $(function () {
        $('[data-toggle="tooltip-light"]').tooltip({
            template: '<div class="tooltip tooltip-light"><div class="tooltip-inner"></div></div>'
        });
    });

    // Drawer

    $('.open-right-drawer').click(function () {
        if ($(this).hasClass('is-active')){
            $('.app-drawer-overlay').addClass('d-none');
            $('.app-drawer-wrapper').removeClass('drawer-open');
            $('.open-right-drawer').removeClass('is-active');
        }
        else{
            $(this).addClass('is-active');
            $('.app-drawer-wrapper').addClass('drawer-open');
            $('.app-drawer-overlay').removeClass('d-none');
        }
    });

    $('.drawer-nav-btn').click(function () {
        $('.app-drawer-wrapper').removeClass('drawer-open');
        $('.app-drawer-overlay').addClass('d-none');
        $('.open-right-drawer').removeClass('is-active');
    });

    $('.app-drawer-overlay').click(function () {
        $(this).addClass('d-none');
        $('.app-drawer-wrapper').removeClass('drawer-open');
        $('.open-right-drawer').removeClass('is-active');
    });

    $('.mobile-toggle-nav').click(function () {
        $(this).toggleClass('is-active');
        $('.app-container').toggleClass('sidebar-mobile-open');

    });

    $('.mobile-toggle-header-nav').click(function () {
        $(this).toggleClass('active');
        $('.app-header__content').toggleClass('header-mobile-open');
    });

    $('.mobile-app-menu-btn').click(function () {
        $('.hamburger', this).toggleClass('is-active');
        $('.app-inner-layout').toggleClass('open-mobile-menu');

    });

    // Responsive

    $(window).on('resize', function(){
        var win = $(this);
        if (win.width() < 1250) {
            $('.app-container').addClass('closed-sidebar-mobile closed-sidebar');

        }
        else
        {
            $('.app-container').removeClass('closed-sidebar-mobile closed-sidebar');

        }

        if (win.width() < 1250 && win.width() > 991.98) {
        	 $('.footer-dots').addClass('small');
        }
        else{
        	 $('.footer-dots').removeClass('small');
        }



       if (win.width() < 991.98) {
        	$(".molactionbutton").css("padding", "0");
       }
       else{
    	   $(".molactionbutton").css("padding", "10px");
       }
    });


	// buton logout


	// pune activ meniul parent al meniului curent activ
	$('.scrollbar-sidebar').find('.mm-active').parents('li').addClass('mm-active');


	// luam setarile de thema
		// header
	var classToSwitch  = getCookie('.app-header');
    $('.app-header').attr('class', 'app-header');
    $('.app-header').addClass('header-shadow ' + classToSwitch);

    	// sidebar
	classToSwitch  = getCookie('.app-sidebar');
    $('.class').attr('class', 'app-sidebar');
    $('.app-sidebar').addClass('sidebar-shadow ' + classToSwitch);
    $('.app-main__inner').addClass('sidebar-shadow ' + classToSwitch);



});



$(window).on("load",function(){
  $('body').addClass('loaded');
});



var i = -1;
var toastCount = 0;
var $toastlast;

function ShowSuccess(msg) {


    var title = '';
    var toastIndex = toastCount++;

    toastr.options = {
    		closeButton: false,
    		debug: false,
    		extendedTimeOut: 1000,
    		hideDuration: 1000,
    		hideEasing: "linear",
    		hideMethod: "fadeOut",
    		newestOnTop: false,
    		onclick: null,
    		positionClass: "toast-top-center",
    		preventDuplicates: false,
    		progressBar: false,
    		rtl: false,
    		showDuration: 300,
    		showEasing: "swing",
    		showMethod: "fadeIn",
    		timeOut: 3000,

    };
    var $toast = toastr["success"](msg, title); // Wire up an event handler to a button in the toast, if it exists
    $toastlast = $toast;
    if(typeof $toast === 'undefined'){
        return;
    }

}


function ShowMessage(msg) {


    var title = '';
    var toastIndex = toastCount++;

    toastr.options = {
    		closeButton: false,
    		debug: false,
    		extendedTimeOut: 1000,
    		hideDuration: 1000,
    		hideEasing: "linear",
    		hideMethod: "fadeOut",
    		newestOnTop: false,
    		onclick: null,
    		positionClass: "toast-top-center",
    		preventDuplicates: false,
    		progressBar: false,
    		rtl: false,
    		showDuration: 300,
    		showEasing: "swing",
    		showMethod: "fadeIn",
    		timeOut: 3000,

    };
    var $toast = toastr["info"](msg, title); // Wire up an event handler to a button in the toast, if it exists
    $toastlast = $toast;
    if(typeof $toast === 'undefined'){
        return;
    }

}

function ShowError(msg) {


    var title = '';
    var toastIndex = toastCount++;

    toastr.options = {
    		closeButton: false,
    		debug: false,
    		extendedTimeOut: 1000,
    		hideDuration: 1000,
    		hideEasing: "linear",
    		hideMethod: "fadeOut",
    		newestOnTop: false,
    		onclick: null,
    		positionClass: "toast-top-center",
    		preventDuplicates: false,
    		progressBar: false,
    		rtl: false,
    		showDuration: 300,
    		showEasing: "swing",
    		showMethod: "fadeIn",
    		timeOut: 3000,

    };
    var $toast = toastr["error"](msg, title); // Wire up an event handler to a button in the toast, if it exists
    $toastlast = $toast;
    if(typeof $toast === 'undefined'){
        return;
    }

}


	function OnAjaxStart() { $("#TooltipDemo").removeClass("invisible") };
	function OnAjaxStop() {  $("#TooltipDemo").addClass("invisible") } ;

	 $(document).on({
	        ajaxStart: OnAjaxStart,
	        ajaxStop: OnAjaxStop
	        });



//==================================================

	 $.fn.extend({
 		trackChanges: function() {
             $(":input:not(.nosave)", this).change(function() {
                 $(this.form).data("changed", true);

             });
         }
         ,
             isChanged: function() {
                 return this.data("changed");
             }
         ,

         	resetChanges: function(){
                 this.data("changed", false);
             }
         ,

         	removeValidator: function(){

         		 $(this).find('.is-invalid').removeClass("is-invalid");
                  $(this).find('.is-valid').removeClass("is-valid");
                  $(this).find('.invalid-feedback').remove()
         	}
         });



      function MyAlert(message, IsError){
          $("#messagedialog_message").text(message);
          if (IsError){
              $("#messagedialog_message").addClass("text-danger").removeClass("text-muted");
          }
          else{
              $("#messagedialog_message").addClass("text-muted").removeClass("text-danger");
          }

          $("#messagedialog").modal({
              backdrop: 'static',
              keyboard: false});

      };

      window.alert = function(message) {
          $("#messagedialog_message").addClass("text-danger").removeClass("text-muted");
          $("#messagedialog_message").text(message);
          $("#messagedialog").modal({
              backdrop: 'static',
              keyboard: false
          });
      };

      window.confirm = function(message, callback, hasoutput = false) {
          $("#confirmdialog_message").text(message);
          $("#btnConfirmOKModal").prop('onclick',null).off('click');
          $("#btnConfirmOKModal").click(callback);
          $("#confirminput" ).val("");

          if (!hasoutput)
         	 $("#confirminputdiv").addClass("invisible")
        	 else
        	 	$("#confirminputdiv").removeClass("invisible")


          $("#confirmdialog").modal({
              backdrop: 'static',
              keyboard: false
          });
      };

      function confirmSave (message, callbackSave, callbackStay, callbackCancel, hasoutput = false) {
        $("#confirmsavedialog_message").text(message);
        $("#btnConfirmSaveSaveModal").prop('onclick',null).off('click');
        $("#btnConfirmSaveSaveModal").click(callbackSave);
        $("#btnConfirmSaveStayModal").prop('onclick',null).off('click');
        $("#btnConfirmSaveStayModal").click(callbackStay);
        $("#btnConfirmSaveCancelModal").prop('onclick',null).off('click');
        $("#btnConfirmSaveCancelModal").click(callbackCancel);


        $("#confirmsaveinput" ).val("");

        if (!hasoutput)
            $("#confirmsaveinputdiv").addClass("invisible")
           else
               $("#confirmsaveinputdiv").removeClass("invisible")


        $("#confirmsavedialog").modal({
            backdrop: 'static',
            keyboard: false
        });
    };

      function setLanguage(lang){
          createCookie('lang-symbol', lang, 20000);
          location.reload();
      }


      $(document).ready(function () {
         if ($( document ).width() < 991.98) 
            $(".fixed-footer .app-footer .app-footer__inner").css("margin-left", "0")
        else
            $(".fixed-footer .app-footer .app-footer__inner").css("margin-left", "280")
      });

  
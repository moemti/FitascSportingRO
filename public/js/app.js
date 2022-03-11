    function openCurtain(){
        let s = document.getElementById('loaderRight').style;
        s.opacity = '0';
        s.width = '0';


        s = document.getElementById('loaderLeft').style;
        s.opacity = '0';
        s.width = '0';
    }


    function closeCurtain() {
        let s = document.getElementById('loaderRight').style;
        s.opacity = '100%';
        s.width = '50%';
        // s.height = '0';
        s = document.getElementById('loaderLeft').style;
        s.opacity = '100%';
        s.width = '50%';
    }


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


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    
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

    window.onpageshow   = function (){
      //  openCurtain(); 
    }

    window.onbeforeunload = function(){
     //  closeCurtain();
    }

    
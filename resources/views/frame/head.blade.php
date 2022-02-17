<head>
    @stack('head_start')
    <meta http-equiv="x-ua-compatible" content="IE=edge; charset=UTF-8">
    <meta http-equiv="Content-Language" content="en">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Clay Sporting</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"
    />

   
    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">

     
    	<script src={{asset("/assets/scripts/vendors/jquery-3.3.1.min.js")}}></script>
        <script src={{asset("/assets/scripts/vendors/bootstrap.bundle.min.js")}}></script>
        <script src={{asset("/assets/scripts/vendors/metismenu.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/app.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/demo.js")}}></script>

        <script src={{asset("/assets/scripts/scripts-init/jquery.sudoSlider.min.js")}}></script>



        <!--CHARTS-->

        <!--Apex Charts-->
        <script src={{asset("/assets/scripts/vendors/charts/apex-charts.js")}}></script>

        <script src={{asset("/assets/scripts/scripts-init/charts/apex-charts.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/charts/apex-series.js")}}></script>

        <!--Sparklines-->
        <script src={{asset("/assets/scripts/vendors/charts/charts-sparklines.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/charts/charts-sparklines.js")}}></script>

        <!--Chart.js-->

        <script src={{asset("/assets/scripts/scripts-init/charts/chart.min.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/charts/chartsjs-utils.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/charts/chartjs.js")}}></script>

        <!--FORMS-->

        <!--Clipboard-->
        <script src={{asset("/assets/scripts/vendors/form-components/clipboard.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/form-components/clipboard.js")}}></script>

        <!--Datepickers-->
        <script src={{asset("/assets/scripts/vendors/form-components/datepicker.js")}}></script>
        <script src={{asset("/assets/scripts/vendors/form-components/daterangepicker.js")}}></script>
        <script src={{asset("/assets/scripts/vendors/form-components/moment.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/form-components/datepicker.js")}}></script>

        <!--Multiselect-->
        <script src={{asset("/assets/scripts/vendors/form-components/bootstrap-multiselect.js")}}></script>

        <script src={{asset("/assets/scripts/scripts-init/form-components/select2.min.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/form-components/input-select.js")}}></script>

        <!--Form Validation-->
        <script src={{asset("/assets/scripts/vendors/form-components/form-validation.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/form-components/form-validation.js")}}></script>

        <!--Form Wizard-->
        <script src={{asset("/assets/scripts/vendors/form-components/form-wizard.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/form-components/form-wizard.js")}}></script>

        <!--Input Mask-->
        <script src={{asset("/assets/scripts/vendors/form-components/input-mask.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/form-components/input-mask.js")}}></script>

        <!--RangeSlider-->
        <script src={{asset("/assets/scripts/vendors/form-components/wnumb.js")}}></script>
        <script src={{asset("/assets/scripts/vendors/form-components/range-slider.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/form-components/range-slider.js")}}></script>

        <!--Textarea Autosize-->
        <script src={{asset("/assets/scripts/vendors/form-components/textarea-autosize.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/form-components/textarea-autosize.js")}}></script>



        <!--TABLES -->
        <!--DataTables-->
        <script src={{asset("/assets/scripts/vendors/jquery.dataTables.min.js")}}></script>
        <script src={{asset("/assets/scripts/vendors/dataTables.bootstrap4.min.js")}}></script>
        <script src={{asset("/assets/scripts/vendors/dataTables.responsive.min.js")}}></script>
        <script src={{asset("/assets/scripts/vendors/responsive.bootstrap.min.js")}}></script>

        <!--Bootstrap Tables-->
        <script src={{asset("/assets/scripts/vendors/tables.js")}}></script>

        <!--Tables Init-->
        <script src={{asset("/assets/scripts/scripts-init/tables.js")}}></script>


        <!--Toggle Switch -->
		<script src={{asset("/assets/scripts/vendors/form-components/toggle-switch.js")}}></script>



        <!--COMPONENTS-->

        <!--BlockUI -->
        <script src={{asset("/assets/scripts/vendors/blockui.js")}}></script>


        <!--Calendar -->
        <script src={{asset("/assets/scripts/vendors/calendar.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/calendar.js")}}></script>

        <!--Slick Carousel -->
        <script src={{asset("/assets/scripts/vendors/carousel-slider.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/carousel-slider.js")}}></script>

        <!--Circle Progress -->
        <script src={{asset("/assets/scripts/vendors/circle-progress.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/circle-progress.js")}}></script>

        <!--CountUp -->
        <script src={{asset("/assets/scripts/vendors/count-up.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/count-up.js")}}></script>

        <!--Cropper -->
        <script src={{asset("/assets/scripts/vendors/cropper.js")}}></script>
        <script src={{asset("/assets/scripts/vendors/jquery-cropper.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/image-crop.js")}}></script>

        <!--Maps -->
        <script src={{asset("/assets/scripts/vendors/gmaps.js")}}></script>
        <script src={{asset("/assets/scripts/vendors/jvectormap.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/maps-word-map.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/maps.js")}}></script>

        <!--Guided Tours -->
        <script src={{asset("/assets/scripts/vendors/guided-tours.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/guided-tours.js")}}></script>

        <!--Ladda Loading Buttons -->
        <script src={{asset("/assets/scripts/vendors/ladda-loading.js")}}></script>
        <script src={{asset("/assets/scripts/vendors/spin.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/ladda-loading.js")}}></script>

        <!--Rating -->
        <script src={{asset("/assets/scripts/vendors/rating.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/rating.js")}}></script>

        <!--Perfect Scrollbar -->
        <script src={{asset("/assets/scripts/vendors/scrollbar.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/scrollbar.js")}}></script>

        <!--Toastr-->

		<script src={{asset("/assets/scripts/scripts-init/toastr-fromsite.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/toastr.js")}}></script>

        <!--SweetAlert2-->

		<script src={{asset("/assets/scripts/scripts-init/sweet-alerts-fromsite.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/sweet-alerts.js")}}></script>


        <!--Tree View -->
        <script src={{asset("/assets/scripts/vendors/treeview.js")}}></script>
        <script src={{asset("/assets/scripts/scripts-init/treeview.js")}}></script>


</head>



<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" id="token">
    <link rel="icon" href={{  URL::asset('assets/img/basic/favicon.ico')}} type="image/x-icon">
    <title>{{config('app.name')}}</title>
    <!-- CSS -->
    <link rel="stylesheet" href=  {{asset('assets/css/app.css')}}>
    <link rel="stylesheet" href=  {{asset('assets/plugins/toastr/toastr.css')}}>
    <link rel="stylesheet" href=  {{asset('assets/css/daterangepicker.css')}}>
    <link rel="stylesheet" href=  {{asset('assets/css/fullcalendar.min.css')}}>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href=  {{asset('assets/plugins/bootstrap-fileinput/css/fileinput.css')}}>
    <link rel="stylesheet" href=  {{asset('assets/plugins/datatables/buttons-1.5.6/css/buttons.dataTables.min.css')}}>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <style>
        .loader{
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: white;
            opacity: 0.8;
            z-index: 9996;
            text-align: center;
        }
        .loader-icon {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: transparent;
            z-index: 9997;
            text-align: center;
        }

        .plane-container {
            position: absolute;
            top: 50%;
            left: 50%;
            z-index: 9999;
        }

    </style>
    <!-- Js -->
    <!--
    --- Head Part - Use Jquery anywhere at page.
    --- http://writing.colin-gourlay.com/safely-using-ready-before-including-jquery/
    -->
    <script>(function(w,d,u){w.readyQ=[];w.bindReadyQ=[];function p(x,y){if(x=="ready"){w.bindReadyQ.push(y);}else{w.readyQ.push(x);}};var a={ready:p,bind:p};w.$=w.jQuery=function(f){if(f===d||f===u){return a}else{p(f)}}})(window,document)</script>
    @toastr_css
    </head>
    <body class="light">
       @include('layouts.partials.pre-loader')
        <div class="app">
            {{-- Main Navigation or menu --}}
            @include('layouts.partials._header')
            <!-- Right left -->
            @include('layouts.partials.sidebar-left')
            <!-- Right Sidebar -->
            @include('layouts.partials.sidebar-control')
            <!-- /.right-sidebar -->
            <!-- Add the sidebar's background. This div must be placed
                     immediately after the control sidebar -->
             @include('layouts.partials.footer')
            <div class="control-sidebar-bg shadow white fixed"></div>
        </div>
            <!--/#app -->
    </body>
    <!--
    --- Footer Part - Use Jquery anywhere at page.
    --- http://writing.colin-gourlay.com/safely-using-ready-before-including-jquery/
    -->
    @routes
    <script src={{asset('assets/js/app.js')}}></script>
    <script>
        (function($,d){$.each(readyQ,function(i,f){$(f)});$.each(bindReadyQ,function(i,f){$(d).bind("ready",f)})})(jQuery,document)
    </script>
    <script src={{asset('assets/js/functions.js?v='.filemtime('assets/js/functions.js'))}}></script>

    <script src={{asset('assets/js/moment.min.js')}}></script>
    <script src={{asset('assets/js/fullcalendar.min.js')}}></script>
    <script src={{asset('assets/js/bootstrap-datepicker.js')}}></script>
    <script src={{asset('assets/js/bootstrap-timepicker.js')}}></script>
    <script src={{asset('assets/js/jquery.datetimepicker.full.min.js')}}></script>
    <script src={{asset('assets/js/jquery.timepicker.min.js')}}></script>

    <script src={{asset('assets/plugins/toastr/toastr.js')}}></script>

    <!-- <script src={{asset('assets/plugins/bootstrap-fileinput/js/fileinput.js')}}></script>
    <script src={{asset('assets/plugins/bootstrap-fileinput/js/plugins/piexif.js')}}></script>
    <script src={{asset('assets/plugins/bootstrap-fileinput/js/plugins/sortable.js')}}></script>
    <script src={{asset('assets/plugins/bootstrap-fileinput/js/locales/es.js')}}></script>
    <script src={{asset('assets/plugins/bootstrap-fileinput/themes/gly/theme.js')}}></script> -->
    {{-- dataTables export excel --}}
    <script src={{asset('assets/plugins/datatables/buttons-1.5.6/js/dataTables.buttons.min.js')}}></script>
    <script src={{asset('assets/plugins/datatables/buttons-1.5.6/js/buttons.html5.min.js')}}></script>
    <script src={{asset('assets/plugins/datatables/buttons-1.5.6/js/buttons.flash.min.js')}}></script>
    <script src={{asset('assets/plugins/datatables/buttons-1.5.6/js/buttons.print.min.js')}}></script>
    <script src={{asset('assets/plugins/datatables/ajax/libs/jszip-3.1.3/jszip.min.js')}}></script>
    <script src={{asset('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.min.js')}}></script>
    <script src={{asset('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js')}}></script>

    <script src={{asset('assets/plugins/datatables/select-1.3.0/js/dataTables.select.min.js')}}></script>

    <script src={{asset('assets/plugins/bootstrap-fileinput/js/fileinput.js')}}></script>
    <script src={{asset('assets/plugins/bootstrap-fileinput/js/plugins/piexif.js')}}></script>
    <script src={{asset('assets/plugins/bootstrap-fileinput/js/plugins/sortable.js')}}></script>
    <script src={{asset('assets/plugins/bootstrap-fileinput/js/locales/es.js')}}></script>
    <script src={{asset('assets/plugins/bootstrap-fileinput/themes/gly/theme.js')}}></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @toastr_js
    @toastr_render


</html>
@yield('js')

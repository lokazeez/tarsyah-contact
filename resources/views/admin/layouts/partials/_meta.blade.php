<base href="">
<meta charset="utf-8" />
<title>{{ config('app.title') }} | {{ $title ?? 'Laravel' }}</title>
<meta name="description" content="Updates and statistics" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<!--begin::Fonts-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
<!--end::Fonts-->
<!--begin::Page Vendors Styles(used by this page)-->
<!--end::Page Vendors Styles-->

@if(Session::get('lang') == 'ar')
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{ asset('assets/css/rtl/fullcalendar.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles-->

    <link href="{{ asset('assets/css/rtl/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/rtl/prismjs.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/rtl/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />

@else
    <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />

    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->

@endif
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css"/>
<!--end::Global Theme Styles-->
<!--begin::Layout Themes(used by all pages)-->
<!--end::Layout Themes-->
<link rel="shortcut icon" href="{{asset('images/logo.png')}}" />
<link href="{{ asset('assets/plugins/custom/dropify/dist/css/dropify.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/custom/jstree/jstree.bundle.css')}}" rel="stylesheet" type="text/css" />
<meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
<style>
    .error{
        color: #F64E60 !important;
        font-size: 0.85rem !important;
        font-weight: 400 !important;
    }
</style>
{{--<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>--}}
{{--<script>--}}
{{--    window.OneSignal = window.OneSignal || [];--}}
{{--    OneSignal.push(function() {--}}
{{--        OneSignal.init({--}}
{{--            appId: "{{ config('dev_creds.OSG_APP_ID') }}",--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}

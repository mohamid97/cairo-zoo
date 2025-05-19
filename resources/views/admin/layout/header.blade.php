<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CanGrow| Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href=" {{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

    <!-- JQVMap -->
    <link rel="stylesheet" href=" {{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href=" {{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href=" {{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href=" {{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href=" {{ asset('plugins/summernote/summernote-bs4.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!--  &lt;!&ndash; Bootstrap 4 RTL &ndash;&gt;-->

    @if(app()->getLocale() == 'ar')
    <link rel="stylesheet"  href="{{ asset('rtl/rtl.css') }}">
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css">
    <!--  &lt;!&ndash; Custom style for RTL &ndash;&gt;-->
    <link rel="stylesheet" href=" {{ asset('dist/css/custom.css') }} ">
    @endif




    <link rel="icon" href="{{asset('dist/img/canGrowlogo.png')}}" type="image/png">


    @yield('styles')

<style>
    .loader-wrapper {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background: rgba(26, 26, 26, 0.95);
        z-index: 1000;
        animation: fadeOut 2s ease 2s forwards;
    }

    .spinner {
        width: 60px;
        height: 60px;
        border: 6px solid #444;
        border-top-color: #00f7ff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 1rem;
    }

    .loading-text {
        color: #aaa;
        font-size: 1.2rem;
        opacity: 0;
        animation: fadeInOut 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.2);
        }
        100% {
            transform: scale(1);
        }
    }

    @keyframes colorChange {
        0% {
            background-color: var(--col1);
        }
        33.33% {
            background-color: var(--col2);
        }
        66.66% {
            background-color: var(--col3);
        }
        100% {
            background-color: var(--col1);
        }
    }

    @keyframes spin {
        100% {
            transform: rotate(360deg);
        }
    }

    ::-webkit-scrollbar {
        width: 10px; /* Width of the scrollbar */
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1; /* Track color */
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(45deg, #4a90e2, #409ba9);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(45deg, #7b4397, #4a90e2); /* Hover effect */
    }

    /*[class*=sidebar-dark-] {*/
    /*    background-color: #39536d;*/
    /*}*/


    /*.navbar-white {*/
    /*    background-color: #527395;*/
    /*}*/

    /*.navbar-light .navbar-nav .nav-link {*/
    /*    color: rgb(255 255 255);*/
    /*}*/

    .card-body{
        overflow-x:scroll;
    }



</style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">


<div class="loader-wrapper" id="spinner-overlay">
    <div class="spinner"></div>
    <p class="loading-text">Loading...</p>
</div>

<div class="wrapper">
@include('sweetalert::alert')




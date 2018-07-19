<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @yield('csrf-token')
    <title>{{ config('app.name') }} | {{ $pageTitle or '' }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- personal css -->
    <link rel="stylesheet" href="{{ url('/') }}/css/personal.css">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ url('/') }}/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('/') }}/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ url('/') }}/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('/') }}/adminlte/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ url('/') }}/adminlte/css/skins/_all-skins.min.css">
    <link rel="shortcut icon" href="{{ url('/') }}/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="{{ url('/') }}/img/favicon.ico" type="image/x-icon">

    @stack('css')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue fixed sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>P</b>IC</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">{{ config('app.name') }}</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">
                   <!--     <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">4</span>
                        </a> -->
                        <ul class="dropdown-menu">
                            <li class="header">You have 4 messages</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li><!-- start message -->
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="{{ \Thomaswelton\LaravelGravatar\Facades\Gravatar::src(auth()->user()->email) }}" class="img-circle" alt="User Image">
                                            </div>
                                            <h4>
                                                Support Team
                                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                    <!-- end message -->
                                </ul>
                            </li>
                            <li class="footer"><a href="#">See All Messages</a></li>
                        </ul>
                    </li>
                    <!-- Notifications: style can be found in dropdown.less -->

                    <!-- Tasks: style can be found in dropdown.less -->

                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ \Thomaswelton\LaravelGravatar\Facades\Gravatar::src(auth()->user()->email) }}" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{ \Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="{{ \Thomaswelton\LaravelGravatar\Facades\Gravatar::src(auth()->user()->email) }}" class="img-circle" alt="User Image">

                                <p>
                                    {{ \Auth::user()->name }}
                                    <small>Member since <br>
                                        {{ \Auth::user()->created_at->format('jS \\of F Y') }}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ route('mybookings') }}" class="btn btn-default btn-flat">My Bookings</a>
                                </div>
                                <div class="pull-right">
                                    <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    {{--<li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>--}}
                </ul>
            </div>
        </nav>
    </header>

    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    @include('dashboard.left-menu')

    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ $pageHeader or '' }}
                <small>{{ $pageSubHeader or '' }}</small>
            </h1>
            @yield('breadcrumb')
        </section>

        <!-- Main content -->
        @yield('content')
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            Powered by <strong><a href="https://www.pickcenter.it/" target="_blank">Pickcenter</a></strong>
        </div>
        Copyright &copy; {{ date('Y') }} <strong><a href="https://www.pickcenter.it">https://www.pickcenter.it</a></strong>. All rights
        reserved.
    </footer>

    <!-- Control Sidebar -->
    <!-- include('dashboard.control-sidebar') -->
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ url('/') }}/js/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ url('/') }}/bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="{{ url('/') }}/js/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="{{ url('/') }}/js/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="{{ url('/') }}/adminlte/js/adminlte.min.js"></script>
<script>
    $(document).ready(function () {
        $('.sidebar-menu').tree()
    })
</script>
@stack('js')
</body>
</html>

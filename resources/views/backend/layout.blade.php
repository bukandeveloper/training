<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width,user-scalable=0,initial-scale=1.0,minimum-scale=1.0">

        <!-- Components -->
        <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/skins/_all-skins.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/validation-engine/validationEngine.jquery.css') }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        @yield('css-scripts')
        <link rel="stylesheet" href="{{ asset('css/backend/backend.css') }}">
    </head>
    <body class="hold-transition skin-purple-light sidebar-mini @yield('body-class')">
        <div class="wrapper">

            <header class="main-header">

                <a href="{{ url('admin') }}" class="logo">
                    <span class="logo-mini">{{ config('const.SHORT_APP_NAME') }}</span>
                    <span class="logo-lg">{{ config('const.FULL_APP_NAME') }}</span>
                </a>

                <nav class="navbar navbar-static-top">
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"><span class="sr-only">Toggle navigation</span></a>

                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="{{ route('index') }}" target="_blank"><i class="fa fa-home" aria-hidden="true"></i> Top Page</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.logout') }}"><span><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</span></a>
                            </li>
                        </ul>
                    </div>

                </nav>
            </header>

            <!-- SIDEBAR -->
            <aside class="main-sidebar">
                <section class="sidebar">
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="{{ asset('img/ic_profile.png') }}" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p>{{ Auth::user()->username }}</p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <ul class="sidebar-menu" data-widget="tree">
                        <li class="header">MAIN NAVIGATION</li>
                        <!-- Menu for admin -->
                        <?php if (Auth::guard('admin')->user()->is_super){?>
                        <li id="menu-admins" class="treeview">
                            <a href="#">
                                <i class="fa fa-users"></i>
                                <span>Admin</span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="add-admins"><a href="{{ route('admin.admins.create') }}"><i class="fa fa-circle-o"></i> Buat Admin Baru</a></li>
                                <li class="list-admins"><a href="{{ route('admin.admins.index') }}"><i class="fa fa-circle-o"></i> List Admin</a></li>
                            </ul>
                        </li>
                        <?php } ?>
                        <li id="menu-members" class="treeview">
                            <a href="#">
                                <i class="fa fa-users"></i>
                                <span>Member</span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="add-members"><a href="{{ route('admin.members.add') }}"><i class="fa fa-circle-o"></i> Buat Member Baru</a></li>
                                <li class="list-members"><a href="{{ route('admin.members') }}"><i class="fa fa-circle-o"></i> List Member</a></li>
                            </ul>
                        </li>
                        <li id="menu-news" class="treeview">
                            <a href="#">
                                <i class="fa fa-newspaper-o"></i>
                                <span>Berita</span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="add-news"><a href="{{ route('admin.news.add') }}"><i class="fa fa-circle-o"></i> Buat Berita Baru</a></li>
                                <li class="list-news"><a href="{{ route('admin.news') }}"><i class="fa fa-circle-o"></i> List Berita</a></li>
                                <li class="list-news-kategori"><a href="{{ route('admin.news-kategori') }}"><i class="fa fa-circle-o"></i> News Kategori</a></li>
                                <li class="add-news-kategori"><a href="{{ route('admin.news-kategori.add') }}"><i class="fa fa-circle-o"></i> News Kategori Baru</a></li>
                            </ul>
                        </li>

                        <li id="menu-merek" class="treeview">
                            <a href="#">
                                <i class="fa fa-users"></i>
                                <span>Merek</span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="add-merek"><a href="{{ route('admin.merek.add') }}"><i class="fa fa-circle-o"></i> Buat Merek Baru</a></li>
                                <li class="list-merek"><a href="{{ route('admin.merek') }}"><i class="fa fa-circle-o"></i> List Merek</a></li>
                            </ul>
                        </li>

                        <li id="menu-produk_kategori" class="treeview">
                            <a href="#">
                                <i class="fa fa-users"></i>
                                <span>Produk Kategori</span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="add-produk_kategori"><a href="{{ route('admin.produk-kategori.add') }}"><i class="fa fa-circle-o"></i> Buat Produk Kategori Baru</a></li>
                                <li class="list-produk_kategori"><a href="{{ route('admin.produk-kategori') }}"><i class="fa fa-circle-o"></i> List Produk Kategori</a></li>
                            </ul>
                        </li>
                        @if (Auth::user() instanceof App\Models\Admin)
                        <li id="menu-login-histories">
                            <a href="{{ route('admin.login-histories-admin') }}">
                                <i class="fa fa-sign-in"></i>
                                <span>Login History</span>
                            </a>
                            {{--<ul class="treeview-menu">--}}
                                {{--<li class="histories-admins"><a href="{{ route('admin.login-histories-admin') }}"><i class="fa fa-circle-o"></i> Login History Admin</a></li>--}}
                                {{--<li class="histories-user"><a href="{{ route('admin.login-histories-user') }}"><i class="fa fa-circle-o"></i> Login History Member</a></li>--}}
                            {{--</ul>--}}
                        </li>
                        @endif
                    </ul>


                </section>
            </aside>

            <!-- CONTENT -->
            <div class="content-wrapper">
                @yield('content')
            </div>

            <footer class="main-footer">
                <div class="version hidden-xs">
                    <b>Version</b> 1.0.0
                </div>
            </footer>

        </div>
        <!-- ./wrapper -->

        <!-- JS COMPONENTS -->
        <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('bower_components/jquery-cookie/jquery.cookie.min.js') }}"></script>
        <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
        <script src="{{ asset('js/adminlte.min.js') }}"></script>
        <script src="{{ asset('plugins/validation-engine/jquery.validationEngine-ja.js') }}"></script>
        <script src="{{ asset('plugins/validation-engine/jquery.validationEngine.js') }}"></script>
        <script src="{{ asset('js/backend/backend.js') }}"></script>
        <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <script src="{{ asset('plugins/tabulator/tabulator.min.js') }}"></script>
        <script type="text/javascript"> var rootUrl = "{{ url('/') }}";</script>
        {{--root_url is only for cke editor in news--}}
        <script type="text/javascript"> var root_url = "{{ url('/') }}";</script>
        @yield('js-scripts')
    </body>
</html>

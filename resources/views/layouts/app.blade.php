@include ('layouts.header')
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->

        <a href="{{url('admin/home')}}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>تطبيق بنك  </b>الدم</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>تطبيق بنك  </b>الدم</span>
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

                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{asset('adminlte/img/user2-160x160.jpg')}}" class="user-image" alt="User Image">
                            <span class="hidden-xs"></span>
                        </a>
                        {{--<ul class="dropdown-menu">--}}
                            {{--<!-- User image -->--}}
                            {{--<li class="user-header">--}}
                                {{--<img src="{{asset('adminlte/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">--}}

                                {{--<p>--}}

                                    {{--<small>Member since Nov. 2012</small>--}}
                                {{--</p>--}}
                            {{--</li>--}}
                            <!-- Menu Body -->

                            <!-- Menu Footer-->

                                <li>
                                    <script type="">
                                        function submitSignout() {
                                            document.getElementById('signoutForm').submit();

                                        }
                                    </script>
                                    {!! Form::open(['method' => 'post', 'url' => url('logout'),'id'=>'signoutForm']) !!}

                                    {!! Form::close() !!}

                                    <a href="#" onclick="submitSignout()">
                                        <i class="fa fa-sign-out"></i> تسجيل الخروج
                                    </a>
                                </li>

                        </ul>
                    {{--</li>--}}
                    <!-- Control Sidebar Toggle Button -->

                {{--</ul>--}}
            </div>
        </nav>
    </header>

    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    {{--<img src="{{asset('adminlte/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">--}}
                </div>
                <div class="pull-left info">
                    <p> </p>
                </div>
            </div>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">


                <li><a href="{{url(route('governorates.index'))}}"><i class="fa fa-map-marker"></i> <span class="text-bold">المحافظات</span></a></li>
                <li><a href="{{url(route('cities.index'))}}"><i class="fa fa-flag"></i> <span class="text-bold">المدن</span></a></li>
                <li><a href="{{url(route('categories.index'))}}"><i class="fa fa-list"></i> <span class="text-bold">الأقسام</span></a></li>
                <li><a href="{{url(route('posts.index'))}}"><i class="fa fa-comment"></i> <span class="text-bold">المقالات</span></a></li>
                <li><a href="{{url(route('clients.index'))}}"><i class="fa fa-users"></i> <span class="text-bold">العملاء</span></a></li>
                <li><a href="{{url(route('donations.index'))}}"><i class="fa fa-heart"></i> <span class="text-bold">التبرعات</span></a></li>
                <li><a href="{{url(route('contacts.index'))}}"><i class="fa fa-phone"></i> <span class="text-bold">تواصل معنا</span></a></li>
                <li><a href="{{url('admin/user/change-password')}}"><i class="fa fa-key"></i> <span class="text-bold">تغيير كلمة المرور </span></a></li>
                <li><a href="{{url(route('settings.index'))}}"><i class="fa fa-cogs"></i> <span class="text-bold">الإعدادات </span></a></li>
                <li><a href="{{url(route('user.index'))}}"><i class="fa fa-users"></i> <span class="text-bold"> المستخدمين </span></a></li>
                <li><a href="{{url(route('role.index'))}}"><i class="fa fa-list"></i> <span class="text-bold">رتب السمتخدمين </span></a></li>
                {{--<li><a href="{{url(route('reports.index'))}}"><i class="fa fa-book"></i> <span class="text-bold">التقارير</span></a></li>--}}
                {{--<li><a href="{{url(route('settings.view'))}}"><i class="fa fa-book"></i> <span>Settings</span></a></li>--}}


            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                @yield('page_title')
                <small>@yield('small_title')</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url('admin/home')}}"><i class="fa fa-dashboard"></i>الرئيسية</a></li>
                <li class="active">@yield('small_title')</li>

            </ol>

        </section>

        @yield('content')
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            تصميم وبرمجة شركة ابداع تك
        </div>
        <!-- Default to the left -->
        <strong>&copy; {{date('Y')}} <a href="{{url('admin/home')}}">{{config('app.name')}}</a>.</strong> جميع الحقوق محفوظة
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>

            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane" id="control-sidebar-home-tab">
                <h3 class="control-sidebar-heading">Recent Activity</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                                <p>Will be 23 on April 24th</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-user bg-yellow"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                                <p>New phone +1(800)555-1234</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                                <p>nora@example.com</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-file-code-o bg-green"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                                <p>Execution time 5 seconds</p>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

                <h3 class="control-sidebar-heading">Tasks Progress</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                Custom Template Design
                                <span class="label label-danger pull-right">70%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                Update Resume
                                <span class="label label-success pull-right">95%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                Laravel Integration
                                <span class="label label-warning pull-right">50%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                            </div>
                        </a>
                    <li>
                    </li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Back End Framework
                            <span class="label label-primary pull-right">68%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                        </div>
                    </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

            </div>
            <!-- /.tab-pane -->
            <!-- Stats tab content -->
            <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
            <!-- /.tab-pane -->
            <!-- Settings tab content -->
            <div class="tab-pane" id="control-sidebar-settings-tab">
                <form method="post">
                    <h3 class="control-sidebar-heading">General Settings</h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Report panel usage
                            <input type="checkbox" class="pull-right" checked>
                        </label>

                        <p>
                            Some information about this general settings option
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Allow mail redirect
                            <input type="checkbox" class="pull-right" checked>
                        </label>

                        <p>
                            Other sets of options are available
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Expose author name in posts
                            <input type="checkbox" class="pull-right" checked>
                        </label>

                        <p>
                            Allow the user to show his name in blog posts
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <h3 class="control-sidebar-heading">Chat Settings</h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Show me as online
                            <input type="checkbox" class="pull-right" checked>
                        </label>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Turn off notifications
                            <input type="checkbox" class="pull-right">
                        </label>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Delete chat history
                            <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                        </label>
                    </div>
                    <!-- /.form-group -->
                </form>
            </div>
            <!-- /.tab-pane -->
        </div>
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
@include('layouts.footer')

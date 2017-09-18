<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{--font awesome--}}
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    @yield('css')

</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Story
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
            @if (!Auth::guest())
                <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="{{route('admin')}}">
                                <i class="fa fa-tachometer" aria-hidden="true"></i>
                                <span>Tổng quan</span>
                            </a>
                        </li>
                        @if(\App\User::find(Auth::id())->role == 1 || \App\User::find(Auth::id())->role == 2)
                            <li>
                                <a href="{{ url('admin/user') }}">
                                    <i class="fa fa-address-book-o" aria-hidden="true"></i>
                                    <span>Tài khoản</span>
                                </a>
                            </li>

                        @else
                        @endif
                        @if(\App\User::find(Auth::id())->role == 1 || \App\User::find(Auth::id())->role == 2 || \App\User::find(Auth::id())->role == 3)
                            <li>
                                <a href="{{route('post')}}">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span>Đăng bài</span>
                                </a>
                            </li>
                        @else
                        @endif
                        @if(\App\User::find(Auth::id())->role == 1 || \App\User::find(Auth::id())->role == 2 || \App\User::find(Auth::id())->role == 3)
                            <li>
                                <a href="{{route('tool')}}">
                                    <i class="fa fa-asl-interpreting" aria-hidden="true"></i>
                                    <span>Đăng bài tự động</span>
                                </a>
                            </li>
                        @else
                        @endif
                    </ul>
            @else
            @endif

            <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                <i class="fa fa-user-o"></i>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li data-toggle="modal" data-target="#change-password">
                                    <a href="#">
                                        <span class="fa fa-gear"></span>&nbsp;&nbsp;Thay đổi mật khẩu
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <span class="fa fa-reply-all"></span>&nbsp;&nbsp;Đăng xuất
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <!-- Modal title seo-->
    <div class="modal fade" id="change-password" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content aj-form-page">
                <form>
                    {{csrf_field()}}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Thay đổi mật khẩu</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input class="aj-text-page form-control" name="change-password" id="change-password"
                                   placeholder="Nhập mật khẩu cũ">
                        </div>
                        <div class="form-group">
                            <input class="aj-text-page form-control" name="change-password" id="change-password"
                                   placeholder="Nhập mật khẩu mới">
                        </div>
                        <div class="form-group">
                            <input class="aj-text-page form-control" name="change-password" id="change-password"
                                   placeholder="Nhập lại mật khẩu mới">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default sm-change-password-page">Thay đổi</button>
                        <button type="button" class="btn btn-success" data-dismiss="modal">Quay lại</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @yield('content')
</div>

<!-- Scripts -->

{{--jquery--}}
<script src="{{ asset('jquery/jquery.min.js') }}"></script>

<script src="{{ asset('js/app.js') }}"></script>

{{--ckeditor--}}
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>

@yield('js')

</body>
</html>

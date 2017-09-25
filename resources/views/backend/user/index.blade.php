@extends('layouts.backend')
<?php
$role_admin = 1;
$role_leader = 2;
$role_bus = 3;
?>

@section('css')

@endsection

@section('content')
    @if(session('mes'))
        <div class="mes-page" style="position: absolute;z-index: 1;opacity: 0.9;left: 30%">
            <div class="alert alert-success" role="alert">
                <strong>Thành công!</strong> {{session('mes')}}.
            </div>
        </div>
    @endif
    <div class="col-md-4 col-sm-4 col-xs-12">
        {{--<form id="form-change-password" role="form" method="POST" action="{{ route('changePassword') }}"--}}
        {{--{{ csrf_field() }}--}}
        {{--novalidate class="form-horizontal">--}}
        {{--<div class="col-md-9">--}}
        {{--<div class="form-group">--}}
        {{--<label for="password">Tên tài khoản</label>--}}
        {{--<input type="password" class="form-control" id="password" name="password"--}}
        {{--placeholder="Tên tài khoản">--}}
        {{--</div>--}}
        {{--<div class="form-group">--}}
        {{--<label for="password">Mật khẩu</label>--}}
        {{--<input type="password" class="form-control" id="password" name="password"--}}
        {{--placeholder="Mật khẩu">--}}
        {{--</div>--}}
        {{--<div class="form-group">--}}
        {{--<label for="password">Nhập lại mật</label>--}}
        {{--<input type="password" class="form-control" id="password" name="password"--}}
        {{--placeholder="Nhập lại mật khẩu">--}}
        {{--</div>--}}
        {{--<hr>--}}
        {{--<div class="form-group">--}}
        {{--<button type="submit" class="btn btn-default"><i class="fa fa-plus"></i>Thêm tài khoản</button>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</form>--}}
        <h3>Tạo tài khoản</h3>
        <form class="form-horizontal" method="POST" action="">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-4 control-label">Tác giả</label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required
                           autofocus>

                    @if ($errors->has('name'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">Tên tài khoản</label>

                <div class="col-md-6">
                    <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label">Mật khẩu</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label for="password-confirm" class="col-md-4 control-label">Nhập lại mật khẩu</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                           required>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;Tạo tài khoản
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-8 col-sm-8 col-xs-12">
        <div class="x_panel tile fixed_height_320 widget-custom-padding">
            <div class="content">
                <h4>Tất cả các tài khoản.</h4>
            </div>
            <div class="content">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên tài khoản</th>
                        <th>Tác giả</th>
                        <th>Chức vụ</th>
                        <th>Ngày tạo</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $key=>$user)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->name}}</td>
                            <td>
                                @foreach($roles as $role)
                                    @if($role->id == $user->role)
                                        {{$role->name}}
                                    @endif
                                @endforeach
                            </td>
                            <td>{{$user->created_at==''?'Khởi tạo từ đầu':$user->created_at}}</td>
                            <td>
                                <a title="Xóa tài khoản"  href="{{url('/admin/user/delete/' . $user->id)}}"><i class="fa fa-remove"></i></a>&nbsp;&nbsp;
                                <a title="Reset mật khẩu và tất cả mật khẩu sẽ được trở về 'story123'" href="{{url('/admin/user/reset/' . $user->id)}}"><i class="fa fa-refresh"></i></a>&nbsp;&nbsp;
                                <a title="Sửa mật khẩu" href="#"><i class="fa fa-pencil-square"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {!! $users->render() !!}
    </div>


@endsection

@extends('layouts.backend')
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
    <div class="col-md-3 col-sm-3 col-xs-12">
        <span style="font-size: 50px; font-weight: bold">IP</span>
        <small>"Internet Protocol"</small>
        <div class="content">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>STT</th>
                    <th>IP</th>
                    <th>Username</th>
                    <th>Logged</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ips as $key=>$ip)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$ip->ip}}</td>
                        <td>
                            @foreach($alluser as $val)
                                @if($val->id == $ip->user_id)
                                    <div title="{{$val->email}}">
                                        {{$val->name}}
                                    </div>
                                @endif

                            @endforeach
                        </td>
                        <td>{{$ip->created_at}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div id="form-col-user" class="col-md-1 col-sm-1 col-xs-12">
        <button id="btn-show-hide" data-action="0" class="btn btn-info">Hiện...&nbsp;&nbsp;<span class="fa fa-arrow-circle-o-right"></span></button>
        <div id="form-add-user" style="display: none">
            <h3>Tạo tài khoản</h3>
            <form class="form-horizontal" method="POST" action="{{route('user.create')}}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Tác giả</label>
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required
                               autofocus placeholder="Nhập tác giả">

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
                        <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required
                               placeholder="Nhập tên tài khoản">
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
                        <input id="password" type="password" class="form-control" name="password" required
                               placeholder="Nhập mật khẩu">

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
                               required placeholder="Nhập lại mật khẩu">
                    </div>
                </div>

                <div class="form-group">
                    <label for="role-new-user" class="col-md-4 control-label">Chức vụ</label>

                    <div class="col-md-6">
                        <select id="role-new-user" class="form-control" name="role_new_user">
                            @foreach($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-default">
                            <i class="fa fa-plus"></i>&nbsp;&nbsp;Tạo tài khoản
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="show-all-page" class="col-md-8 col-sm-8 col-xs-12">
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
                        <tr id="{{$user->id}}">
                            <td>{{$key+1}}</td>
                            <td class="username">{{$user->email}}</td>
                            <td>{{$user->name}}</td>
                            <td>
                                <select class="form-control role-user-page">
                                    @foreach($roles as $role)
                                        <option {{$role->id == $user->role? 'selected':''}} value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                                {{--@foreach($roles as $role)--}}
                                    {{--@if($role->id == $user->role)--}}
                                        {{--{{$role->name}}--}}
                                    {{--@endif--}}
                                {{--@endforeach--}}
                            </td>
                            <td>{{$user->created_at==''?'Khởi tạo từ đầu':$user->created_at}}</td>
                            <td>
                                <a style="color:#cc6699" title="Xóa tài khoản"
                                   href="{{url('/admin/user/delete/' . $user->id)}}"><i class="fa fa-remove"></i></a>&nbsp;&nbsp;
                                <a title="Reset mật khẩu và tất cả mật khẩu sẽ được trở về 'story123'"
                                   href="{{url('/admin/user/reset/' . $user->id)}}"><i class="fa fa-refresh"></i></a>&nbsp;&nbsp;
                                <a data-toggle="modal" data-target="#change-password-user" title="Sửa mật khẩu"
                                   href="#"><i class="fa fa-pencil-square"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {!! $users->render() !!}
    </div>

    <!-- Modal change password-->
    <div class="modal fade" id="change-password-user" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content aj-form-page">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Thay đổi mật khẩu tài khoản <span style="font-weight: bold"
                                                                              class="username-ad"></span></h4>
                </div>
                <div class="modal-body">
                    <form id="form-change-password-ad" role="form"
                          novalidate class="form-horizontal">
                        <div class="col-md-9">
                            <label for="password_ad" class="col-sm-4 control-label">Mật khẩu mới</label>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <input type="password" class="form-control" id="password_ad" name="password"
                                           placeholder="Password">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-6">
                                <button type="button" data-id="" id="chang-pw-ad" class="btn btn-danger">Thay đổi
                                </button>
                                <button type="button" class="btn btn-success" data-dismiss="modal">Quay lại</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $('.fa-pencil-square').click(function () {
                var name = $(this).closest('tr').find('.username').text();
                $('.username-ad').empty();
                $('.username-ad').append('"' + name + '"');
                var user_id = $(this).closest('tr').attr('id');
                $('#chang-pw-ad').attr('data-id', user_id);
            });
            $('#chang-pw-ad').click(function () {
                var id = parseInt($(this).attr('data-id'));
                var pw = $('#password_ad').val();
                console.log(id, pw)
                if (pw != '') {
                    $.ajax({
                        url: '{{route('changeUserPassword')}}',
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            user_id: id,
                            pw: pw
                        },
                        dataType: 'JSON',
                        success: function (rsp) {
                            $('#change-password-user').modal('hide');
                            $('body').append('<div class="mes-page" style="position: absolute;z-index: 1;opacity: 0.9;left: 30%">\n' +
                                '<div class="alert alert-success" role="alert">\n' +
                                '<strong>Thành công!    </strong>' + rsp[0] + ' .\n' +
                                '</div>\n' +
                                '</div>');
                            setTimeout(function () {
                                $('.mes-page').empty();
                            }, 1500);
                        }, error: function () {
                            location.reload();
                        }
                    });
                } else {
                    alert('Bạn nhập mật khẩu mới có thể sử dụng chức năng này...');
                }
            });
            $(document).on('click', '#btn-show-hide', function () {
                var action = parseInt($(this).attr('data-action'));
                switch(action) {
                    case 0:
                        $(this).empty();
                        $(this).append('Ẩn...&nbsp;&nbsp;<span class="fa fa-arrow-circle-o-left"></span>');

                        $('#form-col-user').attr('class', '');
                        $('#form-col-user').attr('class', 'col-md-3 col-sm-3 col-xs-12');
                        $('#show-all-page').attr('class', '');
                        $('#show-all-page').attr('class', 'col-md-6 col-sm-6 col-xs-12');

                        $('#form-add-user').css({'display': 'block'});
                        $('#btn-show-hide').attr('data-action', 1);
                        break;
                    case 1:
                        $(this).empty();
                        $(this).append('Hiện...&nbsp;&nbsp;<span class="fa fa-arrow-circle-o-right"></span>');

                        $('#form-col-user').attr('class', '');
                        $('#form-col-user').attr('class', 'col-md-1 col-sm-1 col-xs-12');
                        $('#show-all-page').attr('class', '');
                        $('#show-all-page').attr('class', 'col-md-8 col-sm-8 col-xs-12');

                        $('#form-add-user').css({'display': 'none'});
                        $('#btn-show-hide').attr('data-action', 0);
                        break;
                    default:
                        $(this).empty();
                        $(this).append('Hiện...&nbsp;&nbsp;<span class="fa fa-arrow-circle-o-right"></span>');

                        $('#form-col-user').attr('class', '');
                        $('#form-col-user').attr('class', 'col-md-1 col-sm-1 col-xs-12');
                        $('#show-all-page').attr('class', '');
                        $('#show-all-page').attr('class', 'col-md-8 col-sm-8 col-xs-12');

                        $('#form-add-user').css({'display': 'none'});
                        $('#btn-show-hide').attr('data-action', 0);
                }
            });
            $('.role-user-page').on('change', function () {
                var id = $(this).closest('tr').attr('id');
                var role = $(this).val();
                $.ajax({
                    type:'POST',
                    url: '{{ route('ajax.ChangeRole') }}',
                    data: {"_token": "{{ csrf_token() }}",
                        'id':id,
                        'role':role
                    },
                    dataType:'JSON',
                    success: function (rsp) {
                        alert('Cập nhật trạng thái thành công!');
                    },
                    error: function () {
                        location.reload();
                    }
                });
            });
        });
    </script>
@endsection
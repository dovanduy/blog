@extends('layouts.backend')
<?php
$role_admin = 1;
$role_leader = 2;
$role_bus = 3;
?>

@section('css')
    <style>
        .onoffswitch {
            position: relative; width: 50px;
            -webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;
        }
        .onoffswitch-checkbox {
            display: none;
        }
        .onoffswitch-label {
            display: block; overflow: hidden; cursor: pointer;
            border: 2px solid #E3E3E3; border-radius: 19px;
        }
        .onoffswitch-inner {
            display: block; width: 200%; margin-left: -100%;
            transition: margin 0.3s ease-in 0s;
        }
        .onoffswitch-inner:before, .onoffswitch-inner:after {
            display: block; float: left; width: 50%; height: 26px; padding: 0; line-height: 26px;
            font-size: 10px; color: white; font-family: Trebuchet, Arial, sans-serif; font-weight: bold;
            box-sizing: border-box;
        }
        .onoffswitch-inner:before {
            content: "";
            padding-left: 5px;
            background-color: #FFFFFF; color: #FFFFFF;
        }
        .onoffswitch-inner:after {
            content: "";
            padding-right: 5px;
            background-color: #FFFFFF; color: #666666;
            text-align: right;
        }
        .onoffswitch-switch {
            display: block; width: 21px; margin: 2.5px;
            background: #A1A1A1;
            position: absolute; top: 0; bottom: 0;
            right: 20px;
            border: 2px solid #E3E3E3; border-radius: 19px;
            transition: all 0.3s ease-in 0s;
        }
        .onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
            margin-left: 0;
        }
        .onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
            right: 0px;
            background-color: #27A1CA;
        }
    </style>
@endsection

@section('content')
    @if(session('mes'))
        <div class="mes-page" style="position: absolute;z-index: 1;opacity: 0.9;left: 30%">
            <div class="alert alert-success" role="alert">
                <strong>Thành công!</strong> {{session('mes')}}.
            </div>
        </div>
    @endif
    @if(session('er'))
        <div class="mes-page" style="position: absolute;z-index: 1;opacity: 0.9;left: 30%">
            <div class="alert alert-danger" role="alert">
                <strong>Thành công!</strong> {{session('er')}}.
            </div>
        </div>
    @endif
    <div class="col-md-2 col-sm-2 col-xs-12">
        <a href="{{route('post.create')}}">
            <button class="btn btn-success"><span class="fa fa-plus"></span>&nbsp;&nbsp;Thêm truyện</button>
        </a>
        <div class="form-group">
            <h5>@if(\Illuminate\Support\Facades\Auth::id() == $role_admin || \Illuminate\Support\Facades\Auth::id() == $role_leader) Có tất cả: <span style="color: pink"> {{$posts->total()}}</span></h5>
            <h5>Bạn có tất cả:<span style="color: pink"> {{(\App\Post::where('user_id', \Illuminate\Support\Facades\Auth::id())->count())}}</span></h5>@endif
        </div>
        <div>
            <h4 style="color: #7da8c3">Các thể loại:</h4>
            @foreach($types as $type)
                <div class="form-group">
                    <a href="{{url('admin/post/typeDelete/' . $type->id)}}" onclick="return window.confirm('Bạn muốn xóa?')"><span class="fa fa-close" style="color: #ff2222"></span></a>
                    <input type="text" class="form-control" value="{{$type->name}}" disabled>
                </div>
            @endforeach
            <div class="form-group">
                <h5 style="color: #9b8a30">Thêm thể loại:</h5>
                <form class="form-inline" method="POST" action="{{route('addType')}}">
                    {{csrf_field()}}
                    <div class="form-group">
                        <input type="text" class="form-control" id="type" name="type" placeholder="Thêm thể loại">
                    </div>
                    <button type="submit" class="btn btn-default" id="add_type">Thêm</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-10 col-sm-10 col-xs-12">
        <div class="x_panel tile fixed_height_320 widget-custom-padding">
            <div class="content">
                <h4>Tất cả các bài viết.</h4>
            </div>
            <div class="content">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tiêu đề</th>
                        <th>Thể loại</th>
                        <th>Title seo</th>
                        <th>Nội dung</th>
                        @if(\Illuminate\Support\Facades\Auth::id() == $role_admin || \Illuminate\Support\Facades\Auth::id() == $role_leader)
                            <th>Tác giả</th>
                        @endif
                        <th>Trạng thái</th>
                        <th>Ngày đăng</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($posts as $key=>$post)
                        <tr id="{{$post->id}}" class="selected-page">
                            <td title="Ngày cập nhật truyện: {{$post->updated_at}}">{{$key+1}}</td>
                            <td>{{ str_limit($post->title, $limit = 100, $end='...') }}</td>
                            <td>{!! ($post->Type['name']) !!}</td>
                            <td id="short-content-after-edit-{{$post->id}}" data-toggle="modal" data-target="#myModal-short-content-{{$key}}" title="Ấn để sửa..." style="cursor: pointer;">{{$post->title_seo}}</td>
                            <td id="content-after-edit-{{$post->id}}" data-toggle="modal" data-target="#myModal-content-{{$key}}" title="Ấn để sửa..." style="cursor: pointer;">{!! str_limit($post->content, $limit = 100, $end = '...') !!}</td>
                            @if(\Illuminate\Support\Facades\Auth::id() == $role_admin || \Illuminate\Support\Facades\Auth::id() == $role_leader)
                                <td>@foreach(App\User::select('name')->where('id', \Illuminate\Support\Facades\Auth::id())->get() as $val) {{$val->name}} @endforeach</td>
                            @endif
                            <td>
                                <div class="onoffswitch">
                                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch-{{$key}}" value="{{$post->status}}" {{$post->status == 1? 'checked':''}}>
                                    <label class="onoffswitch-label" for="myonoffswitch-{{$key}}">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </td>
                            <td>{{ $post->created_at }}</td>
                            <td>
                                <div>
                                    <a title="Xóa truyện" href="{{url('admin/post/delete/' . $post->id)}}" onclick="return window.confirm('Bạn muốn xóa?')"><span class="fa fa-trash"></span></a>
                                </div>
                                <div>
                                    <a title="Sửa truyện" href="{{url('admin/post/edit/' . $post->id)}}"><span class="fa fa-edit"></span></a>
                                </div>
                            </td>
                        </tr>
                        <!-- Modal content-->
                        <div class="modal fade" id="myModal-content-{{$key}}" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content aj-form-page">
                                    <form>
                                        {{csrf_field()}}
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Sửa Nội dung</h4>
                                        </div>
                                        <div class="modal-body">
                                            <textarea class="aj-text-page" name="content" id="content-{{$key}}">{!! ($post->content) !!}</textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" data-id="{{$post->id}}" class="btn btn-default sm-content-page">Thay đổi</button>
                                            <button type="button" class="btn btn-success" data-dismiss="modal">Quay lại</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Modal short content-->
                        <div class="modal fade" id="myModal-short-content-{{$key}}" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content aj-form-page">
                                    <form>
                                        {{csrf_field()}}
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Title SEO</h4>
                                        </div>
                                        <div class="modal-body">
                                            <input class="aj-text-page form-control" name="title_seo" id="title_seo-{{$key}}" value="{!! ($post->title_seo) !!}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit"  data-id="{{$post->id}}" class="btn btn-default sm-short-content-page">Thay đổi</button>
                                            <button type="button" class="btn btn-success" data-dismiss="modal">Quay lại</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {!! $posts->render() !!}
    </div>


@endsection

@section('js')
    <script type="text/javascript">
        for(var i= 0; i < $('.selected-page').length; i++) {
            CKEDITOR.replace('content-' + i);
        }
//short text
        function TruncateText(text)
        {
            if(text.length > 100)
            {
                text = text.substring(0, 100) + "...";
            }
            return text;
        }
//short content
        $(document).ready(function () {
            $('.sm-short-content-page').click(function () {
                var get_id_ckeditor = $(this).closest('.aj-form-page').find('.aj-text-page').attr('id');
                var id = $(this).data('id');
                var title_seo = $(this).closest('.aj-form-page').find('.aj-text-page').val();
                console.log(title_seo)
                $.ajax({
                    type:'POST',
                    url: '{{ route('ajax.editShortContent') }}',
                    data: {"_token": "{{ csrf_token() }}",
                        'id':id,
                        'title_seo':title_seo},
                    dataType:'JSON',
                    success: function (rsp) {
                        alert('Cập nhật truyện thành công!');
                        $('#short-content-after-edit-'+ rsp.id).empty();
                        $('#short-content-after-edit-'+ rsp.id).append(TruncateText(rsp.title_seo));
                    },
                    error: function () {
                        location.reload();
                    }
                })
            })
        });

        //content
        $(document).ready(function () {
            $('.sm-content-page').click(function () {
                var get_id_ckeditor = $(this).closest('.aj-form-page').find('.aj-text-page').attr('id');
                var id = $(this).data('id');
                var content = CKEDITOR.instances[get_id_ckeditor].getData();
                $.ajax({
                    type:'POST',
                    url: '{{ route('ajax.editContent') }}',
                    data: {"_token": "{{ csrf_token() }}",
                        'id':id,
                        'content_':content},
                    dataType:'JSON',
                    success: function (rsp) {
                        alert('Cập nhật truyện thành công!');
                        $('#content-after-edit-'+ rsp.id).empty();
                        $('#content-after-edit-'+ rsp.id).append(TruncateText(rsp.content));
                    },
                    error: function () {
                        location.reload();
                    }
                })
            })
        });

        //status
        $(document).ready(function () {
            $('.onoffswitch-checkbox').on('change', function () {
                if($(this).val() == 1 || $(this).val() == '1') {
                    $(this).val('0');
                } else {
                    $(this).val('1');
                }
                var status = $(this).val();
                var id = $(this).closest('tr').attr('id');
                console.log(id);
                $.ajax({
                    type:'POST',
                    url: '{{ route('ajax.editStatus') }}',
                    data: {"_token": "{{ csrf_token() }}",
                        'id':id,
                        'status':status},
                    dataType:'JSON',
                    success: function (rsp) {
                        alert('Cập nhật trạng thái thành công!');
                    },
                    error: function () {
                        location.reload();
                    }
                })

            });
        });
        setTimeout(function () {
            $('.mes-page').empty();
        }, 1500);
        //
    </script>
@endsection
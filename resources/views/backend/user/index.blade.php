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
    <div class="col-md-2 col-sm-2 col-xs-12">
        <div class="form-group">
            <a href="{{route('post.create')}}">
                <button class="btn btn-success"><span class="fa fa-plus"></span>&nbsp;&nbsp;Thêm Tài khoản</button>
            </a>
        </div>
        <div class="form-group">
            <a href="{{route('post.create')}}">
                <button class="btn btn-success"><span class="fa fa-plus"></span>&nbsp;&nbsp;Thêm Tài khoản</button>
            </a>
        </div>
        <div class="form-group">
            {{--<h5>@if(\Illuminate\Support\Facades\Auth::id() == $role_admin || \Illuminate\Support\Facades\Auth::id() == $role_leader) Có tất cả: <span style="color: pink"> {{$posts->total()}}</span></h5>--}}
            {{--<h5>Bạn có tất cả:<span style="color: pink"> {{(\App\Post::where('user_id', \Illuminate\Support\Facades\Auth::id())->count())}}</span></h5>@endif--}}
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
                        <th>Tên tài khoản</th>
                        <th>Thể loại</th>
                        <th>Nội dung</th>
                        <th>Nội dung ngắn</th>
                        {{--@if(\Illuminate\Support\Facades\Auth::id() == $role_admin || \Illuminate\Support\Facades\Auth::id() == $role_leader)--}}
                            {{--<th>Tác giả</th>--}}
                        {{--@endif--}}
                        <th>Trạng thái</th>
                        <th>Ngày đăng</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    {{--@foreach($posts as $key=>$post)--}}
                        {{--<tr id="{{$post->id}}" class="selected-page">--}}
                            {{--<td title="Ngày cập nhật truyện: {{$post->updated_at}}">{{$key+1}}</td>--}}
                            {{--<td>{{ str_limit($post->title, $limit = 100, $end='...') }}</td>--}}
                            {{--<td>{!! $post->Type()->first()->name !!}</td>--}}
                            {{--<td id="content-after-edit-{{$post->id}}" data-toggle="modal" data-target="#myModal-content-{{$key}}" title="Ấn để sửa..." style="cursor: pointer;">{!! str_limit($post->content, $limit = 100, $end = '...') !!}</td>--}}
                            {{--<td id="short-content-after-edit-{{$post->id}}" data-toggle="modal" data-target="#myModal-short-content-{{$key}}" title="Ấn để sửa..." style="cursor: pointer;">{!! str_limit($post->short_content, $limit=100, $end = '...') !!}</td>--}}
                            {{--@if(\Illuminate\Support\Facades\Auth::id() == $role_admin || \Illuminate\Support\Facades\Auth::id() == $role_leader)--}}
                                {{--<td>@foreach(App\User::select('name')->where('id', \Illuminate\Support\Facades\Auth::id())->get() as $val) {{$val->name}} @endforeach</td>--}}
                            {{--@endif--}}
                            {{--<td>--}}
                                {{--<div class="onoffswitch">--}}
                                    {{--<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch-{{$key}}" value="{{$post->status}}" {{$post->status == 1? 'checked':''}}>--}}
                                    {{--<label class="onoffswitch-label" for="myonoffswitch-{{$key}}">--}}
                                        {{--<span class="onoffswitch-inner"></span>--}}
                                        {{--<span class="onoffswitch-switch"></span>--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                            {{--</td>--}}
                            {{--<td>{{ $post->created_at }}</td>--}}
                            {{--<td>--}}
                                {{--<div>--}}
                                    {{--<a title="Xóa truyện" href="{{url('admin/post/delete/' . $post->id)}}" onclick="return window.confirm('Bạn muốn xóa?')"><span class="fa fa-trash"></span></a>--}}
                                {{--</div>--}}
                                {{--<div>--}}
                                    {{--<a title="Sửa truyện" href="{{url('admin/post/edit/' . $post->id)}}"><span class="fa fa-edit"></span></a>--}}
                                {{--</div>--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                        {{--<!-- Modal content-->--}}
                        {{--<div class="modal fade" id="myModal-content-{{$key}}" role="dialog">--}}
                            {{--<div class="modal-dialog modal-lg">--}}
                                {{--<div class="modal-content aj-form-page">--}}
                                    {{--<form>--}}
                                        {{--{{csrf_field()}}--}}
                                        {{--<div class="modal-header">--}}
                                            {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                                            {{--<h4 class="modal-title">Sửa Nội dung</h4>--}}
                                        {{--</div>--}}
                                        {{--<div class="modal-body">--}}
                                            {{--<textarea class="aj-text-page" name="content" id="content-{{$key}}">{!! ($post->content) !!}</textarea>--}}
                                        {{--</div>--}}
                                        {{--<div class="modal-footer">--}}
                                            {{--<button type="submit" data-id="{{$post->id}}" class="btn btn-default sm-content-page">Thay đổi</button>--}}
                                            {{--<button type="button" class="btn btn-success" data-dismiss="modal">Quay lại</button>--}}
                                        {{--</div>--}}
                                    {{--</form>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<!-- Modal short content-->--}}
                        {{--<div class="modal fade" id="myModal-short-content-{{$key}}" role="dialog">--}}
                            {{--<div class="modal-dialog modal-lg">--}}
                                {{--<div class="modal-content aj-form-page">--}}
                                    {{--<form>--}}
                                        {{--{{csrf_field()}}--}}
                                        {{--<div class="modal-header">--}}
                                            {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                                            {{--<h4 class="modal-title">Sửa Nội dung ngắn</h4>--}}
                                        {{--</div>--}}
                                        {{--<div class="modal-body">--}}
                                            {{--<textarea class="aj-text-page" name="short-content" id="short-content-{{$key}}">{!! ($post->short_content) !!}</textarea>--}}
                                        {{--</div>--}}
                                        {{--<div class="modal-footer">--}}
                                            {{--<button type="submit"  data-id="{{$post->id}}" class="btn btn-default sm-short-content-page">Thay đổi</button>--}}
                                            {{--<button type="button" class="btn btn-success" data-dismiss="modal">Quay lại</button>--}}
                                        {{--</div>--}}
                                    {{--</form>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--@endforeach--}}
                    </tbody>
                </table>
            </div>
        </div>
        {{--{!! $posts->render() !!}--}}
    </div>


@endsection

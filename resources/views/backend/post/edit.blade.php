@extends('layouts.backend')

@section('content')
    @if ($errors->any())
        <div class="mes-page" style="position: absolute;z-index: 1;opacity: 0.9;left: 30%">
            <div class="alert alert-danger">
                <ul>
                    <li><strong>Lỗi !</strong></li>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    <div class="col-md-3 col-sm-3">
        <a href="{{route('post')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span>&nbsp;&nbsp;Quay lại</button></a>
    </div>
    <div class="col-md-9 col-sm-9 col-xs-12">
        <fieldset class="form-group">
            <legend>Viết truyện</legend>
        </fieldset>
        <form method="POST" action="{{url('admin/post/postEdit/' . $post->id)}}">
            {{csrf_field()}}
            <div class="form-group">
                <label for="title">Tiêu đề</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Nhập tiêu đề" value="{{ $post->title }}" required>
            </div>
            <div class="form-group">
                <label for="short_content">Title seo</label>
                <input class="form-control" id="title_eo" name="title_seo" placeholder="Nhập title seo" value="{!! $post->title_seo !!}" required>
            </div>
            <div class="form-group">
                <label for="content">Nội dung</label>
                <textarea class="form-control" id="content" name="content_" placeholder="Nhập nội dung" required>{!! $post->content !!}</textarea>
            </div>
            <div class="form-group">
                <label for="type">Thể loại</label>
                <select class="form-control" id="type" name="type">
                    @foreach($types as $type)
                        <option value="{{$type->id}}" {{ $type->id==$post->type ? 'selected':'' }}>{{$type->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="status" {{ $post->status==1? 'checked value="1"':'' }}>
                    Trạng thái (Ẩn/hiện của bài viết)
                </label>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-default">Thay đổi</button>
                <button type="reset" class="btn btn-warning">Trạng thái ban đầu</button>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        CKEDITOR.replace('content');
    </script>
@endsection
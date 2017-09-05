@extends('layouts.backend')

@section('content')
    <div class="col-md-3 col-sm-3">
        <a href="{{route('post')}}"><button class="btn btn-success"><span class="fa fa-arrow-left"></span>&nbsp;&nbsp;Quay lại</button></a>
    </div>
    <div class="col-md-9 col-sm-9 col-xs-12">
        <fieldset class="form-group">
            <legend>Viết truyện</legend>
        </fieldset>
        <form method="POST" action="{{route('post.postCreate')}}">
            {{csrf_field()}}
            <div class="form-group">
                <label for="title">Tiêu đề</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Nhập tiêu đề" required>
            </div>
            <div class="form-group">
                <label for="short_content">Title seo</label>
                <input class="form-control" id="title_seo" name="title_seo" placeholder="Title seo" required>
            </div>
            <div class="form-group">
                <label for="content">Nội dung</label>
                <textarea class="form-control" id="content" name="content_" placeholder="Nhập nội dung" required></textarea>
            </div>
            <div class="form-group">
                <label for="type">Thể loại</label>
                <select class="form-control" id="type" name="type">
                    @foreach($types as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="status" checked value="1">
                    Trạng thái (Ẩn/hiện của bài viết)
                </label>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-default">Đăng bài</button>
                <button type="reset" class="btn btn-warning">Trạng thái rỗng</button>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
//        CKEDITOR.replace('short_content');
        CKEDITOR.replace('content');
        $(document).ready(function () {
            $('#title').on('keyup', function () {
                var title_seo = $(this).val();
                console.log(title_seo.replace(/ /g, '-'));
                $.ajax({
                    type:'POST',
                    url: '{{ route('ajax.validateTitleSeo') }}',
                    data: {"_token": "{{ csrf_token() }}",
                        'title_seo':title_seo},
                    dataType:'JSON',
                    success: function (rsp) {

                    },
                    error: function () {
                        location.reload();
                    },
                    timeout: 3000
                })
            });
        });
    </script>
@endsection
@extends('layouts.backend')
<?php $select_url = ['?', '/'];
$count_url = count($select_url);
?>
@section('title')
    Tool
@endsection
@section('content')
    <div class="col-md-3 col-sm-3 height_page">
        <a href="{{route('tool')}}">
            <button class="btn btn-success"><span class="fa fa-arrow-left"></span>&nbsp;&nbsp;Quay lại</button>
        </a>
    </div>
    <div class="col-md-9 col-sm-9 col-xs-12">
        <fieldset class="form-group">
            <legend>Tool truyện</legend>
        </fieldset>
        <form method="POST" action="{{route('tool.postCreate')}}">
            {{csrf_field()}}
            <div class="form-group">
                <label for="title">Tiêu đề</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Nhập tiêu đề" value="{{$title}}" required>
            </div>
            <div class="form-group">
                <label for="title_seo">Title seo</label>
                <input class="form-control" id="title_seo" name="title_seo" placeholder="Title seo" value="{{$title_seo}}" required>
            </div>
            <div class="form-group">
                <label for="content">Nội dung</label>
                <textarea class="form-control" id="content" name="content_" placeholder="Nhập nội dung"
                          required>{!! $body !!}</textarea>
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


        //short text search
        function shortTextSearch(text) {
            if (text.length > 30) {
                text = text.substring(0, 40) + "...";
            }
            return text;
        }

        //title seo
        CKEDITOR.replace('content');
        $(document).ready(function () {
            var timeout = null;
            $('#title, #title_seo').on('keyup', function () {
                clearTimeout(timeout);
                var title_seo = $(this).val();
                timeout = setTimeout(function () {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('ajax.validateTitleSeo') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'title_seo': title_seo
                        },
                        dataType: 'JSON',
                        timeout: 1000,
                        success: function (rsp) {
                            $('#title_seo').val(rsp);
                        },
                        error: function () {
                            location.reload();
                        }
                    })
                }, 800)
            });
        });

        setTimeout(function () {
            $('.mes-page').empty();
        }, 1500);

    </script>
@endsection
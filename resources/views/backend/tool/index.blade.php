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
    <div class="col-md-3 col-sm-3" style="overflow-y: scroll; height: auto">
        <div class="form-group">
            <div class="form-group">
                <h6>Hunter is my life:</h6>
            </div>
            <div class="form-group">
                <label for="short_content">Tìm kiếm site</label>
                <input type="url" class="form-control" id="search_site" placeholder="search" required>
            </div>
            <div class="form-group">
                <label for="short_content">Link truyện</label>
                <input type="url" class="form-control" id="get_content" placeholder="Link truyện" required>
            </div>
            <div class="form-inline">
                <div class="form-group">
                    <a href="#" title="Sẽ chuyển truyện sang phải">
                        <button class="btn btn-info">Lấy truyện&nbsp;&nbsp;<span class="fa fa-arrow-right"></span></button>
                    </a>
                </div>
                <div class="form-group">
                    <a href="#">
                        <button class="btn btn-info">Auto&nbsp;&nbsp;<span class="fa fa-bolt"></span></button>
                    </a>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="form-group">
                <h3 style="color: #9c3328"><span class="fa fa-cogs"></span>&nbsp;&nbsp;Config</h3>
            </div>
            <form method="Post" action="{{route('tool.siteStory')}}">
                {{csrf_field()}}
                {{--<div class="form-group">--}}
                    {{--<label for="site">Chọn site:</label>--}}
                    {{--<select class="form-control" id="site">--}}
                        {{--<option>...</option>--}}
                    {{--</select>--}}
                {{--</div>--}}
                <div class="form-group">
                    <label for="short_content">Chọn site hoặc thêm site</label>
                    <input type="url" class="form-control" id="start_content_code" placeholder="Site" required>
                </div>
                <hr>
                <div class="form-group">
                    <label for="short_content">Config start title code</label>
                    <input type="text" class="form-control" id="start_content_code" placeholder="Start title code" required>
                </div>
                <div class="form-group">
                    <label for="short_content">Config end title code</label>
                    <input type="text" class="form-control" id="end_title_code" placeholder="End title code" required>
                </div>
                <hr>
                <div class="form-group">
                    <label for="short_content">Config start content code</label>
                    <input type="text" class="form-control" id="start_content_code" placeholder="Start content code" required>
                </div>
                <div class="form-group">
                    <label for="short_content">Config end content code</label>
                    <input type="text" class="form-control" id="end_content_code" placeholder="End content code" required>
                </div>
                <div class="form-group">
                    <button class="btn btn-default" type="submit">Thay đổi hoặc thêm vào</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-9 col-sm-9 col-xs-12">
        <fieldset class="form-group">
            <legend>Tool truyện</legend>
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
                <textarea class="form-control" id="content" name="content_" placeholder="Nhập nội dung"
                          required></textarea>
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

        CKEDITOR.replace('content');
        $(document).ready(function () {
            var timeout = null;
            $('#title, #title_seo').on('keyup', function () {
                clearTimeout(timeout);
                var title_seo = $(this).val();
                console.log(title_seo.replace(/ /g, '-'));
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
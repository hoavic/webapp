@extends('coreblog::layouts.blog')

@section('post_title', 'Thông báo')

@section('content')

    <div class="entry-content content-box">

        @if (isset($status) && $status == 'success')

            <div class="m-6 text-center bg-green-50 text-green-900 border border-green-900 rounded-lg">
                <h2>Đã gửi thành công!</h2>
                <p>Chúng tôi sẽ liên hệ lại với bạn sớm nhất có thể!</p>
            </div>

        @else

            <div class="m-6 text-center bg-yellow-50 text-yellow-900 border border-yellow-900 rounded-lg">
                <h2>Đã xảy ra lỗi!</h2>
                <p>Vui lòng thử lại!</p>
            </div>

        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
            <div>{{$error}}</div>
            @endforeach
        @endif

    </div>

@endsection

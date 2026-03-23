@extends('frontend.layouts.app')

@section('title', 'Dịch vụ')

@section('content')
<div id="content" class="content">
    <div class="listbox">
        <div class="left">
            <div id="navi">
                <div class="navibox"><a href="{{ url('/') }}">Trang chủ</a> &nbsp;/&nbsp; <a href="{{ url('/dich-vu') }}" title="Dịch vụ">Dịch vụ</a></div>
            </div>
            <div class="pageintro">
                <p><strong>Dịch vụ của chúng tôi</strong></p>
                <p>– Tư vấn, giới thiệu cho thuê – bán kho, nhà xưởng, đất công nghiệp tại các tỉnh thành khu vực phía Bắc.</p>
                <p>– Nhận ký gửi, rao bán, cho thuê giúp khách hàng có nhu cầu quảng cáo bất động sản.</p>
                <p>– Làm thủ tục cấp phép đầu tư cho doanh nghiệp trong và ngoài nước nhanh chóng, giá rẻ.</p>
                <p>– Cam kết không thu bất cứ khoản chi phí nào từ khách hàng tìm thuê/mua.</p>
            </div>
        </div>
        @include('frontend.partials.sidebar-inner')
        <div class="clearfix"></div>
    </div>
</div>
@endsection

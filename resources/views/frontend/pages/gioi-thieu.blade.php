@extends('frontend.layouts.app')

@section('title', 'Giới thiệu')

@section('content')
<div id="content" class="content">
    <div class="listbox">
        <div class="left">
            <div id="navi">
                <div class="navibox"><a href="{{ url('/') }}">Trang chủ</a> &nbsp;/&nbsp; <a href="{{ url('/gioi-thieu') }}" title="Giới thiệu">Giới thiệu</a></div>
            </div>
            <div class="pageintro">
                <p><span style="font-size:14px;">Công ty Tư Vấn Đầu Tư Bất Động Sản Bảo Tín thành lập tháng 8 năm 2005, là một công ty chuyên dịch vụ tư vấn, cung cấp, giới thiệu cho thuê – bán kho, nhà xưởng, đất công nghiệp tại các tỉnh thành khu vực phía bắc như: Hà Nội, Hải Phòng, Hưng Yên, Hải Dương…</span></p>
                <p><span style="font-size:14px;">Với đội ngũ nhân viên giàu kinh nghiệm, nhiệt tình công ty Tư Vấn Đầu Tư Bất Động Sản Bảo Tín sẽ tư vấn và giúp các doanh nghiệp tìm được kho nhà xưởng đẹp, đạt tiêu chuẩn chất lượng, giá thành hợp lý nhằm đáp ứng yêu cầu và nhu cầu khác nhau của khách hàng.</span></p>
                <p><span style="font-size:14px;">Với phương châm lấy sự uy tín làm hàng đầu, đảm bảo 100% khách hàng hài lòng khi đã đến với chúng tôi, cam kết không thu bất cứ một khoản chi phí nào của khách hàng.</span></p>
                <p><span style="font-size:14px;">Ngoài dịch vụ cho thuê – bán kho, nhà xưởng đất ra chúng tôi còn nhận ký gửi, rao bán, cho thuê giúp cho khách hàng có nhu cầu muốn chúng tôi quảng cáo, làm thủ tục cấp phép đầu tư cho các doanh nghiệp trong và ngoài nước nhanh chóng, giá rẻ.</span></p>
                <p><a href="{{ url('/') }}"><span style="font-size:14px;"><strong>CHOTHUEXUONG.COM.VN</strong></span></a> <span style="font-size:14px;">là website thông tin hàng đầu về bất động sản công nghiệp.</span></p>
            </div>
        </div>
        @include('frontend.partials.sidebar-inner')
        <div class="clearfix"></div>
    </div>
</div>
@endsection

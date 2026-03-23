<?php

namespace Database\Seeders;

use App\Models\Inquiry;
use App\Models\Property;
use Illuminate\Database\Seeder;

class InquirySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $properties = Property::all();

        if ($properties->isEmpty()) {
            $this->command->error('Cần chạy PropertySeeder trước!');
            return;
        }

        $inquiries = [
            // Contact inquiries (liên hệ tổng quát)
            [
                'type' => 'contact',
                'name' => 'Nguyễn Văn An',
                'company' => 'Công ty TNHH Sản xuất ABC',
                'nationality' => 'Việt Nam',
                'address' => '123 Đường Lê Lợi, Quận 1, TP.HCM',
                'email' => 'nguyenvanan@abc.com.vn',
                'phone' => '0901234567',
                'message' => 'Tôi muốn tìm hiểu thêm về các nhà xưởng cho thuê tại khu vực Bình Dương. Vui lòng liên hệ lại với tôi.',
                'property_id' => null,
            ],
            [
                'type' => 'contact',
                'name' => 'John Smith',
                'company' => 'Global Manufacturing Co., Ltd',
                'nationality' => 'United States',
                'address' => '456 Broadway, New York, USA',
                'email' => 'john.smith@globalmanuf.com',
                'phone' => '+1234567890',
                'message' => 'We are looking for factory space around 3000-5000 sqm in northern Vietnam. Please contact us with available options.',
                'property_id' => null,
            ],
            [
                'type' => 'contact',
                'name' => 'Trần Thị Bình',
                'company' => 'Công ty Logistics Miền Bắc',
                'nationality' => 'Việt Nam',
                'address' => '789 Phố Huế, Hai Bà Trưng, Hà Nội',
                'email' => 'tranthibinh@logistics.vn',
                'phone' => '0912345678',
                'message' => 'Chúng tôi cần thuê kho bãi gần cảng để lưu trữ hàng hóa xuất nhập khẩu. Diện tích khoảng 2000m².',
                'property_id' => null,
            ],
            [
                'type' => 'contact',
                'name' => '李明',
                'company' => '上海工業有限公司',
                'nationality' => 'China',
                'address' => '上海市浦东新区',
                'email' => 'liming@shanghai-industry.cn',
                'phone' => '+86-13800138000',
                'message' => '我们计划在越南开设工厂，需要了解租赁流程和优惠政策。',
                'property_id' => null,
            ],
            [
                'type' => 'contact',
                'name' => 'Park Min-ho',
                'company' => 'Korea Electronics Vietnam',
                'nationality' => 'South Korea',
                'address' => 'Seoul, South Korea',
                'email' => 'park.minho@koreaelec.kr',
                'phone' => '+82-10-1234-5678',
                'message' => 'We need factory with clean room for electronics manufacturing. Please send us information.',
                'property_id' => null,
            ],

            // Request inquiries (yêu cầu xem property cụ thể)
            [
                'type' => 'request',
                'name' => 'Lê Văn Cường',
                'company' => 'Công ty May mặc Hà Đông',
                'nationality' => 'Việt Nam',
                'address' => '234 Quang Trung, Hà Đông, Hà Nội',
                'email' => 'levancuong@hadonggarment.vn',
                'phone' => '0923456789',
                'message' => 'Tôi quan tâm đến nhà xưởng này. Vui lòng sắp xếp lịch để tôi được xem trực tiếp.',
                'property_id' => $properties->random()->id,
            ],
            [
                'type' => 'request',
                'name' => 'Phạm Thị Dung',
                'company' => 'Công ty Thực phẩm Sạch VN',
                'nationality' => 'Việt Nam',
                'address' => '567 Nguyễn Trãi, Thanh Xuân, Hà Nội',
                'email' => 'phamthidung@cleanfood.vn',
                'phone' => '0934567890',
                'message' => 'Kho lạnh này có phù hợp với tiêu chuẩn thực phẩm không? Chúng tôi muốn đến xem và thảo luận chi tiết.',
                'property_id' => $properties->random()->id,
            ],
            [
                'type' => 'request',
                'name' => 'David Johnson',
                'company' => 'Tech Solutions Inc',
                'nationality' => 'United Kingdom',
                'address' => 'London, United Kingdom',
                'email' => 'david.johnson@techsolutions.co.uk',
                'phone' => '+44-20-1234-5678',
                'message' => 'This property looks perfect for our needs. Can we schedule a viewing next week?',
                'property_id' => $properties->random()->id,
            ],
            [
                'type' => 'request',
                'name' => 'Hoàng Minh Tuấn',
                'company' => 'Công ty Cơ khí Chính xác',
                'nationality' => 'Việt Nam',
                'address' => '890 Lê Văn Việt, Quận 9, TP.HCM',
                'email' => 'hoangtuan@precision.vn',
                'phone' => '0945678901',
                'message' => 'Nhà xưởng có cầu trục không? Chúng tôi cần lắp đặt máy móc nặng. Xin báo giá chi tiết.',
                'property_id' => $properties->random()->id,
            ],
            [
                'type' => 'request',
                'name' => 'Tanaka Hiroshi',
                'company' => 'Nippon Auto Parts Vietnam',
                'nationality' => 'Japan',
                'address' => 'Tokyo, Japan',
                'email' => 'tanaka@nipponauto.jp',
                'phone' => '+81-3-1234-5678',
                'message' => 'This factory meets our requirements. Please provide detailed quotation and contract terms.',
                'property_id' => $properties->random()->id,
            ],
            [
                'type' => 'request',
                'name' => 'Vũ Thị Hoa',
                'company' => 'Công ty Dược phẩm Việt',
                'nationality' => 'Việt Nam',
                'address' => '123 Phạm Văn Đồng, Bắc Từ Liêm, Hà Nội',
                'email' => 'vuthihoa@vietpharma.vn',
                'phone' => '0956789012',
                'message' => 'Chúng tôi cần xem nhà xưởng này để đánh giá khả năng đáp ứng GMP. Khi nào thuận tiện?',
                'property_id' => $properties->random()->id,
            ],
            [
                'type' => 'request',
                'name' => 'Chen Wei',
                'company' => 'Taiwan Electronics Manufacturing',
                'nationality' => 'Taiwan',
                'address' => 'Taipei, Taiwan',
                'email' => 'chen.wei@taiwanelec.tw',
                'phone' => '+886-2-2345-6789',
                'message' => 'Interested in this property. Need to know power capacity and air conditioning specifications.',
                'property_id' => $properties->random()->id,
            ],
            [
                'type' => 'request',
                'name' => 'Đỗ Văn Kiên',
                'company' => 'Công ty Nhựa Đại Phát',
                'nationality' => 'Việt Nam',
                'address' => '456 Đường 30/4, Thuận An, Bình Dương',
                'email' => 'dovankien@daiphatplastic.vn',
                'phone' => '0967890123',
                'message' => 'Nhà xưởng này có thể thuê ngay không? Chúng tôi cần vào hoạt động trong tháng tới.',
                'property_id' => $properties->random()->id,
            ],
            [
                'type' => 'request',
                'name' => 'Michael Brown',
                'company' => 'European Logistics Vietnam',
                'nationality' => 'Germany',
                'address' => 'Berlin, Germany',
                'email' => 'michael.brown@eurolog.de',
                'phone' => '+49-30-1234-5678',
                'message' => 'Your warehouse location is excellent. Can you provide information about loading docks and truck access?',
                'property_id' => $properties->random()->id,
            ],
            [
                'type' => 'request',
                'name' => 'Ngô Thị Lan',
                'company' => 'Công ty Xuất nhập khẩu Hải Dương',
                'nationality' => 'Việt Nam',
                'address' => '789 Tôn Đức Thắng, Đống Đa, Hà Nội',
                'email' => 'ngothilan@haiduongtrade.vn',
                'phone' => '0978901234',
                'message' => 'Mặt bằng này có phù hợp để làm showroom không? Tôi muốn xem và trao đổi thêm.',
                'property_id' => $properties->random()->id,
            ],
        ];

        foreach ($inquiries as $inquiry) {
            Inquiry::create($inquiry);
        }

        $this->command->info('Đã tạo ' . count($inquiries) . ' inquiries!');
    }
}

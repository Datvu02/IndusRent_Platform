<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            ['province' => 'Hà Nội', 'province_en' => 'Hanoi', 'province_zh' => '河内', 'district' => 'Quận Hoàn Kiếm', 'district_en' => 'Hoan Kiem District', 'district_zh' => '还剑郡', 'ward' => 'Phường Hàng Bạc', 'ward_en' => 'Hang Bac Ward', 'ward_zh' => '行钵坊'],
            ['province' => 'Hà Nội', 'province_en' => 'Hanoi', 'province_zh' => '河内', 'district' => 'Quận Hoàn Kiếm', 'district_en' => 'Hoan Kiem District', 'district_zh' => '还剑郡', 'ward' => 'Phường Hàng Gai', 'ward_en' => 'Hang Gai Ward', 'ward_zh' => '行该坊'],
            ['province' => 'Hà Nội', 'province_en' => 'Hanoi', 'province_zh' => '河内', 'district' => 'Quận Hai Bà Trưng', 'district_en' => 'Hai Ba Trung District', 'district_zh' => '二征夫人郡', 'ward' => 'Phường Bách Khoa', 'ward_en' => 'Bach Khoa Ward', 'ward_zh' => '百科坊'],
            ['province' => 'Hà Nội', 'province_en' => 'Hanoi', 'province_zh' => '河内', 'district' => 'Quận Long Biên', 'district_en' => 'Long Bien District', 'district_zh' => '龙编郡', 'ward' => 'Phường Giang Biên', 'ward_en' => 'Giang Bien Ward', 'ward_zh' => '江编坊'],
            ['province' => 'Hà Nội', 'province_en' => 'Hanoi', 'province_zh' => '河内', 'district' => 'Quận Cầu Giấy', 'district_en' => 'Cau Giay District', 'district_zh' => '桥纸郡', 'ward' => 'Phường Dịch Vọng', 'ward_en' => 'Dich Vong Ward', 'ward_zh' => '译望坊'],
            
            ['province' => 'TP. Hồ Chí Minh', 'province_en' => 'Ho Chi Minh City', 'province_zh' => '胡志明市', 'district' => 'Quận 1', 'district_en' => 'District 1', 'district_zh' => '第一郡', 'ward' => 'Phường Bến Nghé', 'ward_en' => 'Ben Nghe Ward', 'ward_zh' => '滨艺坊'],
            ['province' => 'TP. Hồ Chí Minh', 'province_en' => 'Ho Chi Minh City', 'province_zh' => '胡志明市', 'district' => 'Quận 1', 'district_en' => 'District 1', 'district_zh' => '第一郡', 'ward' => 'Phường Bến Thành', 'ward_en' => 'Ben Thanh Ward', 'ward_zh' => '滨城坊'],
            ['province' => 'TP. Hồ Chí Minh', 'province_en' => 'Ho Chi Minh City', 'province_zh' => '胡志明市', 'district' => 'Quận 7', 'district_en' => 'District 7', 'district_zh' => '第七郡', 'ward' => 'Phường Tân Phú', 'ward_en' => 'Tan Phu Ward', 'ward_zh' => '新富坊'],
            ['province' => 'TP. Hồ Chí Minh', 'province_en' => 'Ho Chi Minh City', 'province_zh' => '胡志明市', 'district' => 'Quận 9', 'district_en' => 'District 9', 'district_zh' => '第九郡', 'ward' => 'Phường Long Trường', 'ward_en' => 'Long Truong Ward', 'ward_zh' => '隆场坊'],
            ['province' => 'TP. Hồ Chí Minh', 'province_en' => 'Ho Chi Minh City', 'province_zh' => '胡志明市', 'district' => 'Quận Bình Thạnh', 'district_en' => 'Binh Thanh District', 'district_zh' => '平盛郡', 'ward' => 'Phường 1', 'ward_en' => 'Ward 1', 'ward_zh' => '第1坊'],
            ['province' => 'TP. Hồ Chí Minh', 'province_en' => 'Ho Chi Minh City', 'province_zh' => '胡志明市', 'district' => 'Quận Thủ Đức', 'district_en' => 'Thu Duc District', 'district_zh' => '守德郡', 'ward' => 'Phường Linh Trung', 'ward_en' => 'Linh Trung Ward', 'ward_zh' => '灵中坊'],
            
            ['province' => 'Đà Nẵng', 'province_en' => 'Da Nang', 'province_zh' => '岘港', 'district' => 'Quận Hải Châu', 'district_en' => 'Hai Chau District', 'district_zh' => '海州郡', 'ward' => 'Phường Thanh Bình', 'ward_en' => 'Thanh Binh Ward', 'ward_zh' => '清平坊'],
            ['province' => 'Đà Nẵng', 'province_en' => 'Da Nang', 'province_zh' => '岘港', 'district' => 'Quận Thanh Khê', 'district_en' => 'Thanh Khe District', 'district_zh' => '清溪郡', 'ward' => 'Phường Tân Chính', 'ward_en' => 'Tan Chinh Ward', 'ward_zh' => '新政坊'],
            
            ['province' => 'Bình Dương', 'province_en' => 'Binh Duong', 'province_zh' => '平阳', 'district' => 'Thành phố Thủ Dầu Một', 'district_en' => 'Thu Dau Mot City', 'district_zh' => '土龙木市', 'ward' => 'Phường Phú Hòa', 'ward_en' => 'Phu Hoa Ward', 'ward_zh' => '富和坊'],
            ['province' => 'Bình Dương', 'province_en' => 'Binh Duong', 'province_zh' => '平阳', 'district' => 'Thành phố Dĩ An', 'district_en' => 'Di An City', 'district_zh' => '以安市', 'ward' => 'Phường Dĩ An', 'ward_en' => 'Di An Ward', 'ward_zh' => '以安坊'],
            ['province' => 'Bình Dương', 'province_en' => 'Binh Duong', 'province_zh' => '平阳', 'district' => 'Thành phố Thuận An', 'district_en' => 'Thuan An City', 'district_zh' => '顺安市', 'ward' => 'Phường An Phú', 'ward_en' => 'An Phu Ward', 'ward_zh' => '安富坊'],
            
            ['province' => 'Đồng Nai', 'province_en' => 'Dong Nai', 'province_zh' => '同奈', 'district' => 'Thành phố Biên Hòa', 'district_en' => 'Bien Hoa City', 'district_zh' => '边和市', 'ward' => 'Phường Trảng Dài', 'ward_en' => 'Trang Dai Ward', 'ward_zh' => '长带坊'],
            ['province' => 'Đồng Nai', 'province_en' => 'Dong Nai', 'province_zh' => '同奈', 'district' => 'Huyện Nhơn Trạch', 'district_en' => 'Nhon Trach District', 'district_zh' => '仁泽县', 'ward' => 'Xã Phước Thiền', 'ward_en' => 'Phuoc Thien Commune', 'ward_zh' => '福禅社'],
            ['province' => 'Đồng Nai', 'province_en' => 'Dong Nai', 'province_zh' => '同奈', 'district' => 'Huyện Long Thành', 'district_en' => 'Long Thanh District', 'district_zh' => '龙城县', 'ward' => 'Xã Long Đức', 'ward_en' => 'Long Duc Commune', 'ward_zh' => '隆德社'],
            
            ['province' => 'Hải Phòng', 'province_en' => 'Hai Phong', 'province_zh' => '海防', 'district' => 'Quận Hồng Bàng', 'district_en' => 'Hong Bang District', 'district_zh' => '鸿庞郡', 'ward' => 'Phường Quán Toan', 'ward_en' => 'Quan Toan Ward', 'ward_zh' => '官滩坊'],
            ['province' => 'Hải Phòng', 'province_en' => 'Hai Phong', 'province_zh' => '海防', 'district' => 'Huyện An Dương', 'district_en' => 'An Duong District', 'district_zh' => '安阳县', 'ward' => 'Xã An Hồng', 'ward_en' => 'An Hong Commune', 'ward_zh' => '安红社'],
        ];

        foreach ($locations as $location) {
            $slug = Str::slug($location['province'] . ' ' . $location['district'] . ' ' . ($location['ward'] ?? ''));
            
            DB::table('locations')->updateOrInsert(
                ['slug' => $slug],
                array_merge($location, [
                    'slug' => $slug,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }

        $this->command->info('Đã tạo ' . count($locations) . ' locations với phường/xã!');
    }
}

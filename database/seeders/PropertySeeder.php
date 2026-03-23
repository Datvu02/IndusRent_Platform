<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $propertyTypes = PropertyType::all();
        $locations = Location::all();

        if ($propertyTypes->isEmpty() || $locations->isEmpty()) {
            $this->command->error('Cần chạy migration seed PropertyTypes và Locations trước!');
            return;
        }

        $properties = [
            // Nhà xưởng cho thuê
            [
                'title' => 'Nhà xưởng 2000m² tại KCN Thăng Long - Hà Nội',
                'title_en' => '2000m² Factory for Rent in Thang Long Industrial Park - Hanoi',
                'title_zh' => '河内升龙工业园2000平米厂房出租',
                'description' => 'Nhà xưởng có diện tích 2000m², xây dựng kiên cố, có cầu trục 5 tấn. Hệ thống điện 3 pha, nước sạch đầy đủ. Vị trí thuận lợi gần cổng KCN.',
                'description_en' => 'Factory with 2000m² area, solid construction, 5-ton crane. Complete with 3-phase electricity and clean water. Convenient location near industrial park gate.',
                'description_zh' => '厂房面积2000平米，坚固建筑，配有5吨起重机。三相电，清洁水供应齐全。位置便利，靠近工业园大门。',
                'area' => 2000,
                'price' => 80000000,
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'title' => 'Xưởng sản xuất 5000m² tại Bình Dương có điện 3 pha',
                'title_en' => '5000m² Production Factory in Binh Duong with 3-phase Electricity',
                'title_zh' => '平阳5000平米生产厂房，配三相电',
                'description' => 'Nhà xưởng mới xây dựng, diện tích 5000m², nền bê tông cốt thép. Hệ thống PCCC đầy đủ, có mái che nắng, thoáng mát. Điện dung 500 KVA.',
                'description_en' => 'Newly built factory, 5000m² area, reinforced concrete floor. Complete fire protection system, sun-shaded roof, well-ventilated. 500 KVA power capacity.',
                'description_zh' => '新建厂房，面积5000平米，钢筋混凝土地面。消防系统齐全，遮阳屋顶，通风良好。电力容量500千伏安。',
                'area' => 5000,
                'price' => 180000000,
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'title' => 'Nhà xưởng 1500m² KCN Vsip - Bắc Ninh',
                'title_en' => '1500m² Factory in VSIP Industrial Park - Bac Ninh',
                'title_zh' => '北宁VSIP工业园1500平米厂房',
                'description' => 'Nhà xưởng tại KCN VSIP, sẵn hệ thống điện nước. Mái tôn cách nhiệt, nền nhà cứng. Có phòng làm việc, toilet riêng. Giá hợp lý.',
                'description_en' => 'Factory in VSIP Industrial Park, ready water & electricity system. Insulated metal roof, solid floor. Includes office room and private toilet. Reasonable price.',
                'description_zh' => 'VSIP工业园厂房，水电系统齐全。隔热金属屋顶，地面坚固。配办公室和独立卫生间。价格合理。',
                'area' => 1500,
                'price' => 55000000,
                'is_featured' => false,
                'is_published' => true,
            ],

            // Kho cho thuê
            [
                'title' => 'Kho bãi 3000m² gần cảng Hải Phòng',
                'title_en' => '3000m² Warehouse near Hai Phong Port',
                'title_zh' => '海防港附近3000平米仓库',
                'description' => 'Kho bãi rộng 3000m², gần cảng Hải Phòng, thuận tiện xuất nhập khẩu. Có bãi xe lớn, bảo vệ 24/7. Nền bê tông, cao 8m.',
                'description_en' => 'Large 3000m² warehouse near Hai Phong port, convenient for import/export. Large parking area, 24/7 security. Concrete floor, 8m height.',
                'description_zh' => '大型仓库3000平米，靠近海防港，便于进出口。大型停车场，24小时保安。混凝土地面，高度8米。',
                'area' => 3000,
                'price' => 90000000,
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'title' => 'Kho lạnh 1000m² tại Long Biên - Hà Nội',
                'title_en' => '1000m² Cold Storage in Long Bien - Hanoi',
                'title_zh' => '河内龙编1000平米冷库',
                'description' => 'Kho lạnh chuyên dụng, nhiệt độ -18°C, diện tích 1000m². Hệ thống làm lạnh hiện đại. Phù hợp kinh doanh thực phẩm đông lạnh.',
                'description_en' => 'Professional cold storage, -18°C temperature, 1000m² area. Modern cooling system. Suitable for frozen food business.',
                'description_zh' => '专业冷库，温度-18°C，面积1000平米。现代冷却系统。适合冷冻食品业务。',
                'area' => 1000,
                'price' => 120000000,
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'title' => 'Kho hàng 2500m² tại Đồng Nai có dốc xe',
                'title_en' => '2500m² Warehouse in Dong Nai with Loading Ramp',
                'title_zh' => '同奈2500平米仓库，配装卸坡道',
                'description' => 'Kho hàng có dốc xe container, diện tích 2500m². Nền cứng cáp, trần cao 10m. Có văn phòng kèm theo. An ninh tốt.',
                'description_en' => 'Warehouse with container loading ramp, 2500m² area. Solid floor, 10m ceiling height. Office included. Good security.',
                'description_zh' => '配集装箱装卸坡道的仓库，面积2500平米。地面坚固，天花板高10米。含办公室。安保良好。',
                'area' => 2500,
                'price' => 75000000,
                'is_featured' => false,
                'is_published' => true,
            ],

            // Mặt bằng cho thuê
            [
                'title' => 'Mặt bằng 500m² mặt tiền đường lớn Q.1 - TP.HCM',
                'title_en' => '500m² Ground Floor on Main Street D1 - HCMC',
                'title_zh' => '胡志明市第一郡大街500平米临街店面',
                'description' => 'Mặt bằng kinh doanh mặt tiền đường Nguyễn Huệ, quận 1. Vị trí đắc địa, phù hợp mở showroom, cửa hàng. Có chỗ đỗ xe.',
                'description_en' => 'Commercial space on Nguyen Hue Street, District 1. Prime location, suitable for showroom, store. Parking available.',
                'description_zh' => '第一郡阮惠街商业店面。黄金位置，适合开展厅、商店。有停车位。',
                'area' => 500,
                'price' => 200000000,
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'title' => 'Mặt bằng 300m² khu văn phòng Cầu Giấy',
                'title_en' => '300m² Office Space in Cau Giay Area',
                'title_zh' => '桥纸区300平米办公空间',
                'description' => 'Mặt bằng tầng trệt, diện tích 300m². Đã hoàn thiện nội thất cơ bản. Điều hòa trung tâm, thang máy. Bảo vệ 24/7.',
                'description_en' => 'Ground floor space, 300m² area. Basic interior completed. Central air conditioning, elevator. 24/7 security.',
                'description_zh' => '一楼空间，面积300平米。基本装修完成。中央空调，电梯。24小时保安。',
                'area' => 300,
                'price' => 45000000,
                'is_featured' => false,
                'is_published' => true,
            ],

            // Đất bán
            [
                'title' => 'Đất công nghiệp 10.000m² tại KCN Vsip Hưng Yên',
                'title_en' => '10,000m² Industrial Land in VSIP Hung Yen',
                'title_zh' => '兴安VSIP工业园10000平米工业用地',
                'description' => 'Lô đất công nghiệp mặt tiền đường chính KCN Vsip. Đã có sổ đỏ, đầy đủ hạ tầng. Vị trí đẹp, giá tốt để đầu tư xây dựng nhà xưởng.',
                'description_en' => 'Industrial land plot on main road of VSIP. Red book certificate, complete infrastructure. Beautiful location, good price for factory construction investment.',
                'description_zh' => 'VSIP主干道工业用地。已有红本，基础设施齐全。位置优越，投资建厂价格合理。',
                'area' => 10000,
                'price' => 5000000000,
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'title' => 'Đất 15.000m² gần sân bay Long Thành - Đồng Nai',
                'title_en' => '15,000m² Land near Long Thanh Airport - Dong Nai',
                'title_zh' => '同奈龙城机场附近15000平米土地',
                'description' => 'Lô đất vị trí đắc địa, cách sân bay Long Thành 5km. Thích hợp xây kho bãi, logistics. Giá đầu tư hấp dẫn.',
                'description_en' => 'Prime location land, 5km from Long Thanh airport. Suitable for warehouse, logistics construction. Attractive investment price.',
                'description_zh' => '黄金地段土地，距龙城机场5公里。适合建设仓库、物流。投资价格有吸引力。',
                'area' => 15000,
                'price' => 12000000000,
                'is_featured' => true,
                'is_published' => true,
            ],

            // Nhà xưởng bán
            [
                'title' => 'Nhà xưởng 3500m² có sẵn giấy phép xây dựng - Bình Dương',
                'title_en' => '3500m² Factory with Construction Permit - Binh Duong',
                'title_zh' => '平阳3500平米厂房，已有建筑许可证',
                'description' => 'Nhà xưởng xây dựng năm 2020, kết cấu khung thép. Có đầy đủ giấy tờ pháp lý, sổ đỏ riêng. Giá chuyển nhượng tốt.',
                'description_en' => 'Factory built in 2020, steel frame structure. Complete legal documents, separate red book. Good transfer price.',
                'description_zh' => '2020年建厂房，钢结构框架。法律文件齐全，独立红本。转让价格合理。',
                'area' => 3500,
                'price' => 18000000000,
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'Nhà xưởng 8000m² có sẵn máy móc thiết bị tại Thủ Dầu Một',
                'title_en' => '8000m² Factory with Machinery in Thu Dau Mot',
                'title_zh' => '土龙木8000平米厂房，配机械设备',
                'description' => 'Nhà xưởng 2 tầng diện tích 8000m². Có sẵn hệ thống máy móc ngành may mặc. Giá bán đã bao gồm toàn bộ thiết bị.',
                'description_en' => '2-story factory with 8000m² area. Includes complete garment machinery system. Sale price includes all equipment.',
                'description_zh' => '二层厂房面积8000平米。配备完整的服装机械系统。售价包含全部设备。',
                'area' => 8000,
                'price' => 35000000000,
                'is_featured' => true,
                'is_published' => true,
            ],

            // Thêm properties không featured
            [
                'title' => 'Nhà xưởng 1200m² tại Văn Lâm - Hưng Yên',
                'title_en' => '1200m² Factory in Van Lam - Hung Yen',
                'title_zh' => '兴安文林1200平米厂房',
                'description' => 'Nhà xưởng mới xây, diện tích 1200m². Đầy đủ điện nước, có khu văn phòng riêng. Giá thuê hợp lý.',
                'description_en' => 'Newly built factory, 1200m² area. Complete water & electricity, separate office area. Reasonable rent.',
                'description_zh' => '新建厂房，面积1200平米。水电齐全，独立办公区。租金合理。',
                'area' => 1200,
                'price' => 40000000,
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'Kho 800m² tại Thanh Khê - Đà Nẵng',
                'title_en' => '800m² Warehouse in Thanh Khe - Da Nang',
                'title_zh' => '岘港清溪800平米仓库',
                'description' => 'Kho nhỏ gọn diện tích 800m², phù hợp lưu kho hàng hóa thông thường. Có bảo vệ, camera an ninh.',
                'description_en' => 'Compact warehouse 800m² area, suitable for general goods storage. Security guard, CCTV cameras.',
                'description_zh' => '紧凑型仓库面积800平米，适合一般货物存储。有保安、监控摄像头。',
                'area' => 800,
                'price' => 25000000,
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'Mặt bằng 400m² tại Quận 7 - TP.HCM',
                'title_en' => '400m² Ground Floor in District 7 - HCMC',
                'title_zh' => '胡志明市第七郡400平米店面',
                'description' => 'Mặt bằng góc 2 mặt tiền, diện tích 400m². Thích hợp kinh doanh nhà hàng, cafe, showroom. Vị trí đông dân cư.',
                'description_en' => 'Corner space with 2 frontages, 400m² area. Suitable for restaurant, cafe, showroom. Densely populated area.',
                'description_zh' => '转角双临街店面，面积400平米。适合餐厅、咖啡厅、展厅。人口密集区域。',
                'area' => 400,
                'price' => 85000000,
                'is_featured' => false,
                'is_published' => true,
            ],
        ];

        foreach ($properties as $propertyData) {
            // Random type and location
            $type = $propertyTypes->random();
            $location = $locations->random();
            
            $slug = Str::slug($propertyData['title']);
            
            // Ensure unique slug
            $originalSlug = $slug;
            $counter = 1;
            while (Property::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            Property::create([
                'title' => $propertyData['title'],
                'title_en' => $propertyData['title_en'],
                'title_zh' => $propertyData['title_zh'],
                'slug' => $slug,
                'description' => $propertyData['description'],
                'description_en' => $propertyData['description_en'],
                'description_zh' => $propertyData['description_zh'],
                'type_id' => $type->id,
                'location_id' => $location->id,
                'price' => $propertyData['price'],
                'area' => $propertyData['area'],
                'main_image' => 'images/properties/default-' . rand(1, 5) . '.jpg',
                'gallery' => [
                    'images/properties/gallery-1.jpg',
                    'images/properties/gallery-2.jpg',
                    'images/properties/gallery-3.jpg',
                ],
                'is_featured' => $propertyData['is_featured'],
                'is_published' => $propertyData['is_published'],
            ]);
        }

        $this->command->info('Đã tạo ' . count($properties) . ' properties!');
    }
}

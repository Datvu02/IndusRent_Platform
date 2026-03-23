<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Slider;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        $sliders = [
            [
                "title" => "Cho thuê nhà xưởng uy tín tại Việt Nam",
                "title_en" => "Trusted Industrial Property Rental in Vietnam",
                "title_zh" => "越南值得信赖的工业地产租赁",
                "description" => "Hệ thống nhà xưởng chất lượng cao, đa dạng diện tích",
                "description_en" => "High-quality factory system with diverse areas",
                "description_zh" => "高品质工厂系统，面积多样",
                "image" => "sliders/slide1.jpg",
                "link" => null,
                "order" => 1,
                "is_active" => true,
            ],
            [
                "title" => "Kho bãi hiện đại - Giá cạnh tranh",
                "title_en" => "Modern Warehouse - Competitive Price",
                "title_zh" => "现代仓库 - 竞争价格",
                "description" => "Kho bãi đạt tiêu chuẩn quốc tế, vị trí đắc địa",
                "description_en" => "International standard warehouse, prime location",
                "description_zh" => "国际标准仓库，黄金地段",
                "image" => "sliders/slide2.jpg",
                "link" => null,
                "order" => 2,
                "is_active" => true,
            ],
            [
                "title" => "Đất công nghiệp - Sẵn sàng đầu tư",
                "title_en" => "Industrial Land - Ready for Investment",
                "title_zh" => "工业用地 - 准备投资",
                "description" => "Đất công nghiệp pháp lý rõ ràng, hạ tầng hoàn thiện",
                "description_en" => "Clear legal industrial land with complete infrastructure",
                "description_zh" => "合法工业用地，基础设施完善",
                "image" => "sliders/slide3.jpg",
                "link" => null,
                "order" => 3,
                "is_active" => true,
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::updateOrCreate(
                ["title" => $slider["title"]],
                $slider
            );
        }

        $this->command->info("Đã tạo " . count($sliders) . " sliders!");
    }
}

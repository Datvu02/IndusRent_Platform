<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $newsArticles = [
            [
                'title' => 'Thị trường bất động sản công nghiệp 2026: Xu hướng và cơ hội',
                'title_en' => 'Industrial Real Estate Market 2026: Trends and Opportunities',
                'title_zh' => '2026年工业房地产市场：趋势与机遇',
                'content' => '<p>Thị trường bất động sản công nghiệp Việt Nam đang có những dấu hiệu tích cực trong năm 2026. Theo báo cáo mới nhất, nhu cầu thuê nhà xưởng và kho bãi tăng mạnh, đặc biệt tại các khu công nghiệp ở Bắc Ninh, Bình Dương, và Đồng Nai.</p><p>Các chuyên gia dự báo xu hướng phát triển logistics sẽ tiếp tục tăng trưởng, cùng với sự chuyển dịch của các nhà đầu tư nước ngoài sang Việt Nam. Giá thuê dự kiến ổn định và có thể tăng nhẹ 5-8% so với năm 2025.</p><p>Đây là thời điểm tốt để các nhà đầu tư tìm kiếm cơ hội đầu tư vào bất động sản công nghiệp tại Việt Nam.</p>',
                'content_en' => '<p>Vietnam\'s industrial real estate market is showing positive signs in 2026. According to the latest report, demand for factory and warehouse rentals is increasing strongly, especially in industrial parks in Bac Ninh, Binh Duong, and Dong Nai.</p><p>Experts predict that logistics development trends will continue to grow, along with the shift of foreign investors to Vietnam. Rental prices are expected to remain stable and may increase slightly by 5-8% compared to 2025.</p><p>This is a good time for investors to seek investment opportunities in industrial real estate in Vietnam.</p>',
                'content_zh' => '<p>越南工业房地产市场在2026年呈现积极信号。根据最新报告，厂房和仓库租赁需求强劲增长，特别是在北宁、平阳和同奈的工业园区。</p><p>专家预测物流发展趋势将持续增长，外国投资者向越南转移。预计租金价格将保持稳定，可能比2025年略微增长5-8%。</p><p>这是投资者寻求越南工业房地产投资机会的好时机。</p>',
            ],
            [
                'title' => 'Top 5 khu công nghiệp hấp dẫn nhất phía Bắc 2026',
                'title_en' => 'Top 5 Most Attractive Industrial Parks in Northern Vietnam 2026',
                'title_zh' => '2026年越南北部最具吸引力的5大工业园区',
                'content' => '<p>Dưới đây là danh sách 5 khu công nghiệp được đánh giá cao nhất tại miền Bắc Việt Nam năm 2026:</p><ol><li><strong>KCN Vsip Bắc Ninh:</strong> Hạ tầng hoàn thiện, nhiều ưu đãi đầu tư</li><li><strong>KCN Thăng Long - Hà Nội:</strong> Vị trí gần trung tâm, giao thông thuận lợi</li><li><strong>KCN Nomura Hải Phòng:</strong> Gần cảng biển, thuận tiện xuất nhập khẩu</li><li><strong>KCN Deep C Hải Phòng:</strong> Tiêu chuẩn quốc tế, môi trường xanh</li><li><strong>KCN Yên Phong - Bắc Ninh:</strong> Giá thuê hợp lý, nhiều nhà đầu tư Nhật Bản</li></ol><p>Các khu công nghiệp này đều có hạ tầng tốt, chính sách ưu đãi hấp dẫn và đang thu hút nhiều dự án FDI.</p>',
                'content_en' => '<p>Here is the list of the 5 most highly rated industrial parks in Northern Vietnam in 2026:</p><ol><li><strong>VSIP Bac Ninh IP:</strong> Complete infrastructure, many investment incentives</li><li><strong>Thang Long IP - Hanoi:</strong> Close to city center, convenient transportation</li><li><strong>Nomura Hai Phong IP:</strong> Near seaport, convenient for import/export</li><li><strong>Deep C Hai Phong IP:</strong> International standards, green environment</li><li><strong>Yen Phong IP - Bac Ninh:</strong> Reasonable rental prices, many Japanese investors</li></ol><p>These industrial parks all have good infrastructure, attractive incentive policies and are attracting many FDI projects.</p>',
                'content_zh' => '<p>以下是2026年越南北部评价最高的5个工业园区：</p><ol><li><strong>北宁VSIP工业园：</strong>基础设施完善，投资优惠多</li><li><strong>河内升龙工业园：</strong>靠近市中心，交通便利</li><li><strong>海防野村工业园：</strong>靠近海港，便于进出口</li><li><strong>海防Deep C工业园：</strong>国际标准，绿色环境</li><li><strong>北宁安丰工业园：</strong>租金合理，日本投资者多</li></ol><p>这些工业园区都有良好的基础设施、有吸引力的优惠政策，并正在吸引许多外商直接投资项目。</p>',
            ],
            [
                'title' => 'Hướng dẫn thủ tục thuê nhà xưởng cho doanh nghiệp FDI',
                'title_en' => 'Guide to Factory Rental Procedures for FDI Enterprises',
                'title_zh' => '外商直接投资企业厂房租赁手续指南',
                'content' => '<p>Để thuê nhà xưởng tại Việt Nam, doanh nghiệp FDI cần thực hiện các bước sau:</p><ol><li><strong>Bước 1:</strong> Xin giấy phép đầu tư hoặc điều chỉnh giấy phép</li><li><strong>Bước 2:</strong> Tìm kiếm và khảo sát nhà xưởng phù hợp</li><li><strong>Bước 3:</strong> Đàm phán và ký hợp đồng thuê</li><li><strong>Bước 4:</strong> Đăng ký thuế, bảo hiểm và các thủ tục pháp lý</li><li><strong>Bước 5:</strong> Hoàn thiện nhà xưởng và bắt đầu hoạt động</li></ol><p>Thời gian hoàn tất toàn bộ thủ tục thường mất từ 2-3 tháng. Doanh nghiệp nên tìm kiếm đối tác tư vấn địa phương để hỗ trợ các thủ tục pháp lý.</p>',
                'content_en' => '<p>To rent a factory in Vietnam, FDI enterprises need to follow these steps:</p><ol><li><strong>Step 1:</strong> Apply for investment license or license adjustment</li><li><strong>Step 2:</strong> Search and survey suitable factories</li><li><strong>Step 3:</strong> Negotiate and sign rental contract</li><li><strong>Step 4:</strong> Register for taxes, insurance and legal procedures</li><li><strong>Step 5:</strong> Complete factory setup and start operations</li></ol><p>The time to complete all procedures usually takes 2-3 months. Enterprises should seek local consulting partners to support legal procedures.</p>',
                'content_zh' => '<p>要在越南租赁厂房，外商直接投资企业需要遵循以下步骤：</p><ol><li><strong>步骤1：</strong>申请投资许可证或许可证调整</li><li><strong>步骤2：</strong>寻找和考察合适的厂房</li><li><strong>步骤3：</strong>谈判并签订租赁合同</li><li><strong>步骤4：</strong>注册税务、保险和法律手续</li><li><strong>步骤5：</strong>完成厂房设置并开始运营</li></ol><p>完成所有手续通常需要2-3个月。企业应寻求当地咨询合作伙伴来支持法律程序。</p>',
            ],
            [
                'title' => 'Xu hướng Logistics và kho bãi hiện đại tại Việt Nam',
                'title_en' => 'Modern Logistics and Warehouse Trends in Vietnam',
                'title_zh' => '越南现代物流和仓储趋势',
                'content' => '<p>Ngành logistics Việt Nam đang chứng kiến sự phát triển mạnh mẽ với sự xuất hiện của nhiều kho bãi hiện đại. Các xu hướng nổi bật bao gồm:</p><ul><li>Kho tự động hóa với robot và AI</li><li>Hệ thống quản lý kho (WMS) thông minh</li><li>Kho đa tầng tối ưu hóa không gian</li><li>Kho lạnh công nghệ cao phục vụ thực phẩm</li><li>Kho xanh tiết kiệm năng lượng</li></ul><p>Theo dự báo, thị trường logistics Việt Nam sẽ tăng trưởng 15-20% năm 2026, thu hút mạnh mẽ các nhà đầu tư nước ngoài.</p>',
                'content_en' => '<p>Vietnam\'s logistics industry is witnessing strong development with the emergence of many modern warehouses. Notable trends include:</p><ul><li>Automated warehouses with robots and AI</li><li>Smart Warehouse Management Systems (WMS)</li><li>Multi-story warehouses optimizing space</li><li>High-tech cold storage for food products</li><li>Green energy-saving warehouses</li></ul><p>According to forecasts, Vietnam\'s logistics market will grow 15-20% in 2026, strongly attracting foreign investors.</p>',
                'content_zh' => '<p>越南物流行业正见证强劲发展，出现了许多现代化仓库。显著趋势包括：</p><ul><li>配备机器人和人工智能的自动化仓库</li><li>智能仓库管理系统(WMS)</li><li>优化空间的多层仓库</li><li>用于食品的高科技冷藏</li><li>绿色节能仓库</li></ul><p>根据预测，越南物流市场将在2026年增长15-20%，强烈吸引外国投资者。</p>',
            ],
            [
                'title' => 'Chính sách ưu đãi đầu tư vào khu công nghiệp 2026',
                'title_en' => 'Investment Incentive Policies for Industrial Parks 2026',
                'title_zh' => '2026年工业园区投资优惠政策',
                'content' => '<p>Chính phủ Việt Nam tiếp tục duy trì và mở rộng các chính sách ưu đãi cho nhà đầu tư vào khu công nghiệp năm 2026:</p><ul><li><strong>Thuế thu nhập doanh nghiệp:</strong> Ưu đãi 10-15% trong 15 năm</li><li><strong>Miễn giảm thuế:</strong> 2-4 năm miễn thuế, 50% giảm thuế 4-9 năm tiếp theo</li><li><strong>Thuê đất:</strong> Miễn/giảm tiền thuê đất giai đoạn đầu</li><li><strong>Thủ tục hải quan:</strong> Đơn giản hóa, ưu tiên xử lý nhanh</li><li><strong>Lao động:</strong> Hỗ trợ đào tạo và tuyển dụng</li></ul><p>Các dự án công nghệ cao, bảo vệ môi trường và sản xuất xanh được ưu tiên cao nhất.</p>',
                'content_en' => '<p>The Vietnamese government continues to maintain and expand incentive policies for investors in industrial parks in 2026:</p><ul><li><strong>Corporate income tax:</strong> 10-15% incentive for 15 years</li><li><strong>Tax exemption/reduction:</strong> 2-4 years tax exemption, 50% reduction for next 4-9 years</li><li><strong>Land rental:</strong> Exemption/reduction of land rental fees in early stages</li><li><strong>Customs procedures:</strong> Simplified, prioritized for fast processing</li><li><strong>Labor:</strong> Support for training and recruitment</li></ul><p>High-tech, environmental protection and green production projects are given highest priority.</p>',
                'content_zh' => '<p>越南政府继续维持和扩大2026年工业园区投资者的优惠政策：</p><ul><li><strong>企业所得税：</strong>15年内10-15%优惠</li><li><strong>税收减免：</strong>2-4年免税，接下来4-9年减免50%</li><li><strong>土地租赁：</strong>早期阶段土地租赁费减免</li><li><strong>海关程序：</strong>简化，优先快速处理</li><li><strong>劳动力：</strong>支持培训和招聘</li></ul><p>高科技、环保和绿色生产项目被给予最高优先权。</p>',
            ],
            [
                'title' => 'So sánh giá thuê nhà xưởng Bắc - Trung - Nam 2026',
                'title_en' => 'Comparison of Factory Rental Prices: North - Central - South 2026',
                'title_zh' => '2026年北部-中部-南部厂房租金比较',
                'content' => '<p>Giá thuê nhà xưởng tại Việt Nam có sự chênh lệch đáng kể giữa các vùng miền:</p><h3>Miền Bắc (Hà Nội, Bắc Ninh, Hải Phòng)</h3><ul><li>Giá trung bình: 3.5 - 5 USD/m²/tháng</li><li>Ưu điểm: Gần cảng, lao động dồi dào</li></ul><h3>Miền Trung (Đà Nẵng, Quảng Nam)</h3><ul><li>Giá trung bình: 3 - 4.5 USD/m²/tháng</li><li>Ưu điểm: Giá cả hợp lý, vị trí chiến lược</li></ul><h3>Miền Nam (TP.HCM, Bình Dương, Đồng Nai)</h3><ul><li>Giá trung bình: 4 - 6.5 USD/m²/tháng</li><li>Ưu điểm: Hạ tầng tốt nhất, nhiều dịch vụ hỗ trợ</li></ul><p>Lưu ý: Giá cụ thể phụ thuộc vào vị trí, chất lượng và diện tích nhà xưởng.</p>',
                'content_en' => '<p>Factory rental prices in Vietnam vary significantly between regions:</p><h3>Northern Region (Hanoi, Bac Ninh, Hai Phong)</h3><ul><li>Average price: 3.5 - 5 USD/m²/month</li><li>Advantages: Near ports, abundant labor</li></ul><h3>Central Region (Da Nang, Quang Nam)</h3><ul><li>Average price: 3 - 4.5 USD/m²/month</li><li>Advantages: Reasonable prices, strategic location</li></ul><h3>Southern Region (HCMC, Binh Duong, Dong Nai)</h3><ul><li>Average price: 4 - 6.5 USD/m²/month</li><li>Advantages: Best infrastructure, many support services</li></ul><p>Note: Specific prices depend on location, quality and factory area.</p>',
                'content_zh' => '<p>越南厂房租金在各地区之间存在显著差异：</p><h3>北部地区（河内、北宁、海防）</h3><ul><li>平均价格：3.5 - 5美元/平米/月</li><li>优势：靠近港口，劳动力充足</li></ul><h3>中部地区（岘港、广南）</h3><ul><li>平均价格：3 - 4.5美元/平米/月</li><li>优势：价格合理，战略位置</li></ul><h3>南部地区（胡志明市、平阳、同奈）</h3><ul><li>平均价格：4 - 6.5美元/平米/月</li><li>优势：最佳基础设施，支持服务多</li></ul><p>注意：具体价格取决于位置、质量和厂房面积。</p>',
            ],
            [
                'title' => 'Lưu ý pháp lý khi ký hợp đồng thuê nhà xưởng',
                'title_en' => 'Legal Notes When Signing Factory Rental Contract',
                'title_zh' => '签订厂房租赁合同的法律注意事项',
                'content' => '<p>Khi ký hợp đồng thuê nhà xưởng, doanh nghiệp cần lưu ý các vấn đề pháp lý quan trọng sau:</p><ol><li><strong>Kiểm tra giấy tờ pháp lý:</strong> Sổ đỏ, giấy phép xây dựng, giấy phép kinh doanh của bên cho thuê</li><li><strong>Điều khoản hợp đồng:</strong> Thời hạn thuê, giá thuê, phương thức thanh toán, điều kiện gia hạn</li><li><strong>Trách nhiệm bảo trì:</strong> Phân định rõ trách nhiệm sửa chữa, bảo trì giữa hai bên</li><li><strong>Bảo hiểm:</strong> Yêu cầu bảo hiểm tài sản, cháy nổ</li><li><strong>Điều khoản chấm dứt:</strong> Điều kiện và thủ tục chấm dứt hợp đồng trước hạn</li></ol><p>Nên nhờ luật sư tư vấn trước khi ký kết để tránh rủi ro pháp lý.</p>',
                'content_en' => '<p>When signing a factory rental contract, enterprises need to note the following important legal issues:</p><ol><li><strong>Check legal documents:</strong> Red book, construction permit, lessor\'s business license</li><li><strong>Contract terms:</strong> Lease term, rental price, payment method, renewal conditions</li><li><strong>Maintenance responsibility:</strong> Clearly define repair and maintenance responsibilities between parties</li><li><strong>Insurance:</strong> Require property and fire insurance</li><li><strong>Termination clause:</strong> Conditions and procedures for early contract termination</li></ol><p>Consult a lawyer before signing to avoid legal risks.</p>',
                'content_zh' => '<p>签订厂房租赁合同时，企业需要注意以下重要的法律问题：</p><ol><li><strong>检查法律文件：</strong>红本、建筑许可证、出租人营业执照</li><li><strong>合同条款：</strong>租赁期限、租金、付款方式、续租条件</li><li><strong>维护责任：</strong>明确界定双方的维修和维护责任</li><li><strong>保险：</strong>要求财产和火灾保险</li><li><strong>终止条款：</strong>提前终止合同的条件和程序</li></ol><p>签约前咨询律师以避免法律风险。</p>',
            ],
            [
                'title' => 'Kinh nghiệm chọn nhà xưởng phù hợp cho sản xuất',
                'title_en' => 'Experience in Choosing Suitable Factory for Production',
                'title_zh' => '选择合适生产厂房的经验',
                'content' => '<p>Việc lựa chọn nhà xưởng phù hợp đóng vai trò quan trọng trong hiệu quả sản xuất. Dưới đây là những kinh nghiệm hữu ích:</p><ul><li><strong>Vị trí:</strong> Gần nguồn nguyên liệu, thị trường tiêu thụ, giao thông thuận lợi</li><li><strong>Diện tích:</strong> Đủ không gian cho hoạt động sản xuất hiện tại và dự phòng mở rộng</li><li><strong>Hạ tầng:</strong> Điện 3 pha, nước sạch, hệ thống thoát nước tốt</li><li><strong>Kết cấu:</strong> Nền cứng, trần cao đủ cho máy móc, cầu trục nếu cần</li><li><strong>PCCC:</strong> Hệ thống phòng cháy chữa cháy đầy đủ và đạt chuẩn</li><li><strong>Chi phí:</strong> Tính toán tổng chi phí bao gồm thuê, điện, nước, bảo trì</li></ul><p>Nên khảo sát và so sánh nhiều lựa chọn trước khi quyết định.</p>',
                'content_en' => '<p>Choosing the right factory plays an important role in production efficiency. Here are useful experiences:</p><ul><li><strong>Location:</strong> Near raw materials, consumer markets, convenient transportation</li><li><strong>Area:</strong> Enough space for current production activities and expansion reserve</li><li><strong>Infrastructure:</strong> 3-phase electricity, clean water, good drainage system</li><li><strong>Structure:</strong> Solid floor, high ceiling for machinery, crane if needed</li><li><strong>Fire safety:</strong> Complete and standard fire prevention system</li><li><strong>Cost:</strong> Calculate total cost including rent, electricity, water, maintenance</li></ul><p>Should survey and compare many options before deciding.</p>',
                'content_zh' => '<p>选择合适的厂房在生产效率中起着重要作用。以下是有用的经验：</p><ul><li><strong>位置：</strong>靠近原材料、消费市场、交通便利</li><li><strong>面积：</strong>足够的空间用于当前生产活动和扩张储备</li><li><strong>基础设施：</strong>三相电、清洁水、良好的排水系统</li><li><strong>结构：</strong>坚固地面、高天花板适合机械、需要时有起重机</li><li><strong>消防：</strong>完整和标准的防火系统</li><li><strong>成本：</strong>计算总成本包括租金、电、水、维护</li></ul><p>决定前应调查和比较多个选项。</p>',
            ],
        ];

        foreach ($newsArticles as $article) {
            $slug = Str::slug($article['title']);
            
            // Ensure unique slug
            $originalSlug = $slug;
            $counter = 1;
            while (News::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            News::create([
                'title' => $article['title'],
                'title_en' => $article['title_en'],
                'title_zh' => $article['title_zh'],
                'slug' => $slug,
                'content' => $article['content'],
                'content_en' => $article['content_en'],
                'content_zh' => $article['content_zh'],
                'featured_image' => 'images/news/news-' . rand(1, 8) . '.jpg',
            ]);
        }

        $this->command->info('Đã tạo ' . count($newsArticles) . ' tin tức!');
    }
}

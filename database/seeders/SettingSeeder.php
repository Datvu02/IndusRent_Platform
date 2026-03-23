<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ["key" => "site_logo", "value" => "images/default-logo.png", "type" => "image", "group" => "general", "label" => "Logo công ty", "label_en" => "Company Logo", "label_zh" => "公司标志", "order" => 1],
            ["key" => "site_name", "value" => "IndusRent Platform", "type" => "text", "group" => "general", "label" => "Tên website", "label_en" => "Site Name", "label_zh" => "网站名称", "order" => 2],
            ["key" => "site_slogan", "value" => "Giải pháp cho thuê BĐS công nghiệp", "type" => "text", "group" => "general", "label" => "Slogan", "label_en" => "Slogan", "label_zh" => "标语", "order" => 3],
            ["key" => "primary_color", "value" => "#D4AF37", "type" => "text", "group" => "general", "label" => "Màu chủ đạo", "label_en" => "Primary Color", "label_zh" => "主色调", "order" => 4],
            ["key" => "secondary_color", "value" => "#1a3a52", "type" => "text", "group" => "general", "label" => "Màu phụ", "label_en" => "Secondary Color", "label_zh" => "辅助色", "order" => 5],
            ["key" => "company_name", "value" => "Công ty TNHH IndusRent", "type" => "text", "group" => "contact", "label" => "Tên công ty", "label_en" => "Company Name", "label_zh" => "公司名称", "order" => 1],
            ["key" => "company_address", "value" => "123 Đường ABC, Quận 1, TP.HCM", "type" => "textarea", "group" => "contact", "label" => "Địa chỉ", "label_en" => "Address", "label_zh" => "地址", "order" => 2],
            ["key" => "company_phone", "value" => "+84 28 1234 5678", "type" => "phone", "group" => "contact", "label" => "Số điện thoại", "label_en" => "Phone", "label_zh" => "电话", "order" => 3],
            ["key" => "company_hotline", "value" => "1900 xxxx", "type" => "phone", "group" => "contact", "label" => "Hotline", "label_en" => "Hotline", "label_zh" => "热线", "order" => 4],
            ["key" => "company_email", "value" => "info@indusrent.com", "type" => "email", "group" => "contact", "label" => "Email", "label_en" => "Email", "label_zh" => "电子邮件", "order" => 5],
            ["key" => "facebook_url", "value" => "https://facebook.com/indusrent", "type" => "url", "group" => "social", "label" => "Facebook URL", "label_en" => "Facebook URL", "label_zh" => "Facebook链接", "order" => 1],
            ["key" => "linkedin_url", "value" => "https://linkedin.com/company/indusrent", "type" => "url", "group" => "social", "label" => "LinkedIn URL", "label_en" => "LinkedIn URL", "label_zh" => "LinkedIn链接", "order" => 2],
            ["key" => "seo_title", "value" => "IndusRent - Cho thuê BĐS công nghiệp", "type" => "text", "group" => "seo", "label" => "SEO Title", "label_en" => "SEO Title", "label_zh" => "SEO标题", "order" => 1],
            ["key" => "seo_description", "value" => "Nền tảng cho thuê nhà xưởng, kho bãi tại Việt Nam", "type" => "textarea", "group" => "seo", "label" => "SEO Description", "label_en" => "SEO Description", "label_zh" => "SEO描述", "order" => 2],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::updateOrCreate(
                ["key" => $setting["key"]],
                $setting
            );
        }

        $this->command->info("Đã tạo " . count($settings) . " settings!");
    }
}

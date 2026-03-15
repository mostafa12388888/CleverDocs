<?php

namespace Database\Seeders\Form;

use App\Enum\Form\CustomOptionsListKeyEnum;
use App\Models\Form\CustomOption\CustomOptionList;
use App\Models\Form\CustomOption\InputOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomOptionsListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'key' => CustomOptionsListKeyEnum::DOC_STATUS,
                'title' => ["en" => "Doc Status", "ar" => "حالة المستند"],
                "is_active" => true,
                "is_default" => true,
                'options' => [
                    ['title' => ["en" => "Open", "ar" => "مفتوح"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Close", "ar" => "مغلق"], 'is_active' => true, 'is_default' => true]
                ]
            ],
            [
                'key' => CustomOptionsListKeyEnum::PRIORITY,
                'title' => ["en" => "Priority", "ar" => "الأولوية"],
                "is_active" => true,
                "is_default" => true,
                'options' => [
                    ['title' => ["en" => "High", "ar" => "عالية"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Normal", "ar" => "عادية"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Low", "ar" => "منخفضة"], 'is_active' => true, 'is_default' => true]
                ]
            ],
            [
                'key' => CustomOptionsListKeyEnum::DISCIPLINE,
                'title' => ["en" => "Discipline", "ar" => "التخصص"],
                "is_active" => true,
                "is_default" => true,
                'options' => [
                    ['title' => ["en" => "Civil", "ar" => "مدني"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Architecture", "ar" => "معماري"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Electrical", "ar" => "كهرباء"], 'is_active' => true, 'is_default' => true]
                ]
            ],
            [
                'key' => CustomOptionsListKeyEnum::AREA,
                'title' => ["en" => "Area", "ar" => "المنطقة"],
                "is_active" => true,
                "is_default" => true,
                'options' => [
                    ['title' => ["en" => "Area 1", "ar" => "المنطقة 1"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Area 2", "ar" => "المنطقة 2"], 'is_active' => true, 'is_default' => true]
                ]
            ],
            [
                'key' => CustomOptionsListKeyEnum::LOCATION,
                'title' => ["en" => "Location", "ar" => "الموقع"],
                "is_active" => true,
                "is_default" => true,
                'options' => [
                    ['title' => ["en" => "Location 1", "ar" => "الموقع 1"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Location 2", "ar" => "الموقع 2"], 'is_active' => true, 'is_default' => true]
                ]
            ],
            [
                'key' => CustomOptionsListKeyEnum::BUILDING,
                'title' => ["en" => "Building", "ar" => "المبنى"],
                "is_active" => true,
                "is_default" => true,
                'options' => [
                    ['title' => ["en" => "Building 1", "ar" => "المبنى 1"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Building 2", "ar" => "المبنى 2"], 'is_active' => true, 'is_default' => true]
                ]
            ],
            [
                'key' => CustomOptionsListKeyEnum::UNIT_NUMBER,
                'title' => ["en" => "Unit number", "ar" => "الوحدة رقم"],
                "is_active" => true,
                "is_default" => true,
                'options' => [
                    ['title' => ["en" => "Unit 1", "ar" => "الوحده 1"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Unit 2", "ar" => "الوحده 2"], 'is_active' => true, 'is_default' => true]
                ]
            ],
            [
                'key' => CustomOptionsListKeyEnum::DEPARTMENT,
                'title' => ["en" => "Department", "ar" => "الإدارة"],
                "is_active" => true,
                "is_default" => true,
                'options' => [
                    ['title' => ["en" => "Top Management", "ar" => "الإدارة العليا"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Engineering", "ar" => "الهندسة"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "HR", "ar" => "الموارد البشريه"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Procurement", "ar" => "المشتريات"], 'is_active' => true, 'is_default' => true]
                ]
            ],
            [
                'key' => CustomOptionsListKeyEnum::CURRENCY,
                'title' => ["en" => "Currency", "ar" => "العملة"],
                "is_active" => true,
                "is_default" => true,
                'options' => [
                    ['title' => ["en" => "EGP", "ar" => "جنيه مصري"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "SAR", "ar" => "ريال سعودي"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "USD", "ar" => "دولار أمريكى"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "AED", "ar" => "درهم إماراتي"], 'is_active' => true, 'is_default' => true]
                ]
            ],
            [
                'key' => CustomOptionsListKeyEnum::UNIT,
                'title' => ["en" => "Unit", "ar" => "الوحدة"],
                "is_active" => true,
                "is_default" => true,
                'options' => [
                    ['title' => ["en" => "KM", "ar" => "كم"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "M2", "ar" => "متر مربع"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Ton", "ar" => "طن"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "KG", "ar" => "كجم"], 'is_active' => true, 'is_default' => true]
                ]
            ],
            [
                'key' => CustomOptionsListKeyEnum::DISTRIBUTION_ACTION,
                'title' => ["en" => "Distribution List actions", "ar" => "إجراءات التوزيع"],
                "is_active" => true,
                "is_default" => true,
                'options' => [
                    ['title' => ["en" => "FYKI", "ar" => "للعلم و الأحاطة"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Action", "ar" => "لتنفيذ أمر"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Comment required", "ar" => "مطلوب تعليق"], 'is_active' => true, 'is_default' => true]
                ]
            ],
            [
                'key' => CustomOptionsListKeyEnum::PROJECT_TYPE,
                'title' => ["en" => "Project Type", "ar" => "نوع المشروع"],
                "is_active" => true,
                "is_default" => true,
                'options' => [
                    ['title' => ["en" => "Software", "ar" => "برمجة"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Residential", "ar" => "سكني"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Hospitality", "ar" => "فندقي"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Industrial", "ar" => "صناعي"], 'is_active' => true, 'is_default' => true]
                ]
            ],
            [
                'key' => CustomOptionsListKeyEnum::COUNTRY,
                'title' => ["en" => "Country", "ar" => "البلد"],
                "is_active" => true,
                "is_default" => true,
                'options' => [
                    ['title' => ["en" => "Egypt", "ar" => "مصر"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Saudi Arabia", "ar" => "السعودية"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "United Arab Emirates", "ar" => "الإمارات"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Kuwait", "ar" => "الكويت"], 'is_active' => true, 'is_default' => true]
                ]
            ],
            [
                'key' => CustomOptionsListKeyEnum::COMPANY_FILED,
                'title' => ["en" => "Company Field", "ar" => "مجال الشركة"],
                "is_active" => true,
                "is_default" => true,
                'options' => [
                    ['title' => ["en" => "General Contractors", "ar" => "مقاولون عامون"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Civil Engineering", "ar" => "الهندسة المدنية"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Residential Construction", "ar" => "البناء السكني"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Commercial  Construction", "ar" => "البناء التجاري"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Heavy Construction", "ar" => "البناء الثقيل"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Specialty Trades", "ar" => "الحرف الخاصة"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Architectural Services", "ar" => "الخدمات المعمارية"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Construction Materials", "ar" => "مواد البناء"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Real Estate Development", "ar" => "تطوير العقارات"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Construction", "ar" => "الإنشاءات"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Consulting", "ar" => "الاستشارات"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "IT", "ar" => "تكنولوجيا المعلومات"], 'is_active' => true, 'is_default' => true],
                    ['title' => ["en" => "Finance", "ar" => "المالية"], 'is_active' => true, 'is_default' => true]
                ]
            ],
            [
                'key' => CustomOptionsListKeyEnum::APPROVAL_TITLE,
                'title' => ["en" => "Approval Title", "ar" => "عنوان الاعتماد"],
                "is_active" => true,
                "is_default" => true,
                'options' => [
                    ['title' => ["en" => "Approval", "ar" => "الاعتماد"], 'is_active' => true, 'is_default' => true],
                ]
            ],
        ];

        $AllOptions = [];
        foreach ($data as $list) {
            $options = $list['options'];
            unset($list['options']);

            $customOptionList = CustomOptionList::updateOrCreate(['key' => $list['key']], $list);

            foreach ($options as $option) {
                $option['custom_option_list_id'] = $customOptionList->id;
                InputOption::updateOrCreate(["title"=>$option["title"],"custom_option_list_id"=>$customOptionList->id],$option);
            }

        }


    }
}

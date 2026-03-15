<?php

namespace Database\Seeders\Form;

use App\Enum\Form\InputTypeCategoryEnum;
use App\Enum\Form\InputTypeEnum;
use App\Enum\Form\InputTypeOptionEnum;
use App\Models\Form\CustomOption\CustomOptionList;
use App\Models\Form\InputType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InputTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('input_types')->delete();// 'sub_type'=> 'Text input'

        $data = [
            ["key" => "subject", 'title' =>  ['en' => 'Subject', 'ar' => 'الموضوع'], 'type' => InputTypeEnum::INPUT, "is_default" => true, 'category' => InputTypeCategoryEnum::TEXT],
            ["key" => "doc_date", 'title' => ['en' => 'Document Date', 'ar' => 'تاريخ المستند'], 'type' => InputTypeEnum::DATE, "is_default" => true, 'category' => InputTypeCategoryEnum::DATE_AND_TIME],
            // ["key" => "status", 'title' => ['en' => 'Status', 'ar' => 'الحالة'], 'type' => InputTypeEnum::DROPDOWN, "is_default" => true, 'category' => InputTypeCategoryEnum::SELECTION], //6

            ["key" => "deadline", 'title' => ['en' => 'Deadline', 'ar' => 'الموعد النهائي'], 'type' => InputTypeEnum::DATETIME, "is_default" => true, 'category' => InputTypeCategoryEnum::DATE_AND_TIME],
            ["key" => "id", 'title' => ['en' => 'No.', 'ar' => 'رقم'], 'type' => InputTypeEnum::NUMBER_INPUT, "is_default" => true, 'category' => InputTypeCategoryEnum::NUMBER],
            ["key" => "ref_no", 'title' => ['en' => 'Ref.No.', 'ar' => 'رقم مرجعي'], 'type' => InputTypeEnum::REFERENCE, "is_default" => true, 'category' => InputTypeCategoryEnum::TEXT],

            ["key" => "from_company", 'title' => ['en' => 'From Company', 'ar' => 'من شركه'], 'type' => InputTypeEnum::DROPDOWN, "is_default" => true, 'category' => InputTypeCategoryEnum::SELECTION, 'entity' => InputTypeOptionEnum::COMPANY], //6
            ["key" => "from_contact", 'title' => ['en' => 'From Contact', 'ar' => 'من المرسل'], 'type' => InputTypeEnum::DROPDOWN, "is_default" => true, 'category' => InputTypeCategoryEnum::SELECTION, 'entity' => InputTypeOptionEnum::CONTACT], //7

            ["key" => "to_company", 'title' => ['en' => 'To Company', 'ar' => 'الي شركه'], 'type' => InputTypeEnum::DROPDOWN, "is_default" => true, 'category' => InputTypeCategoryEnum::SELECTION, 'entity' => InputTypeOptionEnum::COMPANY], //9
            ["key" => "to_contact", 'title' => ['en' => 'To Contact', 'ar' => 'مرسل/مقدم الي'], 'type' => InputTypeEnum::DROPDOWN, "is_default" => true, 'category' => InputTypeCategoryEnum::SELECTION, 'entity' => InputTypeOptionEnum::CONTACT], //10

            ["key" => "description", 'title' => ['en' => 'Description', 'ar' => 'الوصف'], 'type' => InputTypeEnum::TEXT_AREA, "is_default" => true, 'category' => InputTypeCategoryEnum::TEXT],
            ["key" => "reply", 'title' => ['en' => 'Reply', 'ar' => 'الرد'], 'type' => InputTypeEnum::TEXT_AREA, "is_default" => true, 'category' => InputTypeCategoryEnum::TEXT], //12
            ["key" => "contract", 'title' => ['en' => 'Contrac\PO', 'ar' => 'العقد/أمر الشراء'], 'type' => InputTypeEnum::DROPDOWN, "is_default" => true, 'category' => InputTypeCategoryEnum::SELECTION],

            ["key" => "attachments", 'title' => ['en' => 'Attachments', 'ar' => 'المرفقات'], 'type' => InputTypeEnum::FILE_UPLOAD, "is_default" => true, 'category' => InputTypeCategoryEnum::SPECIAL_INPUT],
            ["key" => "built_in_attachments", 'title' => ['en' => 'Attach Built-in', 'ar' => 'إرفاق مستند مدمج'], 'type' => InputTypeEnum::BUILT_IN_ATTACHMENT, "is_default" => true, 'category' => InputTypeCategoryEnum::SPECIAL_INPUT],

            ["key" => "create_new_version", 'title' => ['en' => 'Create New Version', 'ar' => 'إنشاء نسخة جديدة'], 'type' => InputTypeEnum::CREATE_NEW_VERSION, "is_default" => true, 'category' => InputTypeCategoryEnum::SPECIAL_INPUT],
            ["key" => "version_number", 'title' => ['en' => 'Version Number', 'ar' => 'رقم النسخة'], 'type' => InputTypeEnum::SERIAL_NUMBER, "is_default" => true, 'category' => InputTypeCategoryEnum::SPECIAL_INPUT],
            ["key" => "image_header", 'title' => ['en' => 'Header', 'ar' => 'رأس الصفحة'], 'type' => InputTypeEnum::IMAGE_HEADER, "is_default" => true, 'category' => InputTypeCategoryEnum::SPECIAL_INPUT],
            ["key" => "image_footer", 'title' => ['en' => 'Footer', 'ar' => 'تزييل الصفحة'], 'type' => InputTypeEnum::IMAGE_FOOTER, "is_default" => true, 'category' => InputTypeCategoryEnum::SPECIAL_INPUT],

            ["key" => "official_signature", 'title' => ['en' => 'Official Signature', 'ar' => 'التوقيع الرسمي'], 'type' => InputTypeEnum::OFFICIAL_SIGNATURE, "is_default" => true, 'category' => InputTypeCategoryEnum::OFFICIAL_SIGNATURE], //19
            ["key" => "doc_status", 'title' => ['en' => 'Doc Status', 'ar' => 'حالة المستند'], 'type' => InputTypeEnum::DROPDOWN, "is_default" => true, 'category' => InputTypeCategoryEnum::SELECTION, 'entity' => InputTypeOptionEnum::CUSTOM_LIST],
            ["key" => "priority", 'title' => ['en' => 'Priority', 'ar' => 'الأولوية'], 'type' => InputTypeEnum::DROPDOWN, "is_default" => true, 'category' => InputTypeCategoryEnum::SELECTION, 'entity' => InputTypeOptionEnum::CUSTOM_LIST], //1=>file or image
            ["key" => "discipline", 'title' => ['en' => 'Discipline', 'ar' => 'التخصص'], 'type' => InputTypeEnum::DROPDOWN, "is_default" => true, 'category' => InputTypeCategoryEnum::SELECTION, 'entity' => InputTypeOptionEnum::CUSTOM_LIST],

            ["key" => "area", 'title' => ['en' => 'Area', 'ar' => 'المنطقة'], 'type' => InputTypeEnum::DROPDOWN, "is_default" => true, 'category' => InputTypeCategoryEnum::SELECTION, 'entity' => InputTypeOptionEnum::CUSTOM_LIST],
            ["key" => "location", 'title' => ['en' => 'Location', 'ar' => 'الموقع'], 'type' => InputTypeEnum::DROPDOWN, "is_default" => true, 'category' => InputTypeCategoryEnum::SELECTION, 'entity' => InputTypeOptionEnum::CUSTOM_LIST],
            ["key" => "building", 'title' => ['en' => 'Building', 'ar' => 'المبنى'], 'type' => InputTypeEnum::DROPDOWN, "is_default" => true, 'category' => InputTypeCategoryEnum::SELECTION, 'entity' => InputTypeOptionEnum::CUSTOM_LIST],
            ["key" => "unit_number", 'title' => ['en' => 'Unit Number', 'ar' => 'رقم الوحدة'], 'type' => InputTypeEnum::DROPDOWN, "is_default" => true, 'category' => InputTypeCategoryEnum::SELECTION, 'entity' => InputTypeOptionEnum::CUSTOM_LIST],
            ["key" => "department", 'title' => ['en' => 'Department', 'ar' => 'الإدارة'], 'type' => InputTypeEnum::DROPDOWN, "is_default" => true, 'category' => InputTypeCategoryEnum::SELECTION, 'entity' => InputTypeOptionEnum::CUSTOM_LIST], //2=> Header
            ["key" => "currency", 'title' => ['en' => 'Currency', 'ar' => 'العملة'], 'type' => InputTypeEnum::DROPDOWN, "is_default" => true, 'category' => InputTypeCategoryEnum::SELECTION, 'entity' => InputTypeOptionEnum::CUSTOM_LIST], //3=> footer
            ["key" => "unit", 'title' => ['en' => 'Unit', 'ar' => 'الوحدة'], 'type' => InputTypeEnum::DROPDOWN, "is_default" => true, 'category' => InputTypeCategoryEnum::SELECTION, 'entity' => InputTypeOptionEnum::CUSTOM_LIST],
            ["key" => "distribution_actions", 'title' => ['en' => 'Distribution List Actions', 'ar' => 'إجراءات التوزيع'], 'type' => InputTypeEnum::DROPDOWN, "is_default" => true, 'category' => InputTypeCategoryEnum::SELECTION, 'entity' => InputTypeOptionEnum::CUSTOM_LIST],
            ["key" => "form_title", 'title' => ['en' => 'Form Title', 'ar' => 'عنوان النموذج'], 'type' => InputTypeEnum::INPUT, "is_default" => true, 'category' => InputTypeCategoryEnum::TEXT],
            ["key" => "table", 'title' => ['en' => 'table', 'ar' => 'جدول'], 'type' => InputTypeEnum::TABLE, "is_default" => true, 'category' => InputTypeCategoryEnum::TABLE],
        ];
        foreach ($data as $value) {
            $key = $value['key'];
            if ($value['type'] == InputTypeEnum::DROPDOWN && ($value['entity'] ?? null) == InputTypeOptionEnum::CUSTOM_LIST) {
                $list = CustomOptionList::withTrashed()->where('key', $key)->first();
                if ($list)
                    $value['custom_option_list_id'] = $list?->id ?? null;
            }
            $attributes = $value;
            unset($attributes['key']);

            // Look including trashed rows
            $record = InputType::withTrashed()->where('key', $key)->first();

            if ($record) {
                // If it's soft deleted → restore
                if ($record->trashed()) {
                    $record->restore();
                }

                // Update existing
                $record->update($attributes);
            } else {
                // Create new if nothing exists at all
                InputType::create($value);
            }
        }
    }
}

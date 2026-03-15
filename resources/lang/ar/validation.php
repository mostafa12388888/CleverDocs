<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'يجب قبول :attribute.',
    'accepted_if' => 'يجب قبول :attribute في حالة :other يساوي :value.',
    'unique_name_in_company' => 'الاسم المُدخل موجود مسبقًا لنفس الشركة.',
    'active_url' => ':attribute ليس عنوان URL صالحاً.',
    'after' => 'يجب على حقل :attribute أن يكون تاريخًا لاحقًا للتاريخ :date.',
    'after_or_equal' => 'حقل :attribute يجب أن يكون تاريخاً لاحقاً أو مطابقاً للتاريخ :date.',
    'alpha' => 'يجب أن لا يحتوي حقل :attribute سوى على حروف.',
    'alpha_dash' => 'يجب أن لا يحتوي حقل :attribute سوى على حروف، أرقام ومطّات.',
    'alpha_num' => 'يجب أن يحتوي حقل :attribute على حروفٍ وأرقامٍ فقط.',
    'array' => 'يجب أن تكون :attribute مصفوفة.',
    'attached' => 'حقل :attribute تم إرفاقه بالفعل.',
    'before' => 'يجب على حقل :attribute أن يكون تاريخًا سابقًا للتاريخ :date.',
    'before_or_equal' => 'حقل :attribute يجب أن يكون تاريخا سابقا أو مطابقا للتاريخ :date.',
    'between' => [
        'numeric' => 'يجب أن تكون قيمة حقل :attribute بين :min و :max.',
        'file' => 'يجب أن يكون حجم ملف حقل :attribute بين :min و :max كيلوبايت.',
        'string' => 'يجب أن يكون عدد حروف نّص حقل :attribute بين :min و :max.',
        'array' => 'يجب أن يحتوي حقل :attribute على عدد من العناصر بين :min و :max.',
    ],
    'boolean' => 'يجب أن تكون قيمة حقل :attribute إما true أو false .',
    'confirmed' => 'حقل التأكيد غير مُطابق للحقل :attribute.',
    'date' => 'حقل :attribute ليس تاريخًا صحيحًا.',
    'date_equals' => 'يجب أن يكون حقل :attribute مطابقاً للتاريخ :date.',
    'date_format' => 'لا يتوافق حقل :attribute مع الشكل :format.',
    'declined' => 'يجب رفض :attribute.',
    'declined_if' => 'يجب رفض :attribute عندما يكون :other بقيمة :value.',
    'different' => 'يجب أن يكون الحقلان :attribute و :other مُختلفين.',
    'digits' => 'يجب أن يحتوي حقل :attribute على :digits رقمًا/أرقام.',
    'digits_between' => 'يجب أن يحتوي حقل :attribute بين :min و :max رقمًا/أرقام .',
    'dimensions' => 'الحقل:attribute يحتوي على أبعاد صورة غير صالحة.',
    'distinct' => 'للحقل :attribute قيمة مُكرّرة.',
    "doesnt_end_with" => 'الحقل :attribute يجب ألّا ينتهي بأحد القيم التالية: :values.',
    "doesnt_start_with" => 'الحقل :attribute يجب ألّا يبدأ بأحد القيم التالية: :values.',
    'email' => 'يجب أن يكون حقل :attribute عنوان بريد إلكتروني صحيح البُنية.',
    "ends_with" => 'يجب أن ينتهي حقل :attribute بأحد القيم التالية: :values',
    "enum" => 'حقل :attribute المختار غير صالح.',
    'exists' => 'القيمة المحددة :attribute غير موجودة.',
    "failed" => 'بيانات الاعتماد هذه غير متطابقة مع البيانات المسجلة لدينا.',
    'file' => 'الحقل :attribute يجب أن يكون ملفا.',
    'filled' => 'حقل :attribute إجباري.',
    'gt' => [
        'numeric' => 'يجب أن تكون قيمة حقل :attribute أكبر من :value.',
        'file' => 'يجب أن يكون حجم ملف حقل :attribute أكبر من :value كيلوبايت.',
        'string' => 'يجب أن يكون طول نّص حقل :attribute أكثر من :value حروفٍ/حرفًا.',
        'array' => '"يجب أن يحتوي حقل :attribute على أكثر من :value عناصر/عنصر.',
    ],
    'gte' => [
        'numeric' => 'يجب أن تكون قيمة حقل :attribute مساوية أو أكبر من :value.',
        'file' => 'يجب أن يكون حجم ملف حقل :attribute على الأقل :value كيلوبايت.',
        'string' => 'يجب أن يكون طول نص حقل :attribute على الأقل :value حروفٍ/حرفًا.',
        'array' => 'يجب أن يحتوي حقل :attribute على الأقل على :value عُنصرًا/عناصر.',
    ],
    'image' => 'يجب أن يكون حقل :attribute صورةً.',
    'in' => 'حقل :attribute غير موجود.',
    'in_array' => 'حقل :attribute غير موجود في :other.',
    'integer' => 'يجب أن يكون حقل :attribute عددًا صحيحًا.',
    'ip' => 'يجب أن يكون حقل :attribute عنوان IP صحيحًا.',
    'ipv4' => 'يجب أن يكون حقل :attribute عنوان IPv4 صحيحًا.',
    'ipv6' => 'يجب أن يكون حقل :attribute عنوان IPv6 صحيحًا',
    'json' => 'يجب أن يكون حقل :attribute نصًا من نوع JSON.',
    'lt' => [
        'numeric' => 'يجب أن تكون قيمة حقل :attribute أصغر من :value.',
        'file' => 'يجب أن يكون حجم ملف حقل :attribute أصغر من :value كيلوبايت.',
        'string' => 'يجب أن يكون طول نّص حقل :attribute أقل من :value حروفٍ/حرفًا.',
        'array' => 'يجب أن يحتوي حقل :attribute على أقل من :value عناصر/عنصر.',
    ],
    'lte' => [
        'numeric' => 'يجب أن تكون قيمة حقل :attribute مساوية أو أصغر من :value.',
        'file' => 'يجب أن لا يتجاوز حجم ملف حقل :attribute :value كيلوبايت.',
        'string' => 'يجب أن لا يتجاوز طول نّص حقل :attribute :value حروفٍ/حرفًا.',
        'array' => 'يجب أن لا يحتوي حقل :attribute على أكثر من :value عناصر/عنصر.',
    ],
    'max' => [
        'numeric' => 'يجب أن تكون قيمة حقل :attribute مساوية أو أصغر من :max.',
        'file' => 'يجب أن لا يتجاوز حجم ملف حقل :attribute :max كيلوبايت.',
        'string' => 'يجب أن لا يتجاوز طول نّص حقل :attribute :max حروفٍ/حرفًا.',
        'array' => 'يجب أن لا يحتوي حقل :attribute على أكثر من :max عناصر/عنصر.',
    ],
    'mimes' => 'يجب أن يكون ملفًا من نوع : :values.',
    'mimetypes' => 'يجب أن يكون ملفًا من نوع : :values.',
    'min' => [
        'numeric' => 'يجب أن تكون قيمة حقل :attribute مساوية أو أكبر من :min.',
        'file' => 'يجب أن يكون حجم ملف حقل :attribute على الأقل :min كيلوبايت.',
        'string' => 'يجب أن يكون طول نص حقل :attribute على الأقل :min حروفٍ/حرفًا.',
        'array' => 'يجب أن يحتوي حقل :attribute على الأقل على :min عُنصرًا/عناصر.',
    ],
    'not_in' => 'عنصر الحقل :attribute غير صحيح.',
    'not_regex' => 'صيغة حقل :attribute غير صحيحة.',
    'numeric' => 'يجب على حقل :attribute أن يكون رقمًا.',
    'present' => 'يجب تقديم حقل :attribute.',
    'regex' => 'صيغة حقل :attribute .غير صحيحة.',
    'required' => 'حقل :attribute مطلوب.',
    'required_if' => 'حقل :attribute مطلوب في حال ما إذا كان :other يساوي :value.',
    'required_unless' => 'حقل :attribute مطلوب في حال ما لم يكن :other يساوي :values.',
    'required_with' => 'حقل :attribute مطلوب إذا توفّر :values.',
    'required_with_all' => 'حقل :attribute مطلوب إذا توفّر :values.',
    'required_without' => 'حقل :attribute مطلوب إذا لم يتوفّر :values.',
    'required_without_all' => 'حقل :attribute مطلوب إذا لم يتوفّر :values.',
    'same' => 'يجب أن يتطابق حقل :attribute مع :other.',
    'size' => [
        'numeric' => 'يجب أن تكون قيمة حقل :attribute مساوية لـ :size.',
        'file' => 'يجب أن يكون حجم ملف حقل :attribute :size كيلوبايت.',
        'string' => 'يجب أن يحتوي نص حقل :attribute على :size حروفٍ/حرفًا بالضبط.',
        'array' => 'يجب أن يحتوي حقل :attribute على :size عنصرٍ/عناصر بالضبط.',
    ],
    'string' => 'يجب أن يكون حقل :attribute نصًا.',
    'timezone' => 'يجب أن يكون حقل :attribute نطاقًا زمنيًا صحيحًا.',
    'unique' => 'قيمة حقل :attribute مُستخدمة من قبل.',
    'uploaded' => 'فشل في تحميل الـ :attribute.',
    'url' => 'صيغة رابط حقل :attribute غير صحيحة.',
    'phone' => 'يحتوي حقل attribute: على رقم غير صالح.',
    "soft_delete" => "الخيار المحدد غير صالح أو تم حذفه :attribute.",

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name' => 'الاسم',
        'email' => 'البريد الالكتروني',
        'password' => 'كلمة المرور',

    ],

    'messages' => [
        'invalid_login_credentials' => 'معلومات تسجيل الدخول غير صحيحة',
        'distribution_list_has_inbox' => 'لا يمكن الحذف: تحتوي هذه القائمة على رسائل واردة مرتبطة.',
        "cant_delete_has_contact"=>"الشركة التالية لديها موظفين :",
        'cannot_delete_module_has_forms' => 'لا يمكن حذف هذا الموديول لأنه مرتبط بالنماذج التالية: :forms',
        'cannot_delete_project_has_forms' => 'لا يمكن حذف هذا المشروع لأنه مرتبط بالنماذج التالية: :forms',
        "cant_delete_is_key_contact"=>"الموظف التالي هو جهة موظف رئيسي :",
        "cant_delete_has_user"=>"الموظف التالي له حساب :",
        "cant_delete_is_default_user"=>"المستخدم التالي هو المستخدم الافتراضي :",
        "cant_delete_has_user_or_key_contact"=>"الموظف التالي هو جهة موظف رئيسي او له حساب",
        'invalid_field' => ':field غير صالح.',
        'cant_delete_project_has_wbs' => 'لا يمكن حذف المشروع لاحتوائه على هيكل تفصيلي (WBS).',
        'can_not_change_new_password_same_old_password' => 'لا يمكن تغيير كلمة المرور الجديدة لتكون مطابقة للقديمة.',
        'this_contact_already_has_users' => 'لا يمكن ربط هذا الشخص بمستخدم جديد لأنه مرتبط بالفعل.',
        'cant_delete_wbs_has_Project' => 'لا يمكن حذف هيكل WBS لأنه مرتبط بمشروع.',
        'cant_delete_has_children' => 'لا يمكن حذف هذا العنصر لأنه يحتوي على عناصر فرعية.',
        'cant_delete_has_content' => 'لا يمكن حذف هذا العنصر لأنه يحتوي على محتوى مرتبط.',
        'cant_delete_has_Account' => 'لا يمكن حذف حسابك الشخصي.',
        'cant_delete_has_Wbs' => 'لا يمكن حذف المشروع لأنه يحتوي على هيكل WBS.',
        'cant_delete_update_has_user' => 'لا يمكن حذف هذا المستخدم لأنه مرتبط ببيانات أخرى.',
        'cant_change_user_password' => 'لا يمكن تغيير كلمة مرور هذا المستخدم.',
        'cant_delete_is_key_content' => 'لا يمكن حذف هذا العنصر لأنه عنصر أساسي في النظام.',
        'cant_delete_has_projects' => 'لا يمكن حذف WPS لأنه مرتبط بمشروع.',
        "cant_delete_has_contact"=>"الشركة التالية لديها موظفين :",
        'cannot_delete_module_has_forms' => 'لا يمكن حذف هذا الموديول لأنه مرتبط بالنماذج التالية: :forms',
        'cannot_delete_project_has_forms' => 'لا يمكن حذف هذا المشروع لأنه مرتبط بالنماذج التالية: :forms',
        'cannot_delete_custom_option_list' => 'لا يمكن حذف القائمة المخصصة لأنها مرتبطة بالنماذج التالية: :forms',
        'cannot_delete_custom_items' => 'لا يمكن حذف العناصر المخصصة لأنها مرتبطة بالنماذج التالية: :forms',
        "cant_delete_is_key_contact"=>"الموظف التالي هو جهة موظف رئيسي :",
        "cant_delete_has_user"=>"الموظف التالي له حساب :",
        "cant_delete_is_default_user"=>"المستخدم التالي هو المستخدم الافتراضي :",
        "cant_delete_has_user_or_key_contact"=>"الموظف التالي هو جهة موظف رئيسي او له حساب",
        'invalid_enum_value' => 'القيمة ":value" غير صالحة.',
        'form_not_attached_to_project' => 'هذا النموذج غير مرتبط بهذا المشروع.',
        'user_does_not_have_the_right_permissions' => 'المستخدم لا يملك الصلاحيات الكافية.',
        'entity_not_found' => 'العنصر المطلوب غير موجود.',
        'cant_add_form_submission' => 'لا يمكنك إضافة هذا النموذج لأن بعض الحقول المطلوبة غير موجودة.',
        'inactive_account' => 'حسابك غير نشط حالياً، يرجى التواصل مع الإدارة.',
         'account_not_active' => 'حسابك غير مفعل، يرجى التواصل مع الدعم.',
        'cant_delete_form_submission_with_versions' => 'لا يمكن حذف هذا النموذج لأنه يحتوي على نسخ. يرجى حذف النسخ أولاً.',

    ]
];

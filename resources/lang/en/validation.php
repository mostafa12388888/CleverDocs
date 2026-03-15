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

    'accepted' => 'The :attribute must be accepted.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute may only contain letters.',
    'alpha_dash' => 'The :attribute may only contain letters, numbers, dashes and underscores.',
    'unique_name_in_company'=>'The given name already exists in this company.',
    'alpha_num' => 'The :attribute may only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'date' => 'The :attribute is not a valid date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => 'The :attribute must be a valid email address.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file' => 'The :attribute must be greater than or equal :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file' => 'The :attribute must be less than or equal :value kilobytes.',
        'string' => 'The :attribute must be less than or equal :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file' => 'The :attribute may not be greater than :max kilobytes.',
        'string' => 'The :attribute may not be greater than :max characters.',
        'array' => 'The :attribute may not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'present' => 'The :attribute field must be present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => 'The :attribute field is required.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values is present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique' => 'The :attribute has already been taken.',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute format is invalid.',
    'phone' => 'The :attribute field contains an invalid number.',
    "soft_delete"=>"The selected :attribute is invalid or has been deleted.",

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
        'name' => 'Name',
        'email' => 'Email',
        'password' => 'Password',

    ],

    'messages' => [
        'invalid_login_credentials' => 'Invalid login credentials',
        'invalid_field' => 'Invalid :field.',
        'cant_delete_project_has_wbs' => 'The project cannot be deleted because it has a Work Breakdown Structure (WBS).',
        'can_not_change_new_password_same_old_password' => 'The new password cannot be the same as the old password.',
        'this_contact_already_has_users' => 'This contact is already associated with a user.',
        'cant_delete_wbs_has_Project' => 'The WBS cannot be deleted because it is linked to a project.',
        'cant_delete_has_children' => 'This item cannot be deleted because it has child elements.',
        'cant_delete_has_content' => 'This item cannot be deleted because it has related content.',
        'cant_delete_has_Account' => 'You cannot delete your own account.',
        'cant_delete_has_Wbs' => 'The project cannot be deleted because it has a WBS.',
        'form_not_attached_to_project' => 'This form is not attached to this project.',
        'cant_delete_update_has_user' => 'This user cannot be deleted because it is linked to other data.',
        'cant_change_user_password' => 'The password for this user cannot be changed.',
        'cant_delete_is_key_content' => 'This item cannot be deleted because it is a key content in the system.',
        'cant_delete_has_projects' => 'The WPS cannot be deleted because it is linked to a project.',
        "cant_delete_has_contact"=>"The Fallowing company has contact :",
        'distribution_list_has_inbox' => 'Cannot delete: This distribution list has associated inbox records.',
        'cannot_delete_module_has_forms' => 'This module cannot be deleted because it is linked to the following forms: :forms',
        'cannot_delete_project_has_forms' => 'This project cannot be deleted because it is linked to the following forms: :forms',
        'cannot_delete_custom_option_list' => 'Cannot delete custom option list because it is linked to the following forms: :forms',
        'cannot_delete_custom_items' => 'Cannot delete custom items because they are linked to the following forms: :forms',
        "cant_delete_is_key_contact"=>"The Fallowing contact is Key Contact :",
        "cant_delete_has_user"=>"The Fallowing contact has  account :",
        "cant_delete_is_default_user"=>"The Fallowing User is Default User :",
        "cant_delete_has_user_or_key_contact"=>"The Fallowing contact is Key Contact  or has Account :",
        'invalid_enum_value' => 'The value ":value" is not valid.',
         'user_does_not_have_the_right_permissions' => 'The user does not have the required permissions.',
        'entity_not_found' => 'The requested entity was not found.',
        'cant_add_form_submission' => 'You cannot add this form submission because some required fields are missing.',
        'inactive_account' => 'Your account is inactive, please contact the administrator.',
        'account_not_active' => 'Your account is not active. Please contact support.',
        'cant_delete_form_submission_with_versions' => 'Cannot delete this submission because it has versions. Please delete the versions first.',


    ]
];

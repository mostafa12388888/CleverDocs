<?php

namespace App\Enum\Authorization;

use App\Enum\Enum;

class PermissionGroupEnum extends Enum
{

    const GROUP_PERMISSION = [
        [
            "name" => PermissionEnum::ROLE,
            "permissions" => [
                PermissionEnum::ROLE_VIEW,
                PermissionEnum::ROLE_CREATE,
                PermissionEnum::ROLE_EDIT,
                PermissionEnum::ROLE_DELETE,
            ],
        ],
        [
            "name" => PermissionEnum::FORM,
            "permissions" => [
                PermissionEnum::FORM_VIEW,
                PermissionEnum::FORM_CREATE,
                PermissionEnum::FORM_UPDATE,
                PermissionEnum::FORM_DELETE,
            ],
        ],
        [
            "name" => PermissionEnum::CONTACT,
            "permissions" => [
                PermissionEnum::CONTACT_VIEW,
                PermissionEnum::CONTACT_CREATE,
                PermissionEnum::CONTACT_UPDATE,
                PermissionEnum::CONTACT_DELETE,
                PermissionEnum::CONTACT_DELETE_ALL,
            ],
        ],
        [
            "name" => PermissionEnum::COMPANY,
            "permissions" => [
                PermissionEnum::COMPANY_VIEW,
                PermissionEnum::COMPANY_CREATE,
                PermissionEnum::COMPANY_UPDATE,
                PermissionEnum::COMPANY_DELETE,
                PermissionEnum::COMPANY_DELETE_ALL,
            ],
        ],
        [
            "name" => PermissionEnum::USER,
            "permissions" => [
                PermissionEnum::USER_VIEW,
                PermissionEnum::USER_CREATE,
                PermissionEnum::USER_UPDATE,
                PermissionEnum::USER_CHANGE_PASSWORD,
                PermissionEnum::USER_CHANGE_PICTURE,
                PermissionEnum::USER_CHANGE_SIGNATURE_PICTURE,
                PermissionEnum::USER_DELETE,
                PermissionEnum::USER_DELETE_ALL,
            ],
        ],
        [
            "name" => PermissionEnum::WBS,
            "permissions" => [
                PermissionEnum::WBS_VIEW,
                PermissionEnum::WBS_CREATE,
                PermissionEnum::WBS_UPDATE,
                PermissionEnum::WBS_DELETE,
                PermissionEnum::WBS_DELETE_ALL,
            ],
        ],
        [
            "name" => PermissionEnum::CUSTOM_LIST,
            "permissions" => [
                PermissionEnum::CUSTOM_LIST_VIEW,
                PermissionEnum::CUSTOM_LIST_CREATE,
                PermissionEnum::CUSTOM_LIST_UPDATE,
                PermissionEnum::CUSTOM_LIST_DELETE,
                PermissionEnum::CUSTOM_LIST_DELETE_ALL,
            ],
        ],
        [
            "name" => PermissionEnum::CUSTOM_OPTION,
            "permissions" => [
                PermissionEnum::CUSTOM_OPTION_VIEW,
                PermissionEnum::CUSTOM_OPTION_CREATE,
                PermissionEnum::CUSTOM_OPTION_UPDATE,
                PermissionEnum::CUSTOM_OPTION_DELETE,
                PermissionEnum::CUSTOM_OPTION_DELETE_ALL,
            ],
        ],
        [
            "name" => PermissionEnum::LAYOUT,
            "permissions" => [
                PermissionEnum::LAYOUT_VIEW,
                PermissionEnum::LAYOUT_CREATE,
                PermissionEnum::LAYOUT_UPDATE,
                PermissionEnum::LAYOUT_DELETE,
                PermissionEnum::LAYOUT_DELETE_ALL,
            ],
        ],
        [
            "name" => PermissionEnum::DISTRIBUTION_LIST,
            "permissions" => [
                PermissionEnum::DISTRIBUTION_LIST_VIEW,
                PermissionEnum::DISTRIBUTION_LIST_CREATE,
                PermissionEnum::DISTRIBUTION_LIST_UPDATE,
                PermissionEnum::DISTRIBUTION_LIST_DELETE,
                PermissionEnum::DISTRIBUTION_LIST_DELETE_ALL,
            ],
        ],
        [
            "name" => PermissionEnum::MODULE,
            "permissions" => [
                PermissionEnum::MODULE_VIEW,
                PermissionEnum::MODULE_CREATE,
                PermissionEnum::MODULE_UPDATE,
                PermissionEnum::MODULE_ORDER,
                PermissionEnum::MODULE_DELETE,
                PermissionEnum::MODULE_DELETE_ALL,
            ],
        ],
        [
            "name" => PermissionEnum::REPOSITORY,
            "permissions" => [
                PermissionEnum::REPOSITORY_VIEW,
                PermissionEnum::REPOSITORY_CREATE,
                PermissionEnum::REPOSITORY_UPDATE,
                PermissionEnum::REPOSITORY_DELETE,
                PermissionEnum::REPOSITORY_DELETE_ALL,
            ],
        ],
        [
            "name" => PermissionEnum::PROJECT,
            "permissions" => [
                PermissionEnum::PROJECT_VIEW,
                PermissionEnum::PROJECT_CREATE,
                PermissionEnum::PROJECT_UPDATE,
                PermissionEnum::PROJECT_ASSIGN_USER,
                PermissionEnum::PROJECT_ASSIGN_PROJECT,
                PermissionEnum::PROJECT_ASSIGN_COMPANIES,
                PermissionEnum::PROJECT_DELETE,
                PermissionEnum::PROJECT_DELETE_ALL,
            ],
        ],
        [
            "name" => PermissionEnum::WORKFLOW,
            "permissions" => [
                PermissionEnum::WORKFLOW_VIEW,
                PermissionEnum::WORKFLOW_CREATE,
                PermissionEnum::WORKFLOW_UPDATE,
                PermissionEnum::WORKFLOW_DELETE,
                PermissionEnum::WORKFLOW_DELETE_ALL,
            ],
        ],
        [
            "name" => PermissionEnum::DASHBOARD,
            "permissions" => [
                PermissionEnum::DASHBOARD_VIEW,
                PermissionEnum::DASHBOARD_CREATE,
                PermissionEnum::DASHBOARD_UPDATE,
                PermissionEnum::DASHBOARD_DELETE,
                PermissionEnum::DASHBOARD_DELETE_ALL,
                PermissionEnum::DASHBOARD_ASSIGN_USER,
            ],
        ],
        [
            "name" => PermissionEnum::COMPONENT,
            "permissions" => [
                PermissionEnum::COMPONENT_VIEW,
                PermissionEnum::COMPONENT_CREATE,
                PermissionEnum::COMPONENT_UPDATE,
                PermissionEnum::COMPONENT_DELETE,
                PermissionEnum::COMPONENT_DELETE_ALL,
                PermissionEnum::COMPONENT_ASSIGN_USER,
            ],
        ],
    ];
}

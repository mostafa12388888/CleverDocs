<?php

namespace App\Enum\Authorization;

use App\Enum\Enum;

class PermissionEnum extends Enum
{
    //----------------------- Roles --------------------------//

    const ROLE = 'role';
    const ROLE_VIEW = 'role_view';
    const ROLE_CREATE = 'role_create';
    const ROLE_EDIT = 'role_edit';
    const ROLE_DELETE = 'role_delete';

    //----------------------- Forms --------------------------//
    const FORM = 'form';
    const FORM_VIEW = 'form_view';
    const FORM_CREATE = 'form_create';
    const FORM_UPDATE = 'form_update';
    const FORM_DELETE = 'form_delete';

    //----------------------- Contacts --------------------------//
    const CONTACT = 'contact';
    const CONTACT_VIEW = 'contact_view';
    const CONTACT_CREATE = 'contact_create';
    const CONTACT_UPDATE = 'contact_update';
    const CONTACT_DELETE = 'contact_delete';
    const CONTACT_DELETE_ALL = 'contact_delete_all';

    //----------------------- Companies --------------------------//
    const COMPANY = 'company';
    const COMPANY_VIEW = 'company_view';
    const COMPANY_CREATE = 'company_create';
    const COMPANY_UPDATE = 'company_update';
    const COMPANY_DELETE = 'company_delete';
    const COMPANY_DELETE_ALL = 'company_delete_all';

    //----------------------- Users --------------------------//
    const USER = 'user';
    const USER_VIEW = 'user_view';
    const USER_CREATE = 'user_create';
    const USER_UPDATE = 'user_update';
    const USER_CHANGE_PASSWORD = 'user_change_password';
    const USER_CHANGE_PICTURE = 'user_change_picture';
    const USER_CHANGE_SIGNATURE_PICTURE = 'user_change_signature_picture';
    const USER_DELETE = 'user_delete';
    const USER_DELETE_ALL = 'user_delete_all';

    //----------------------- WBSS --------------------------//
    const WBS = 'wbs';
    const WBS_VIEW = 'Wbs_view';
    const WBS_CREATE = 'Wbs_create';
    const WBS_UPDATE = 'Wbs_update';
    const WBS_DELETE = 'Wbs_delete';
    const WBS_DELETE_ALL = 'Wbs_delete_all';

    //----------------------- Custom Lists --------------------------//
    const CUSTOM_LIST = 'custom_list';
    const CUSTOM_LIST_VIEW = 'custom_list_view';
    const CUSTOM_LIST_CREATE = 'custom_list_create';
    const CUSTOM_LIST_UPDATE = 'custom_list_update';
    const CUSTOM_LIST_DELETE = 'custom_list_delete';
    const CUSTOM_LIST_DELETE_ALL = 'custom_list_delete_all';

    //----------------------- Custom Option --------------------------//
    const CUSTOM_OPTION = 'custom_option';
    const CUSTOM_OPTION_VIEW = 'custom_option_view';
    const CUSTOM_OPTION_CREATE = 'custom_option_create';
    const CUSTOM_OPTION_UPDATE = 'custom_option_update';
    const CUSTOM_OPTION_DELETE = 'custom_option_delete';
    const CUSTOM_OPTION_DELETE_ALL = 'custom_option_delete_all';

    //----------------------- Layout --------------------------//
    const LAYOUT = 'layout';
    const LAYOUT_VIEW = 'layout_view';
    const LAYOUT_CREATE = 'layout_create';
    const LAYOUT_UPDATE = 'layout_update';
    const LAYOUT_DELETE = 'layout_delete';
    const LAYOUT_DELETE_ALL = 'layout_delete_all';

    //----------------------- Distribution List --------------------------//
    const DISTRIBUTION_LIST = 'distribution_list';
    const DISTRIBUTION_LIST_VIEW = 'distribution_list_view';
    const DISTRIBUTION_LIST_CREATE = 'distribution_list_create';
    const DISTRIBUTION_LIST_UPDATE = 'distribution_list_update';
    const DISTRIBUTION_LIST_DELETE = 'distribution_list_delete';
    const DISTRIBUTION_LIST_DELETE_ALL = 'distribution_list_delete_all';

    //----------------------- Modules --------------------------//
    const MODULE = 'module';
    const MODULE_VIEW = 'module_view';
    const MODULE_CREATE = 'module_create';
    const MODULE_UPDATE = 'module_update';
    const MODULE_ORDER = 'module_order';
    const MODULE_DELETE = 'module_delete';
    const MODULE_DELETE_ALL = 'module_delete_all';

    //----------------------- Repositories --------------------------//
    const REPOSITORY = 'repository';
    const REPOSITORY_VIEW = 'repository_view';
    const REPOSITORY_CREATE = 'repository_create';
    const REPOSITORY_UPDATE = 'repository_update';
    const REPOSITORY_DELETE = 'repository_delete';
    const REPOSITORY_DELETE_ALL = 'repository_delete_all';

    //----------------------- Projects --------------------------//
    const PROJECT = 'project';
    const PROJECT_VIEW = 'project_view';
    const PROJECT_CREATE = 'project_create';
    const PROJECT_UPDATE = 'project_update';
    const PROJECT_ASSIGN_USER = 'project_assign_user';
    const PROJECT_ASSIGN_PROJECT = 'project_assign_project';
    const PROJECT_ASSIGN_COMPANIES = 'project_assign_companies';
    const PROJECT_DELETE = 'project_delete';
    const PROJECT_DELETE_ALL = 'project_delete_all';

    //----------------------- WorkFlows --------------------------//
    const WORKFLOW = 'workflow';
    const WORKFLOW_VIEW = 'workflow_view';
    const WORKFLOW_CREATE = 'workflow_create';
    const WORKFLOW_UPDATE = 'workflow_update';
    const WORKFLOW_DELETE = 'workflow_delete';
    const WORKFLOW_DELETE_ALL = 'workflow_delete_all';

    //----------------------- Dashboard --------------------------//

    const DASHBOARD = 'dashboard';
    const DASHBOARD_VIEW = 'dashboard_view';
    const DASHBOARD_CREATE = 'dashboard_create';
    const DASHBOARD_UPDATE = 'dashboard_update';
    const DASHBOARD_DELETE = 'dashboard_delete';
    const DASHBOARD_DELETE_ALL = 'dashboard_delete_all';
    const DASHBOARD_ASSIGN_USER = 'dashboard_assign_user';
    //----------------------- Component --------------------------//
    const COMPONENT = 'component';
    const COMPONENT_VIEW = 'component_view';
    const COMPONENT_CREATE = 'component_create';
    const COMPONENT_UPDATE = 'component_update';
    const COMPONENT_DELETE = 'component_delete';
    const COMPONENT_DELETE_ALL = 'component_delete_all';
    const COMPONENT_ASSIGN_USER = 'component_assign_user';
}

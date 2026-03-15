<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RoleController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Workflow\MainWorkFlowController;
use App\Http\Controllers\Workflow\WorkFlowController;
use App\Http\Controllers\CompanyAbout\{CompanyController, ContactController};
use App\Http\Controllers\CompanyAbout\UserController as CompanyAboutUserController;
use App\Http\Controllers\Distribution\DistributionListsController;
use App\Http\Controllers\Form\{
    FormController,
    FormSubmissionController,
    InputTypeController,
    LayoutController,
    MainTemplateFormController,
    WBSController,
    ModuleController,
    ProjectController
};
use App\Http\Controllers\Form\CustomOption\CustomOptionListController;
use App\Http\Controllers\Form\CustomOption\InputOptionController;
use App\Http\Controllers\InputForm\{InputFormController, PrintInputController};
use App\Http\Controllers\CompanyAbout\PrivateInBoxController;
use App\Http\Controllers\Dashboard\ComponentController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Distribution\DistributionIboxController;
use App\Http\Controllers\Workflow\WorkFlowsController;

use Illuminate\Support\Facades\Route;


//----------------------------[ no Authentication Required ]------------------------------//
Route::group([], function () {
    Route::post('login', [AuthController::class, 'login']);
});





//-----------------------------[ Authenticated Routes ]------------------------------------//
Route::middleware(['auth:api','user.active'])->group(function () {

    //---------------- Auth ------------------------//
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/login-history/{id}', [AuthController::class, 'revokeSessionHistory']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    // Route::resource('roles', );

    Route::get('/my-account',  [UserController::class, 'myAccount']);

    //--------------------- Roles ------------------//
    Route::prefix('roles')->controller(RoleController::class)->group(function () {
    Route::get('/permissions', 'getPermissions');
    Route::get('/', 'index');
    Route::get('/reports', 'reportRole');
    Route::get('/{id}', 'show')->where('id', '[0-9]+');
    Route::post('/', 'store');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});

    Route::group(['prefix' => 'files'], function () {
        Route::post('upload', [FileController::class, 'add']);
    });

    //--------------------- Forms ------------------//
    Route::group(['prefix' => 'forms'], function () {
        Route::get('/', [MainTemplateFormController::class, 'index']);
        Route::get('/export', [MainTemplateFormController::class, 'export']);
        Route::get('/summary', [MainTemplateFormController::class, 'summary']);
        Route::get('/lookup', [MainTemplateFormController::class, 'lookup']);
        Route::get('{main_template_id}/versions', [FormController::class, 'allVersions']);
        Route::get('/{id}', [FormController::class, 'view']);
        Route::get('/{id}/preview', [FormController::class, 'preview']);
        Route::post('/', [FormController::class, 'store']);
        Route::put('/{id}', [FormController::class, 'updateForm']);
        Route::delete('/{id}', [FormController::class, 'delete']);
    });

    //------------------- Form Submission -----------------//
    Route::group(['prefix' => 'form-submissions'], function () {
        Route::get('/emails', [FormSubmissionController::class, 'getManualMail']);
        Route::get('/history', [FormSubmissionController::class, 'history']);
        Route::get('/main-template/{id}', [FormSubmissionController::class, 'submissionMainTemplate']);
        Route::get('/{id}', [FormSubmissionController::class, 'show']);
        Route::post('/emails', [FormSubmissionController::class, 'sendEmail']);
        Route::post('/', [FormSubmissionController::class, 'store']);
        Route::put('/{id}', [FormSubmissionController::class, 'update']);
        Route::delete('/{id}', [FormSubmissionController::class, 'delete']);
        Route::get('/main-template-submissions/{main_template_id}', [FormSubmissionController::class, 'mainTemplateSubmissions']);
    });

    //--------------------- private-inbox ------------------//
    Route::group(['prefix' => 'private-inbox'], function () {
        Route::get('/', [PrivateInBoxController::class, 'index']);
        Route::get('/export', [PrivateInBoxController::class, 'export']);
        Route::get('/my-private', [PrivateInBoxController::class, 'fromContact']);
        Route::get('/un-read-counts', [PrivateInBoxController::class, 'unReadMessageCounter']);
        Route::post('/', [PrivateInBoxController::class, 'sendMessage']);
        Route::put('/mark-read', [PrivateInBoxController::class, 'markAsRead']);
    });

    //---------------- Contacts ----------------//
    Route::group(['prefix' => 'contacts'], function () {
        Route::get('/', [ContactController::class, 'index']);
        Route::get('/export', [ContactController::class, 'export']);
        Route::get('/lookup', [ContactController::class, 'lookup']);
        Route::get('/{id}', [ContactController::class, 'show']);
        Route::get('/{id}/summary', [ContactController::class, 'summary']);
        Route::post('/', [ContactController::class, 'store']);
        Route::put('/{id}', [ContactController::class, 'update'])->where('id', '[0-9]+');
        Route::put('/mark-contact/{id}', [ContactController::class, 'markContact']);
        Route::delete('/{id}', [ContactController::class, 'destroy'])->where('id', '[0-9]+');
        Route::delete('/bulk-delete', [ContactController::class, 'bulkDelete']);
    });

    //---------------- companies  ----------------//
    Route::group(['prefix' => 'companies'], function () {
        Route::get('/', [CompanyController::class, 'index']);
        Route::get('/export', [CompanyController::class, 'export']);
        Route::get('/lookup', [CompanyController::class, 'lookup']);
        Route::get('/{id}', [CompanyController::class, 'view'])->where('id', '[0-9]+');
        Route::get('/{id}/summary', [CompanyController::class, 'summary']);
        Route::post('/', [CompanyController::class, 'store']);
        Route::post('/{id}/update', [CompanyController::class, 'update']);
        Route::delete('/{id}', [CompanyController::class, 'destroy'])->where('id', '[0-9]+');
        Route::delete('/bulk-delete', [CompanyController::class, 'bulkDelete']);
        });

    //----------------- users ---------------------//
    Route::prefix('users')->group(function () {
        Route::get('/export', [CompanyAboutUserController::class, 'export']);
        Route::get('/', [CompanyAboutUserController::class, 'index']);
        Route::get('/{id}', [CompanyAboutUserController::class, 'show'])->where('id', '[0-9]+');
        Route::post('/', [CompanyAboutUserController::class, 'store']);
        Route::put('/{id}', [CompanyAboutUserController::class, 'update'])->where('id', '[0-9]+');
        Route::put('/{id}/admin-change-password', [CompanyAboutUserController::class, 'updatePassword']);
        Route::put('/change-my-password', [CompanyAboutUserController::class, 'updateUserPassword']);
        Route::post('/change-my-picture', [CompanyAboutUserController::class, 'changeMyPicture']);
        Route::get('/avatars', [CompanyAboutUserController::class, 'getAvatars']);
        Route::post('/avatars', [CompanyAboutUserController::class, 'updateAvatar']);
        Route::post('/change-picture', [CompanyAboutUserController::class, 'changePicture']);
        Route::delete('/{id}', [CompanyAboutUserController::class, 'destroy'])->where('id', '[0-9]+');
        Route::delete('/bulk-delete', [CompanyAboutUserController::class, 'bulkDelete']);
        Route::post('/add-signature', [CompanyAboutUserController::class, 'addSignature']);
        Route::get('/signatures', [CompanyAboutUserController::class, 'getSignature']);
        Route::get('/lookup-paginate', [CompanyAboutUserController::class, 'lookUpPagination']);
        Route::post('/logout-other-sessions', [AuthController::class, 'logoutOtherSessions']);
        Route::get('/login-history', [UserController::class, 'loginHistoryData']);
    });

    //----------------- WBS ---------------------------//
     Route::group(['prefix' => 'wbs'],function () {
        Route::get('/', [WBSController::class,'index']);
        Route::get('/export', [WBSController::class,'export']);
        Route::get('/{id}',[WBSController::class, 'show']);
        Route::get('/{id}/summary',[WBSController::class, 'summary']);
        Route::post('/',[WBSController::class, 'store']);
        Route::put('/{id}', [WBSController::class,'update']);
        Route::delete('/{id}', [WBSController::class, 'delete'])->where('id', '[0-9]+');
        Route::delete('/bulk-delete', [WBSController::class, 'bulkDelete']);        //url project
    });

    //------------------ Custom lists ------------------//
 Route::group(['prefix' => 'custom-lists'],function () {
        Route::get("/", [CustomOptionListController::class,"index"]);
        Route::get("/export", [CustomOptionListController::class,"export"]);
        Route::get("/lookup", [CustomOptionListController::class,"lookup"]);
        Route::post("/", [CustomOptionListController::class,"store"]);
        Route::put("/{id}", [CustomOptionListController::class,"update"]);
        Route::get("/{id}", [CustomOptionListController::class,"show"])->where('id', '[0-9]+');
        Route::get("/{id}/summary", [CustomOptionListController::class, "summary"]);
        Route::delete("/{id}", [CustomOptionListController::class, "destroy"])->where('id', '[0-9]+');
        Route::delete('/bulk-delete', [CustomOptionListController::class, 'bulkDelete']);
    });

    //------------------  lists options ------------------//
    Route::group(['prefix' => 'custom-options'],function () {
        Route::get("/", [InputOptionController::class,"index"]);
        Route::get("/lookup", [InputOptionController::class,"lookup"]);
        Route::post("/", [InputOptionController::class,"store"]);
        Route::put("/{id}", [InputOptionController::class, "update"]);
        Route::get("/{id}", [InputOptionController::class,"show"])->where('id', '[0-9]+');
        Route::get("/{id}/summary", [InputOptionController::class, "summary"]);
        Route::delete("/{id}", [InputOptionController::class, "destroy"])->where('id', '[0-9]+');
        Route::delete('/bulk-delete', [InputOptionController::class, 'bulkDelete']);
    });

    //--------------------- Layout ------------------//
    Route::group(['prefix' => 'layouts'], function () {
        Route::get('/', [LayoutController::class, 'index']);
        Route::get('/export', [LayoutController::class, 'export']);
        Route::get('/{id}', [LayoutController::class, 'show']);
        Route::post('/', [LayoutController::class, 'store']);
        Route::put('/{id}', [LayoutController::class, 'update']);
        Route::delete('/{id}', [LayoutController::class, 'destroy'])->where('id', '[0-9]+');
        Route::delete('/bulk-delete', [LayoutController::class, 'bulkDelete']);
    });

    //------------------ distribution lists ------------------//
    Route::group(['prefix' => 'distribution-lists'], function () {
        Route::get("/", [DistributionListsController::class, "index"]);
        Route::get("/export", [DistributionListsController::class, "export"]);
        Route::post("/", [DistributionListsController::class, "store"]);
        Route::put("/{id}", [DistributionListsController::class, "update"]);
        Route::get("/{id}", [DistributionListsController::class, "show"]);
        Route::delete("/{id}", [DistributionListsController::class, "destroy"])->where('id', '[0-9]+');
        Route::delete('/bulk-delete', [DistributionListsController::class, 'bulkDelete']);
    });
    //------------------ distribution inbox ------------------//
    Route::group(['prefix' => 'distribution-inbox'],function () {
        Route::get("/", [DistributionIboxController::class,"index"]);
        Route::post("/", [DistributionIboxController::class,"store"]);
        Route::put('/mark-read', [DistributionIboxController::class, 'markAsRead']);
        Route::get('/un-read-counts', [DistributionIboxController::class, 'unReadMessageCounter']);
        Route::get("/private-message", [DistributionIboxController::class,"privateMessage"]);
    });

    //------------------ module ------------------//
    Route::group(['prefix' => 'module'], function () {
        Route::get("/", [ModuleController::class, "showAll"]);
        Route::get("/export", [ModuleController::class, "export"]);
        Route::get("/lookup", [ModuleController::class, "showLookupData"]);
        Route::get("/mainFormAndModule", [ModuleController::class, "mainFormAndModules"]);
        Route::get("/main-forms-with-versions/{projectId}", [ModuleController::class, "mainFormWithLastVersions"]);
        Route::post("/", [ModuleController::class, "storeModule"]);
        Route::post("/order", [ModuleController::class, "updateOrderModule"]);
        Route::put("/{id}", [ModuleController::class, "updateModule"]);
        Route::get("/{id}", [ModuleController::class, "show"]);
        Route::delete("/{id}", [ModuleController::class, "deleteModule"])->where('id', '[0-9]+');
        Route::delete('/bulk-delete', [ModuleController::class, 'bulkDelete']);
    });

    //------------------ InputTypeController lists ------------------//
    Route::group(['prefix' => 'repository'], function () {
        Route::get("/", [InputTypeController::class, "index"]);
        Route::get("/export", [InputTypeController::class, "export"]);
        Route::get("/categories", [InputTypeController::class, "categories"]);
        Route::post("/", [InputTypeController::class, "store"]);
        Route::put("/{id}", [InputTypeController::class, "update"]);
        Route::get("/{id}", [InputTypeController::class, "show"]);
        Route::delete("/{id}", [InputTypeController::class, "destroy"])->where('id', '[0-9]+');
        Route::delete('/bulk-delete', [InputTypeController::class, 'bulkDelete']);
    });

    //----------------------- Projects --------------------------//
    Route::group(['prefix' => 'project'], function () {
        Route::get("/", [ProjectController::class, "index"]);
        Route::get("/export", [ProjectController::class, "export"]);
        Route::get("/lookup", [ProjectController::class, "lookupProject"]);
        Route::post("/", [ProjectController::class, "storeProject"]);
        Route::post("/{id}", [ProjectController::class, "updateProject"])->where('id', '[0-9]+');
        Route::get("/{id}", [ProjectController::class, "show"]);
        Route::delete('/{id}', [ProjectController::class, 'delete'])->where('id', '[0-9]+');
        Route::delete('/bulk-delete', [ProjectController::class, 'bulkDelete']);
        Route::post("/assign-to-user", [ProjectController::class, "assignProjectsToUser"]);
        Route::post("/assign-to-users", [ProjectController::class, "assignProjectsToUsers"]);
        Route::post("/assign-to-project", [ProjectController::class, "assignUsersToProject"]);
        Route::post('assign-company-and-project', [ProjectController::class, "assignCompany"]);
    });
    //----------------------- Dashboard --------------------------//
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get("/", [DashboardController::class, "index"]);
        Route::get("/lookup", [DashboardController::class, "lookupDashboard"]);
        Route::post("/", [DashboardController::class, "storeDashboard"]);
        Route::put("/{id}", [DashboardController::class, "updateDashboard"]);
        Route::get("/{id}", [DashboardController::class, "show"]);
        Route::delete('/bulk-delete', [DashboardController::class, 'bulkDelete']);
        Route::delete('/{id}', [DashboardController::class, 'destroy']);

    });
    //----------------------- Component --------------------------//
    Route::group(['prefix' => 'component'], function () {
        Route::get("/", [ComponentController::class, "index"]);
        Route::get("/lookup", [ComponentController::class, "lookup"]);
        Route::post("/", [ComponentController::class, "store"]);
        Route::put("/{id}", [ComponentController::class, "update"]);
        Route::get("/{id}", [ComponentController::class, "show"]);
        Route::delete('/bulk-delete', [ComponentController::class, 'bulkDelete']);
        Route::delete('/{id}', [ComponentController::class, 'delete']);

    });


    //----------------------- Workflow --------------------------//
    Route::group(['prefix' => 'workflow'], function () {
        Route::get('/', [MainWorkFlowController::class, 'index']);
        Route::get('/export', [MainWorkFlowController::class, 'export']);
        Route::get('/form', [MainWorkFlowController::class, 'formWithWorkFlow']);
        Route::post('/', [WorkFlowController::class, 'store']);
        Route::put('/{id}', [WorkFlowController::class, 'update']);
        Route::get('/{id}', [WorkFlowController::class, 'view']);
        Route::get('{main_workflow_id}/versions', [WorkFlowController::class, 'allVersions']);
        Route::delete('/bulk-delete', [WorkFlowController::class, 'bulkDelete']);
        Route::delete('/{id}', [WorkFlowController::class, 'delete']);

  });

        //----------------------- lookups-paginate --------------------------//
    Route::group(['prefix' => 'lookups-paginate'], function () {
        Route::get("/module", [ModuleController::class, "lookupPaginate"]);
        Route::get("/project", [ProjectController::class, "lookupPaginate"]);
        Route::get('/roles', [RoleController::class, 'lookupRolesPaginate']);
        Route::get('/permissions', [RoleController::class, 'lookupPermission']);
        Route::get('/companies', [CompanyController::class, 'lookupPaginate']);
        Route::get('/contacts', [ContactController::class, 'lookupPaginate']);
        Route::get('/forms', [MainTemplateFormController::class, 'lookupPaginate']);
        Route::get('/private-inbox', [PrivateInBoxController::class, 'lookupPaginate']);
        Route::get('/wbs', [WBSController::class, 'lookupPaginate']);
        Route::get('/custom-lists', [CustomOptionListController::class, 'lookupPaginate']);
        Route::get('/custom-options', [InputOptionController::class, 'lookupPaginate']);
        Route::get('/layouts', [LayoutController::class, 'lookupPaginate']);
        Route::get('/distribution-lists', [DistributionListsController::class, 'lookupPaginate']);
        Route::get('/distribution-inbox', [DistributionIboxController::class, 'lookupPaginate']);
        Route::get('/repository', [InputTypeController::class, 'lookupPaginate']);
        Route::get('/workflow', [MainWorkFlowController::class, 'lookupPaginate']);

  });

});

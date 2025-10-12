<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [
        'localeSessionRedirect',
        'localizationRedirect',
        'localeViewPath'
    ]
], function () {

   Route::get('/dashboard/{pathMatch?}', function () {
    return view('basic.dashboard'); // هذه الصفحة تحتوي على #dashboard-app
    })->where('pathMatch', '.*');


   Route::get('/vendor/{pathMatch?}', function () {
    return view('basic.dashboard'); // هذه الصفحة تحتوي على #dashboard-app
    })->where('pathMatch', '.*');




    Route::get('/{pathMatch?}', function () {
        return view('basic.landing'); // هذه الصفحة تحتوي على #app
    })->where('pathMatch', '^(?!dashboard).*')->where('pathMatch', '^(?!vendor).*')->where('pathMatch', '^(?!web).*'); // أي شيء لا يبدأ بـ "dashboard"







    Route::group(['prefix' => 'web'], function () {
        Route::post('/login', [App\Http\Controllers\Web\AuthController::class, 'login']);

        

    });





    Route::group(['prefix' => 'web', 'middleware' => ['auth:sanctum']], function () {
        


        Route::group(['prefix' => 'UserAuth'], function () {

            Route::get('getAuth', [App\Http\Controllers\Web\UserController::class,'getAuth']);
        
        });



        Route::group(['prefix' => 'Users'], function () {

            Route::get('getAllItems', [App\Http\Controllers\Web\UserController::class,'getAll']);
            Route::get('getById', [App\Http\Controllers\Web\UserController::class,'getById']);
            Route::post('createItem', [App\Http\Controllers\Web\UserController::class,'create']);
            Route::post('editItem', [App\Http\Controllers\Web\UserController::class,'edit']);
            Route::post('EditItemPassword', [App\Http\Controllers\Web\UserController::class,'edit_password']);
            Route::Delete('deleteItem/{id}', [App\Http\Controllers\Web\UserController::class,'delete']);
            Route::Delete('deleteAllItem', [App\Http\Controllers\Web\UserController::class,'deleteAllItem']);
        
        });
       


        Route::group(['prefix' => 'Roles'], function () {

            Route::get('getAllItems', [App\Http\Controllers\Web\RoleController::class,'getAll']);
            Route::get('getById', [App\Http\Controllers\Web\RoleController::class,'getById']);
            Route::post('createItem', [App\Http\Controllers\Web\RoleController::class,'create']);
            Route::post('editItem', [App\Http\Controllers\Web\RoleController::class,'edit']);
            Route::Delete('deleteItem/{id}', [App\Http\Controllers\Web\RoleController::class,'delete']);
            Route::Delete('deleteAllItem', [App\Http\Controllers\Web\RoleController::class,'deleteAllItem']);
            Route::Delete('getAllItemsPermission', [App\Http\Controllers\Web\RoleController::class,'deleteAllItem']);
        
        });



        Route::group(['prefix' => 'Permission'], function () {

            Route::get('getAllItems', [App\Http\Controllers\Web\RoleController::class,'getAllPermission']);
          
        
        });

        Route::group(['prefix' => 'Languages'], function () {

            Route::get('getAllItems', [App\Http\Controllers\Web\LanguageController::class,'getAllItems']);
          
        
        });


        Route::group(['prefix' => 'Positions'], function () {

            Route::get('getAllItems', [App\Http\Controllers\Web\HR\PositionController::class,'getAll']);
            Route::get('getById', [App\Http\Controllers\Web\HR\PositionController::class,'getById']);
            Route::post('createItem', [App\Http\Controllers\Web\HR\PositionController::class,'create']);
            Route::post('editItem', [App\Http\Controllers\Web\HR\PositionController::class,'edit']);
            Route::Delete('deleteItem/{id}', [App\Http\Controllers\Web\HR\PositionController::class,'delete']);
            Route::Delete('deleteAllItem', [App\Http\Controllers\Web\HR\PositionController::class,'deleteAllItem']);
        
        });

        Route::group(['prefix' => 'Departments'], function () {

            Route::get('getAllItems', [App\Http\Controllers\Web\HR\DepartmentController::class,'getAll']);
            Route::get('getById', [App\Http\Controllers\Web\HR\DepartmentController::class,'getById']);
            Route::post('createItem', [App\Http\Controllers\Web\HR\DepartmentController::class,'create']);
            Route::post('editItem', [App\Http\Controllers\Web\HR\DepartmentController::class,'edit']);
            Route::Delete('deleteItem/{id}', [App\Http\Controllers\Web\HR\DepartmentController::class,'delete']);
            Route::Delete('deleteAllItem', [App\Http\Controllers\Web\HR\DepartmentController::class,'deleteAllItem']);
        
        });


        Route::group(['prefix' => 'Sections'], function () {

            Route::get('getAllItems', [App\Http\Controllers\Web\HR\SectionController::class,'getAll']);
            Route::get('getById', [App\Http\Controllers\Web\HR\SectionController::class,'getById']);
            Route::post('createItem', [App\Http\Controllers\Web\HR\SectionController::class,'create']);
            Route::post('editItem', [App\Http\Controllers\Web\HR\SectionController::class,'edit']);
            Route::Delete('deleteItem/{id}', [App\Http\Controllers\Web\HR\SectionController::class,'delete']);
            Route::Delete('deleteAllItem', [App\Http\Controllers\Web\HR\SectionController::class,'deleteAllItem']);
        
        });




        Route::group(['prefix' => 'Employees'], function () {

            Route::get('getAllItems', [App\Http\Controllers\Web\HR\EmployeeController::class,'getAll']);
            Route::get('getById', [App\Http\Controllers\Web\HR\EmployeeController::class,'getById']);
            Route::post('createItem', [App\Http\Controllers\Web\HR\EmployeeController::class,'create']);
            Route::post('editItem', [App\Http\Controllers\Web\HR\EmployeeController::class,'edit']);
            Route::Delete('deleteItem/{id}', [App\Http\Controllers\Web\HR\EmployeeController::class,'delete']);
            Route::Delete('deleteAllItem', [App\Http\Controllers\Web\HR\EmployeeController::class,'deleteAllItem']);
        
        });


        Route::group(['prefix' => 'EmployeePositions'], function () {

            Route::get('getAllItems', [App\Http\Controllers\Web\HR\EmployeePositionsController::class,'getAll']);
            Route::get('getById', [App\Http\Controllers\Web\HR\EmployeePositionsController::class,'getById']);
            Route::post('createItem', [App\Http\Controllers\Web\HR\EmployeePositionsController::class,'create']);
            Route::post('editItem', [App\Http\Controllers\Web\HR\EmployeePositionsController::class,'edit']);
            Route::Delete('deleteItem/{id}', [App\Http\Controllers\Web\HR\EmployeePositionsController::class,'delete']);
            Route::Delete('deleteAllItem', [App\Http\Controllers\Web\HR\EmployeePositionsController::class,'deleteAllItem']);
        
        });


        Route::group(['prefix' => 'PositionHistory'], function () {

            Route::get('getAllItems', [App\Http\Controllers\Web\HR\PositionHistoryController::class,'getAll']);
            Route::get('getById', [App\Http\Controllers\Web\HR\PositionHistoryController::class,'getById']);
            Route::post('createItem', [App\Http\Controllers\Web\HR\PositionHistoryController::class,'create']);
            Route::post('editItem', [App\Http\Controllers\Web\HR\PositionHistoryController::class,'edit']);
            Route::Delete('deleteItem/{id}', [App\Http\Controllers\Web\HR\PositionHistoryController::class,'delete']);
            Route::Delete('deleteAllItem', [App\Http\Controllers\Web\HR\PositionHistoryController::class,'deleteAllItem']);
        
        });



        Route::group(['prefix' => 'ItemsTypes'], function () {

            Route::get('getAllItems', [App\Http\Controllers\Web\MasterData\ItemsTypesController::class,'getAll']);
        
        });


        Route::group(['prefix' => 'ItemsCategories'], function () {

            Route::get('getAllItems', [App\Http\Controllers\Web\MasterData\ItemsCategoriesController::class,'getAll']);
            Route::get('getAllItemsByType', [App\Http\Controllers\Web\MasterData\ItemsCategoriesController::class,'getAllItemsByType']);
            Route::get('getById', [App\Http\Controllers\Web\MasterData\ItemsCategoriesController::class,'getById']);
            Route::post('createItem', [App\Http\Controllers\Web\MasterData\ItemsCategoriesController::class,'create']);
            Route::post('editItem', [App\Http\Controllers\Web\MasterData\ItemsCategoriesController::class,'edit']);
            Route::Delete('deleteItem/{id}', [App\Http\Controllers\Web\MasterData\ItemsCategoriesController::class,'delete']);
            Route::Delete('deleteAllItem', [App\Http\Controllers\Web\MasterData\ItemsCategoriesController::class,'deleteAllItem']);
        
        });


        Route::group(['prefix' => 'ItemsObjects'], function () {

            Route::get('getAllItems', [App\Http\Controllers\Web\MasterData\ItemsObjectsController::class,'getAll']);
            Route::get('getById', [App\Http\Controllers\Web\MasterData\ItemsObjectsController::class,'getById']);
            Route::post('createItem', [App\Http\Controllers\Web\MasterData\ItemsObjectsController::class,'create']);
            Route::post('editItem', [App\Http\Controllers\Web\MasterData\ItemsObjectsController::class,'edit']);
            Route::Delete('deleteItem/{id}', [App\Http\Controllers\Web\MasterData\ItemsObjectsController::class,'delete']);
            Route::Delete('deleteAllItem', [App\Http\Controllers\Web\MasterData\ItemsObjectsController::class,'deleteAllItem']);
        
        });




     



        Route::group(['prefix' => 'Project'], function () {

            Route::get('getAllItems', [App\Http\Controllers\Web\Projects\ProjectController::class,'getAll']);
            Route::get('getAllItemsAllSteps', [App\Http\Controllers\Web\Projects\ProjectController::class,'getAllItemsAllSteps']);
            Route::get('getById', [App\Http\Controllers\Web\Projects\ProjectController::class,'getById']);
            Route::post('createItem', [App\Http\Controllers\Web\Projects\ProjectController::class,'create']);
            Route::post('editItem', [App\Http\Controllers\Web\Projects\ProjectController::class,'edit']);
            Route::Delete('deleteItem/{id}', [App\Http\Controllers\Web\Projects\ProjectController::class,'delete']);
            Route::Delete('deleteAllItem', [App\Http\Controllers\Web\Projects\ProjectController::class,'deleteAllItem']);
        
        });

 


        Route::group(['prefix' => 'RFPStep'], function () {

            Route::get('getAllItems', [App\Http\Controllers\Web\Projects\RFPStepController::class,'getAll']);
            Route::get('getAllItemsAllSteps', [App\Http\Controllers\Web\Projects\RFPStepController::class,'getAllItemsAllSteps']);
            Route::get('getById', [App\Http\Controllers\Web\Projects\RFPStepController::class,'getById']);
            Route::post('createItem', [App\Http\Controllers\Web\Projects\RFPStepController::class,'create']);
            Route::post('editItem', [App\Http\Controllers\Web\Projects\RFPStepController::class,'edit']);
            Route::Delete('deleteItem/{id}', [App\Http\Controllers\Web\Projects\RFPStepController::class,'delete']);
            Route::Delete('deleteAllItem', [App\Http\Controllers\Web\Projects\RFPStepController::class,'deleteAllItem']);
            Route::post('editItemStep', [App\Http\Controllers\Web\Projects\RFPStepController::class,'editStep']);
            Route::get('getAllItemsWordFile', [App\Http\Controllers\Web\Projects\RFPStepController::class,'getAllItemsWordFile']);

        });




        Route::group(['prefix' => 'Steps'], function () {

            Route::get('getAllItems', [App\Http\Controllers\Web\Projects\StepsController::class,'getAll']);
            Route::get('getById', [App\Http\Controllers\Web\Projects\StepsController::class,'getById']);
            Route::post('createItem', [App\Http\Controllers\Web\Projects\StepsController::class,'create']);
            Route::post('editItem', [App\Http\Controllers\Web\Projects\StepsController::class,'edit']);
            Route::Delete('deleteItem/{id}', [App\Http\Controllers\Web\Projects\StepsController::class,'delete']);
            Route::Delete('deleteAllItem', [App\Http\Controllers\Web\Projects\StepsController::class,'deleteAllItem']);
        
        });


        Route::group(['prefix' => 'Gantt'], function () {

            Route::get('/gantt', [App\Http\Controllers\Web\Projects\GanttTaskController::class, 'index']);
            Route::post('/gantt', [App\Http\Controllers\Web\Projects\GanttTaskController::class, 'store']);
            Route::put('/gantt/{id}', [App\Http\Controllers\Web\Projects\GanttTaskController::class, 'update']);
            Route::delete('/gantt/{id}', [App\Http\Controllers\Web\Projects\GanttTaskController::class, 'destroy']);
            Route::post('/gantt-tasks/save', [GanttTaskController::class, 'store']);

        
        });




        Route::group(['prefix' => 'ItemsTechnicals'], function () {

            Route::get('Withdrow', [App\Http\Controllers\Web\MasterData\ItemsTechnicalsController::class,'withdrow']);
            Route::get('getAllItems', [App\Http\Controllers\Web\MasterData\ItemsTechnicalsController::class,'getAll']);
            Route::get('getById', [App\Http\Controllers\Web\MasterData\ItemsTechnicalsController::class,'getById']);
            Route::post('createItem', [App\Http\Controllers\Web\MasterData\ItemsTechnicalsController::class,'create']);
            Route::post('editItem', [App\Http\Controllers\Web\MasterData\ItemsTechnicalsController::class,'edit']);
            Route::Delete('deleteItem/{id}', [App\Http\Controllers\Web\MasterData\ItemsTechnicalsController::class,'delete']);
            Route::Delete('deleteAllItem', [App\Http\Controllers\Web\MasterData\ItemsTechnicalsController::class,'deleteAllItem']);
        
        });



       
        Route::group(['prefix' => 'ReviewApprove'], function () {

            Route::get('getAllItems', [App\Http\Controllers\Web\Projects\ReviewApproveController::class,'getAll']);
            Route::get('getById', [App\Http\Controllers\Web\Projects\ReviewApproveController::class,'getById']);
            Route::post('createItem', [App\Http\Controllers\Web\Projects\ReviewApproveController::class,'create']);
            Route::post('editItem', [App\Http\Controllers\Web\Projects\ReviewApproveController::class,'edit']);

        });



        Route::group(['prefix' => 'SOIApprove'], function () {

            Route::get('getAllItems', [App\Http\Controllers\Web\Projects\SOIApproveController::class,'getAll']);
            Route::get('getById', [App\Http\Controllers\Web\Projects\SOIApproveController::class,'getById']);
            Route::post('createItem', [App\Http\Controllers\Web\Projects\SOIApproveController::class,'create']);
            Route::post('editItem', [App\Http\Controllers\Web\Projects\SOIApproveController::class,'edit']);

        });



        Route::group(['prefix' => 'VendorApprove'], function () {

            Route::get('getAllItems', [App\Http\Controllers\Web\Projects\VendorApproveController::class,'getAll']);
            Route::get('getById', [App\Http\Controllers\Web\Projects\VendorApproveController::class,'getById']);
            Route::post('createItem', [App\Http\Controllers\Web\Projects\VendorApproveController::class,'create']);
            Route::post('createItemDocument', [App\Http\Controllers\Web\Projects\VendorApproveController::class,'createItemDocument']);

        });



        Route::group(['prefix' => 'BuyerApprove'], function () {

            Route::get('getAllItems', [App\Http\Controllers\Web\Projects\BuyerApproveController::class,'getAll']);
            Route::get('getById', [App\Http\Controllers\Web\Projects\BuyerApproveController::class,'getById']);
            Route::post('createItem', [App\Http\Controllers\Web\Projects\BuyerApproveController::class,'create']);
            Route::post('createItemDate', [App\Http\Controllers\Web\Projects\BuyerApproveController::class,'createItemDate']);
            Route::get('excelResponse', [App\Http\Controllers\Web\Projects\BuyerApproveController::class,'excelResponse']);
            Route::get('getAllItemsResponseVendor', [App\Http\Controllers\Web\Projects\BuyerApproveController::class,'getAllItemsResponseVendor']);
            Route::get('getAllItemsResponseVendorInvited', [App\Http\Controllers\Web\Projects\BuyerApproveController::class,'getAllItemsResponseVendorInvited']);
            Route::get('getAllItemsStaticitics', [App\Http\Controllers\Web\Projects\BuyerApproveController::class,'getAllItemsStaticitics']);
            
            Route::post('Store', [App\Http\Controllers\Web\Projects\BuyerApproveController::class,'Store']);


        });




        Route::group(['prefix' => 'VendorManagementApprove'], function () {

            Route::get('getAllItems', [App\Http\Controllers\Web\Projects\VendorManagementController::class,'getAll']);
            Route::get('getById', [App\Http\Controllers\Web\Projects\VendorManagementController::class,'getById']);
            Route::post('createItem', [App\Http\Controllers\Web\Projects\VendorManagementController::class,'create']);
            Route::post('createItemDate', [App\Http\Controllers\Web\Projects\VendorManagementController::class,'createItemDate']);
            Route::get('excelResponse', [App\Http\Controllers\Web\Projects\VendorManagementController::class,'excelResponse']);
            Route::get('getAllItemsResponseVendor', [App\Http\Controllers\Web\Projects\VendorManagementController::class,'getAllItemsResponseVendor']);
            Route::get('getAllItemsStaticitics', [App\Http\Controllers\Web\Projects\VendorManagementController::class,'getAllItemsStaticitics']);
            
            Route::post('Store', [App\Http\Controllers\Web\Projects\VendorManagementController::class,'Store']);

        });




        Route::group(['prefix' => 'BuyerTps'], function () {

            Route::get('getAllItems', [App\Http\Controllers\Web\Projects\BuyerTpsController::class,'getAll']);
            Route::get('getById', [App\Http\Controllers\Web\Projects\BuyerTpsController::class,'getById']);
            Route::post('createItem', [App\Http\Controllers\Web\Projects\BuyerTpsController::class,'create']);
            Route::post('Store', [App\Http\Controllers\Web\Projects\BuyerTpsController::class,'Store']);
            Route::post('createItemApprove', [App\Http\Controllers\Web\Projects\BuyerTpsController::class,'createItemApprove']);
            Route::post('createTPSData', [App\Http\Controllers\Web\Projects\BuyerTpsController::class,'createTPSData']);
            Route::post('publish', [App\Http\Controllers\Web\Projects\BuyerTpsController::class,'publish']);
            Route::post('sendQuestion', [App\Http\Controllers\Web\Projects\BuyerTpsController::class,'sendQuestion']);


        });



















    }); // End Prefix Web

}); //End Localizations









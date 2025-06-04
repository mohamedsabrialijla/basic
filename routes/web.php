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




        Route::group(['prefix' => 'Steps'], function () {

            Route::get('getAllItems', [App\Http\Controllers\Web\Projects\StepsController::class,'getAll']);
            Route::get('getById', [App\Http\Controllers\Web\Projects\StepsController::class,'getById']);
            Route::post('createItem', [App\Http\Controllers\Web\Projects\StepsController::class,'create']);
            Route::post('editItem', [App\Http\Controllers\Web\Projects\StepsController::class,'edit']);
            Route::Delete('deleteItem/{id}', [App\Http\Controllers\Web\Projects\StepsController::class,'delete']);
            Route::Delete('deleteAllItem', [App\Http\Controllers\Web\Projects\StepsController::class,'deleteAllItem']);
        
        });


       


















    }); // End Prefix Web

}); //End Localizations









<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index');
Route::post('/select_branch', 'SelectBranchController@index');
Route::get('/workorder_create', function () {
    return view('workorder/workorder_create');
});

//These are for testing purpose(should be removed when testing is done)
Route::get('/workorder_create_test', function () {
    return view('workorder/workorder_create_test');
});

Route::get('/workorder_list_test', function () {
    return view('workorder/workorder_list_test');
});

Route::post('ajax/workorder_create', 'WorkOrderController@save');

Route::get('ajax/workorder_get_appliance_data', 'WorkOrderController@getApplianceData');

Route::get('ajax/workorder_get_employees', 'WorkOrderController@getEmployees');
Route::get('ajax/workorder_get_branches', 'WorkOrderController@getBranchesByEmployeeId');

Route::get('ajax/workorder-list', 'WorkOrderController@getWorkOrdersList');

Route::get('admin-login', 'Auth\AdminLoginController@showLoginForm');

Route::post('logout-admin', 'Auth\AdminLoginController@logout')->name('logout-admin');

Route::post('admin-login', ['as'=>'admin-login','uses'=>'Auth\AdminLoginController@login']);

Route::resource('users', 'UserAdminController');

Route::get('show-user/{id}', 'UserAdminController@show')->name('show.user');

Route::get('activate/{id}', 'UserAdminController@deactivateUser')->name('activate');

Route::get('edit-admin', 'UserAdminController@editAdminForm')->name('edit-admin');
Route::post('edit-complete', 'UserAdminController@editAdmin')->name('edit-complete');

Route::group(['middleware' => 'auth'], function(){
    Route::get('/dashboard', 'DashboardController@index')->name('user.home');
    Route::get('/provider-parameters', 'DashboardController@providerParameters');
    Route::get('/supplier-parameters', 'DashboardController@supplierParameters');
    Route::post('/save-provider-parameters', 'DashboardController@saveProviderParameters');
    Route::post('/save-supplier-parameters', 'DashboardController@saveSupplierParameters');
    Route::post('/save-branch', 'DashboardController@saveBranch');
});

Route::group([
    'prefix' => 'ajax',
    'middleware' => ['ajax', 'auth']
], function() {
    Route::resource('/employees', 'EmployeeController');
    Route::get('/employees/{id}/branch_roles', 'EmployeeController@branchRoles');
    Route::put('/employees/{id}/parameters', 'EmployeeController@updateParameters');
    Route::put('/employees/{id}/role', 'EmployeeController@updateRole');

    
    Route::resource('/technicians', 'TechnicianController');
    Route::put('/technicians/{id}/parameters', 'TechnicianController@updateParameters');
    Route::put('/technicians/{id}/branch', 'TechnicianController@updateBranch');
    Route::put('/technicians/{id}/zip', 'TechnicianController@updateZip');
    Route::put('/technicians/{id}/stack', 'TechnicianController@updateStack');

//    Route::resource('/workorder', 'WorkOrderController');
//    Route::get('/workorder_create', function ()    {
//        return view('workorder/workorder_create');
//    });
//    Route::post('/workorder_create', 'WorkOrderController@save');
//
//    Route::get('/workorder_get_providers', 'WorkOrderController@getBranchProviders');
});

Route::group(['name' => 'api'], function () {
    // Route::post('/add_branch', 'BranchController@add_branch'); 
});

// delete or comment it when not using
Route::get('/run-migrations', function () {
    return Artisan::call('migrate');
});
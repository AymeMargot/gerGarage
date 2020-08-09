<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'ServiceController@listPublic');
Route::get('/home', 'ServiceController@listPublic');
Route::get('/services', 'ServiceController@listServices');
Route::get('/listAccessories', 'ServiceController@listAccessories');
Route::get('/listSupplies', 'ServiceController@listSupplies');
Route::get('/listVehicleparts', 'ServiceController@listVehicleparts');

Route::get('/supplies', function () {
    return view('supplies');
});
Route::get('/vehicleparts', function () {
    return view('vehicleparts');
});
Route::get('/about', function () {
    return view('about');
});

//================== Routes =============================================================================
Route::resource('/messages', 'MessageController');
Route::resource('/bookings', 'BookingController');
Route::get('/bookingSearch', 'BookingController@search');
Route::get('/bookings/delete/{id}', ['as' => 'id', 'uses' => 'BookingController@destroyByuser']);
Route::get('/rosterSearch', 'RosterController@search');
Route::get('/rosterUserSearch', 'RosterController@UserSearch');
Route::resource('/accessories', 'AccessoryController');
Route::get('/accessorySearch', 'AccessoryController@search');
Route::resource('/vehicles_parts', 'VehiclePartController');
Route::get('/vehiclePartSearch', 'VehiclePartController@search');
Route::resource('/invoices', 'InvoiceController'); 
Route::get('/invoiceSearch', 'InvoiceController@search');
Route::resource('/invoices_supplies', 'InvoiceSupplyController');
Route::resource('/invoices_vehicleparts', 'InvoiceVehiclepartController');
Route::get('/invoice_supplies/delete/{id}', ['as' => 'id', 'uses' => 'InvoiceSupplyController@destroy']);
Route::get('/invoices_vehicleparts/delete/{id}', ['as' => 'id', 'uses' => 'InvoiceVehiclepartController@destroy']);
Route::resource('/rosters', 'RosterController'); 
Route::get('/rosters/show', 'RosterController@show');
Route::resource('/staff', 'StaffController');
Route::get('/staffSearch', 'StaffController@search');
Route::resource('/supplies', 'SupplyController');
Route::get('/supplySearch', 'SupplyController@search');
Route::resource('/makes', 'BrandController');
Route::get('/makeSearch', 'BrandController@search');
Route::delete('/deleteAll','BrandController@deleteAll');
Route::resource('/messages', 'MessageController');
Route::get('/messageSearch', 'MessageController@search');

Route::get('/loadData', 'LoadDataController@load');
//========================================================================================================

Route::get('/singleAccessory/{id}', ['as' => 'id', 'uses' => 'AccessoryController@single']);
#Route::get('/booking/{id}', ['as' => 'id', 'uses' => 'BookingController@index']);



//Route::resource('/invoices_supplies', 'InvoiceSupplyController');

//Route::get('/bookings/create', 'BookingController@create')->name('bookings.create');
//Route::get('/bookings/create/{id}', 'BookingController@getVehicle');


Route::resource('/vehicles', 'VehicleController');



//Route::get('/invoices/create/{id}', ['as' => 'id', 'uses' => 'InvoiceController@create']);
//Route::get('/invoices/edit/{id}', ['as' => 'id', 'uses' => 'InvoiceController@edit']);

//Route::resource('/invoices_supplies', 'InvoiceSupplyController');
//Route::get('/invoice_supplies/create/{id}', ['as' => 'id', 'uses' => 'InvoiceSupplyController@create']);
//Route::get('/invoice_supplies/edit/{id}', ['as' => 'id', 'uses' => 'InvoiceSupplyController@edit']);
//Route::post('/invoice_supplies/save/{id}', ['as' => 'id', 'uses' => 'InvoiceSupplyController@store']);
//Route::get('/invoice_supplies/delete/{id}', ['as' => 'id', 'uses' => 'InvoiceSupplyController@destroy',
//]);
//Route::resource('/invoices_supplies', 'InvoiceSupplyController');
//('/invoices/save', ['as' => 'id', 'uses' => 'InvoiceController@store']);
//Route::post('/invoices/create', 'InvoiceController@store');
//Route::post('/invoices/edit', 'InvoiceController@store');

//Route::post('/invoices/save','InvoiceController@store');
//Route::get('/invoices', 'InvoiceController@index');

Route::get('/dashboard', function () {
    return view('dashboard.index');
});
//Route::get('/garage', 'HomeController@index')->name('garage')->middleware('auth');
//Auth::routes();

Auth::routes();
//Route::get('login','Auth.RegisterController');
//Route::get('register', [ 'as' => 'register', 'uses' => 'RegisterController']);

Route::get('/home', 'ServiceController@listPublic')->name('home');

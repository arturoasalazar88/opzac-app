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

// Route::get('/example','PagesController@exampleMethod');

/*==============================================*/
/* Projects Routes
/*==============================================*/
Route::get('/projects/create','ProjectsController@create')->name('create_project');
Route::get('/projects','ProjectsController@index');
Route::get('/projects/{project}','ProjectsController@show');
Route::get('/projects/{project}/edit','ProjectsController@edit');
Route::post('/projects','ProjectsController@store')->name('projects_store');
Route::patch('/projects/{project}','ProjectsController@update');
Route::delete('/projects/{project}','ProjectsController@destroy');

/*==============================================*/
/* Tasks Routes
/*==============================================*/
Route::patch('/tasks/{task}','ProjectTasksController@update')->name('tasks_update');
Route::post('/projects/{project}/task/','ProjectTasksController@store')->name('tasks_store');

/*==============================================*/
/* Reservations Routes
/*==============================================*/
Route::post('/reservations', 'ReservationsController@store')->name('reservations_store')->middleware('auth');
Route::get('/reservations','ReservationsController@index')->name('reservations_index')->middleware('auth');
/// this one will show the latest reservations for a single company
Route::get('/companies/reservations','ReservationsController@indexCompanies')->name('companies_reservations')->middleware('auth');
Route::get('/reservations/company/{company}','ReservationsController@indexCompany')->name('reservations_company')->middleware('auth');
Route::get('/reservations/create','ReservationsController@create')->name('reservations_create')->middleware('auth');
Route::get('/reservations/company/{company}/create','ReservationsController@createCompany')->name('reservations_company_create')->middleware('auth');
Route::get('/reservations/company/{company}/create','ReservationsController@createCompany')->name('reservations_company_create')->middleware('auth');
Route::get('/reservations/{reservation}','ReservationsController@show')->name('reservations_show')->middleware('auth');
Route::get('/reservations/edit/{reservation}','ReservationsController@edit')->name('reservations_edit')->middleware('auth');
Route::put('/reservations/{reservation}','ReservationsController@update')->name('reservation_update')->middleware('auth');
Route::post('/reservations/select/seat', 'ReservationsController@selectSeat')->name('reservations_select_seat')->middleware('auth');
Route::post('/reservations/store/seats', 'ReservationsController@storeWithSeats')->name('reservations_store_seat')->middleware('auth');
Route::put('/reservation/confirm/{reservation}', 'ReservationsController@confirm')->name('reservation_make_confirm')->middleware('auth');
Route::get('/reservation/confirm/{reservation}', 'ReservationsController@showConfirm')->name('reservation_show_confirm')->middleware('auth');

Route::get('/reservation/cancel/{reservation}', 'ReservationsController@cancel')->name('reservation_cancel')->middleware('auth');
/*==============================================*/
/* Reservations Select
/* Companies First Routes
/*==============================================*/
/// This first two only display the select your company first part
Route::get('/fast/menu', 'CompanyReservationsController@fastMenu')->name('fast_menu');
Route::post('/fast/menu', 'CompanyReservationsController@fastMenuSearch')->name('fast_menu_search');
Route::get('/fast/create', 'CompanyReservationsController@fastCreate')->name('fast_create');
Route::get('/company/select/view','CompanyReservationsController@selectCompanyView')->name('company_select_view')->middleware('auth');
Route::get('/company/select/create','CompanyReservationsController@selectCompanyCreate')->name('company_select_create')->middleware('auth');
/// The next two routes are only to send the correct views
/// This one will be triggred after selecting your company and show you the
/// select your company -> tour Part
Route::get('/company/{company}/select/tour','CompanyReservationsController@selectCompanyTour')->name('company_select_tour')->middleware('auth');
/// This one will show the create form for the reservation for only one single tour
Route::get('/company/create/tour/{tour}','CompanyReservationsController@showCreateReservationTour')->name('company_create_reservation')->middleware('auth');
Route::get('/company/create/tour', 'CompanyReservationsController@showCreateReservation')->name('company_create_reservation_2')->middleware('auth');
// Route::get('/company/create/tour', 'CompanyReservationsController@showCreateReservation')->name('company_create_reservation_2')->middleware('auth');
/*==============================================*/
/* SOME TESTS
/*==============================================*/
Route::get('test/uno/{company}', 'ToursViewsController@test')->middleware('auth');
Route::post('test/dos/{tour}', 'ToursViewsController@singleTourDate')->name('test_dos')->middleware('auth');
Route::get('/test/chairs', function(){
    return view('tests.chairs');
})->middleware('auth');
Route::post('/test/chair/request', 'TestController@testRequestSeats')->name('test_request_seats')->middleware('auth');
Route::get('/test/username', function(){
    dd(Config::get('mail'));
})->middleware('auth');

/*==============================================*/
/* Pick Up Routes
/*==============================================*/
Route::get('/pickup/types', 'ToursViewsController@showPickupTypes')->name('pickup_types')->middleware('auth');
/// Selects the company before the total type
Route::get('/pickup/zone/company/select', 'ToursViewsController@selectCompanyBeforeZone')->name('tour_select_company_before_zone')->middleware('auth');
Route::get('/pickup/horario/company/select', 'ToursViewsController@selectCompanyBeforeHour')->name('tour_select_company_before_hour')->middleware('auth');
Route::get('/pickup/hotel/company/select', 'ToursViewsController@selectCompanyBeforeHotel')->name('tour_select_company_before_hotel')->middleware('auth');
Route::get('/pickup/tours/company/select', 'ToursViewsController@selectCompanyBeforeTour')->name('tour_select_company_before_tours')->middleware('auth');
// Manage the zones
Route::get('/pickup/zone/selected/{company}', 'ToursViewsController@ZonaSelect')->name('tour_zona_select')->middleware('auth');
Route::post('/pickup/zone/result', 'ToursViewsController@ZonesPickupOutput')->name('zones_result')->middleware('auth');
// Manage the hours
Route::get('/pickup/hour/selected/{company}','ToursViewsController@hourSelect')->name('tour_hour_select')->middleware('auth');
Route::post('/pickup/hour/result', 'ToursViewsController@hoursPickupOutput')->name('hours_result')->middleware('auth');
// Manage the Hotels
Route::get('/pickup/hotel/selected/{company}', 'ToursViewsController@hotelSelect')->name('tour_hotel_select')->middleware('auth');
Route::post('/pickup/hotel/result/horarios', 'ToursViewsController@hotelsPickupOutputHorario')->name('hotels_result_horarios')->middleware('auth');
Route::post('/pickup/hotel/result/tours', 'ToursViewsController@hotelsPickupOutputTours')->name('hotels_result_tours')->middleware('auth');
//manage the tours
Route::get('/pickup/tour/selected/{company}','ToursViewsController@tourSelect')->name('pickup_select_tour')->middleware('auth');
Route::post('/pickup/tour/result', 'ToursViewsController@toursSelectOutput')->name('pickup_result_tours')->middleware('auth');
Route::get('/pdf/tour/result', 'ToursPDFController@printTours2')->name('pickup_result_tours_pdf')->middleware('auth');

/*==============================================*/
/* Tours Routes
/*==============================================*/
Route::get('/tours','ToursController@index')->name('tours_index')->middleware('auth');
Route::get('/tours/company/{company}','ToursController@showToursCompany')->name('tours_company')->middleware('auth');
Route::get('/tours/create','ToursController@create')->name('tours_create')->middleware('auth');
Route::get('/tours/{tour}','ToursController@show')->name('tours_show')->middleware('auth');
Route::get('/tour/show/departures','ToursController@getTourDepartures')->name('tours_get_departures')->middleware('auth');
Route::get('/tour/show/{tour}','ToursController@getTour')->name('tours_get')->middleware('auth');
Route::post('/tours','ToursController@store')->name('tours_store')->middleware('auth');
Route::get('/tours/{tour}/edit','ToursController@edit')->name('tours_edit')->middleware('auth');
Route::put('/tours/{tour}','ToursController@update')->name('tours_update')->middleware('auth');
Route::delete('/tours/{tour}','ToursController@destroy')->name('tours_destroy')->middleware('auth');

Route::post('/tours/prices','ToursController@getPrices')->name('tour_get_prices');
Route::get('/tours/{tour}/departures','ToursController@showDepartures')->name('tours_select_departure')->middleware('auth');
/*==============================================*/
/* Tours Viwes Controller
/*==============================================*/
//I will move this method no printable, and not pickups
Route::post('/show/single/{departure}/date', 'ToursViewsController@singleTourDate')->name('show_single_tour_date')->middleware('auth');
Route::get('/show/single/{departure}/date', 'ToursViewsController@singleTourDate')->name('show_single_tour_date_get')->middleware('auth');
Route::get('/show/single/departure', 'ToursViewsController@singleTourDateGET')->name('show_single_tour_date_get_2')->middleware('auth');
/*==============================================*/
/* Logs Routes
/*==============================================*/
Route::any('/logs', 'LogsController@index')->name('index_logs')->middleware('auth');
/*==============================================*/
/* Hotels Routes
/*==============================================*/
Route::get('/hotels','HotelsController@index')->name('hotels_index')->middleware('auth');
Route::get('/hotels/create','HotelsController@create')->name('hotels_create')->middleware('auth');
Route::get('/hotels/{hotel}','HotelsController@show')->name('hotels_show')->middleware('auth');
Route::post('/hotels','HotelsController@store')->name('hotels_store')->middleware('auth');
Route::get('/hotels/{hotel}/edit','HotelsController@edit')->name('hotels_edit')->middleware('auth');
Route::put('/hotels/{hotel}','HotelsController@update')->name('hotels_update')->middleware('auth');
Route::delete('/hotels/{hotel}','HotelsController@destroy')->name('hotels_destroy')->middleware('auth');

/*==============================================*/
/* Zones Routes
/*==============================================*/
Route::get('/zones/select/company','ZonesController@selectCompany')->name('zones_select_company')->middleware('auth');
Route::get('/zones','ZonesController@index')->name('zones_index')->middleware('auth');
Route::get('/zones/company/{company}','ZonesController@indexCompany')->name('zones_index_company')->middleware('auth');
Route::get('/zones/select/create/{company}','ZonesController@selectCreate')->name('zones_select_create')->middleware('auth');
Route::get('/zones/create/','ZonesController@create')->name('zones_create')->middleware('auth');
Route::get('/zones/{zone}','ZonesController@show')->name('zones_show')->middleware('auth');
Route::post('/zones','ZonesController@store')->name('zones_store')->middleware('auth');
Route::get('/zones/{zone}/edit/','ZonesController@edit')->name('zones_edit')->middleware('auth');
Route::put('/zones/{zone}','ZonesController@update')->name('zones_update')->middleware('auth');
Route::delete('/zones/{zone}','ZonesController@destroy')->name('zones_destroy')->middleware('auth');

/*==============================================*/
/* Users Routes
/*==============================================*/
Route::get('/users/reservations','UsersController@usersReservations')->name('user_reservations')->middleware('auth');
Route::get('/users/reservationsByTour','UsersController@usersReservationsByTours')->name('user_reservations_by_tours')->middleware('auth');
Route::get('/users/reservations/{user}','UsersController@userReservations')->name('user_single_reservations')->middleware('auth');
Route::get('/users','UsersController@index')->name('users_index')->middleware('auth');
Route::get('/users/create','UsersController@create')->name('users_create')->middleware('auth');
Route::get('/users/{user}','UsersController@show')->name('users_show')->middleware('auth');
Route::post('/users','UsersController@store')->name('users_store')->middleware('auth');
Route::get('/users/{user}/edit','UsersController@edit')->name('users_edit')->middleware('auth');
Route::put('/users/{user}','UsersController@update')->name('users_update')->middleware('auth');
Route::delete('/users/{user}','UsersController@destroy')->name('users_destroy')->middleware('auth');
Route::get('/users/{user}/add', 'UsersController@addCommission')->name('users_add_commission')->middleware('auth');
Route::post('/users/{user}/store/commission', 'UsersController@storeCommission')->name('users_store_commission')->middleware('auth');
Route::get('/users/edit/commissions/{user}/{commission}', 'UsersController@editCommission')->name('users_edit_commission')->middleware('auth');
Route::put('/users/commission/update/{commission}', 'UsersController@updateCommission')->name('users_update_commission')->middleware('auth');

/*==============================================*/
/* Departures Routes
/*==============================================*/
//Route::get('/departures', 'DepartureController@index')->name('departures_index')->middleware('auth');
Route::get('/departure/create/{tour}', 'DepartureController@create')->name('departures_create')->middleware('auth');
Route::get('/departure/show/{departure}', 'DepartureController@show')->name('departures_show')->middleware('auth');
Route::post('/departures', 'DepartureController@store')->name('departures_store')->middleware('auth');
Route::get('/departure/{departure}/edit', 'DepartureController@edit')->name('departures_edit')->middleware('auth');
Route::put('/departures/{departure}', 'DepartureController@update')->name('departures_update')->middleware('auth');
Route::get('/departure/cancel/{departure}', 'DepartureController@cancel')->name('departures_cancel')->middleware('auth');
Route::get('/departure/active/{departure}', 'DepartureController@activate')->name('departures_activate')->middleware('auth');
Route::delete('/departure/{departure}', 'DepartureController@destroy')->name('departures_destroy')->middleware('auth');
/*==============================================*/
/* Search Routes
/*==============================================*/
Route::get('/search', 'SearchController@search')->name('search_normal')->middleware('auth');
Route::post('/search', 'SearchController@makeSearch')->name('search_make')->middleware('auth');
Route::post('/search/approve', 'SearchController@makeSearchApprove')->name('search_approve_result')->middleware('auth');
Route::get('/search/approve', 'SearchController@searchApprove')->name('search_approve_make')->middleware('auth');


/*==============================================*/
/* Authentication Routes
/* and Index Views
/*==============================================*/
Auth::routes();

Route::get('/', 'HomeController@index')->name('root_page');
Route::get('/home', 'HomeController@index')->name('home');

/*==============================================*/
/* PDF's Routes
/*
/*==============================================*/
Route::get('/printable/zones', 'ToursPDFController@printZones')->name('printable_zones')->middleware('auth');
Route::get('/printable/tours', 'ToursPDFController@printTours')->name('printable_tours')->middleware('auth');
Route::get('/printable/departures', 'ToursPDFController@printDepartures')->name('printable_departures')->middleware('auth');
Route::get('/printable/hotels/departures', 'ToursPDFController@printHotelsDepartures')->name('printable_hotels_departures')->middleware('auth');
Route::get('/printable/hotels/tours', 'ToursPDFController@printHotelsTours')->name('printable_hotels_tours')->middleware('auth');
Route::get('/printable/reservation/{reservation}', 'ToursPDFController@printReservation')->name('printable_reservation')->middleware('auth');

/*==============================================*/
/* Sales
/*
/*==============================================*/
Route::get('/sales', 'SalesController@index')->name('sales_index')->middleware('auth');
Route::get('/sales/users', 'SalesController@users')->name('sales_users')->middleware('auth');
Route::get('/sales/hotels', 'SalesController@hotels')->name('sales_hotels')->middleware('auth');
Route::get('/sales/dates', 'SalesController@dates')->name('sales_dates')->middleware('auth');
Route::get('/sales/confirmed', 'SalesController@confirmed')->name('sales_confirmed')->middleware('auth');
Route::get('/sales/day', 'ToursPDFController@printSalesDay')->name('sales_today')->middleware('auth');
Route::get('/sales/report/day', 'ToursPDFController@showSalesDay')->name('show_sales_today')->middleware('auth');

Route::get('/testPDF2', 'ToursPDFController@testPDF')->name('testPDF2')->middleware('auth');
Route::get('/testPDF', function () {

    // $pdf = resolve('dompdf.wrapper');

    $pdf = PDF::loadHTML('<h1>TEST</h1>');

    // $var = "Esto es una variable externa";
    //
    // $pdf = PDF::loadView('welcome' , [
    //     'var' => $var
    // ]);

    return $pdf->stream();

    // return view('welcome');
})->name('print')->middleware('auth');


Route::get('/orders', 'TotalPassController@orders')->name('orders_total_pass');
Route::get('/order', 'TotalPassController@order')->name('order_total_pass');
Route::get('/order_search', 'TotalPassController@search')->name('order_search_total_pass');

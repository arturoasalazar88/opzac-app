# Routes & API Documentation

## Route Organization
All routes defined in `operadora/routes/web.php`. No REST API currently (api.php only has default Laravel user endpoint).

## Authentication Routes
```
Auth::routes()  → Laravel default auth routes
GET  /           → HomeController@index (home)
GET  /home       → HomeController@index
```

## Reservations Routes
```
POST   /reservations                              → ReservationsController@store (auth)
GET    /reservations                              → ReservationsController@index (auth)
GET    /companies/reservations                    → ReservationsController@indexCompanies (auth)
GET    /reservations/company/{company}            → ReservationsController@indexCompany (auth)
GET    /reservations/create                       → ReservationsController@create (auth)
GET    /reservations/company/{company}/create     → ReservationsController@createCompany (auth)
GET    /reservations/{reservation}                → ReservationsController@show (auth)
GET    /reservations/edit/{reservation}           → ReservationsController@edit (auth)
PUT    /reservations/{reservation}                → ReservationsController@update (auth)
POST   /reservations/select/seat                  → ReservationsController@selectSeat (auth)
POST   /reservations/store/seats                  → ReservationsController@storeWithSeats (auth)
PUT    /reservation/confirm/{reservation}         → ReservationsController@confirm (auth)
GET    /reservation/confirm/{reservation}         → ReservationsController@showConfirm (auth)
GET    /reservation/cancel/{reservation}          → ReservationsController@cancel (auth)
```

## Company Reservations Routes (Fast Create)
```
GET    /fast/menu                                 → CompanyReservationsController@fastMenu
POST   /fast/menu                                 → CompanyReservationsController@fastMenuSearch
GET    /fast/create                               → CompanyReservationsController@fastCreate
GET    /company/select/view                       → CompanyReservationsController@selectCompanyView (auth)
GET    /company/select/create                     → CompanyReservationsController@selectCompanyCreate (auth)
GET    /company/{company}/select/tour             → CompanyReservationsController@selectCompanyTour (auth)
GET    /company/create/tour/{tour}                → CompanyReservationsController@showCreateReservationTour (auth)
GET    /company/create/tour                       → CompanyReservationsController@showCreateReservation (auth)
```

## Tours Routes
```
GET    /tours                                     → ToursController@index (auth)
GET    /tours/company/{company}                   → ToursController@showToursCompany (auth)
GET    /tours/create                              → ToursController@create (auth)
GET    /tours/{tour}                              → ToursController@show (auth)
GET    /tour/show/departures                      → ToursController@getTourDepartures (auth)
GET    /tour/show/{tour}                          → ToursController@getTour (auth)
POST   /tours                                     → ToursController@store (auth)
GET    /tours/{tour}/edit                         → ToursController@edit (auth)
PUT    /tours/{tour}                              → ToursController@update (auth)
DELETE /tours/{tour}                              → ToursController@destroy (auth)
POST   /tours/prices                              → ToursController@getPrices
GET    /tours/{tour}/departures                   → ToursController@showDepartures (auth)
```

## Tour Views Routes (Pickups)
```
GET    /pickup/types                              → ToursViewsController@showPickupTypes (auth)
GET    /pickup/zone/company/select                → ToursViewsController@selectCompanyBeforeZone (auth)
GET    /pickup/horario/company/select             → ToursViewsController@selectCompanyBeforeHour (auth)
GET    /pickup/hotel/company/select               → ToursViewsController@selectCompanyBeforeHotel (auth)
GET    /pickup/tours/company/select               → ToursViewsController@selectCompanyBeforeTour (auth)
GET    /pickup/zone/selected/{company}            → ToursViewsController@ZonaSelect (auth)
POST   /pickup/zone/result                        → ToursViewsController@ZonesPickupOutput (auth)
GET    /pickup/hour/selected/{company}            → ToursViewsController@hourSelect (auth)
POST   /pickup/hour/result                        → ToursViewsController@hoursPickupOutput (auth)
GET    /pickup/hotel/selected/{company}           → ToursViewsController@hotelSelect (auth)
POST   /pickup/hotel/result/horarios              → ToursViewsController@hotelsPickupOutputHorario (auth)
POST   /pickup/hotel/result/tours                 → ToursViewsController@hotelsPickupOutputTours (auth)
GET    /pickup/tour/selected/{company}            → ToursViewsController@tourSelect (auth)
POST   /pickup/tour/result                        → ToursViewsController@toursSelectOutput (auth)
POST   /show/single/{departure}/date              → ToursViewsController@singleTourDate (auth)
GET    /show/single/{departure}/date              → ToursViewsController@singleTourDate (auth)
GET    /show/single/departure                     → ToursViewsController@singleTourDateGET (auth)
```

## Departures Routes
```
GET    /departure/create/{tour}                   → DepartureController@create (auth)
GET    /departure/show/{departure}                → DepartureController@show (auth)
POST   /departures                                → DepartureController@store (auth)
GET    /departure/{departure}/edit                → DepartureController@edit (auth)
PUT    /departures/{departure}                    → DepartureController@update (auth)
GET    /departure/cancel/{departure}              → DepartureController@cancel (auth)
GET    /departure/active/{departure}              → DepartureController@activate (auth)
DELETE /departure/{departure}                     → DepartureController@destroy (auth)
```

## Hotels Routes
```
GET    /hotels                                    → HotelsController@index (auth)
GET    /hotels/create                             → HotelsController@create (auth)
GET    /hotels/{hotel}                            → HotelsController@show (auth)
POST   /hotels                                    → HotelsController@store (auth)
GET    /hotels/{hotel}/edit                       → HotelsController@edit (auth)
PUT    /hotels/{hotel}                            → HotelsController@update (auth)
DELETE /hotels/{hotel}                            → HotelsController@destroy (auth)
```

## Zones Routes
```
GET    /zones/select/company                      → ZonesController@selectCompany (auth)
GET    /zones                                     → ZonesController@index (auth)
GET    /zones/company/{company}                   → ZonesController@indexCompany (auth)
GET    /zones/select/create/{company}             → ZonesController@selectCreate (auth)
GET    /zones/create                              → ZonesController@create (auth)
GET    /zones/{zone}                              → ZonesController@show (auth)
POST   /zones                                     → ZonesController@store (auth)
GET    /zones/{zone}/edit                         → ZonesController@edit (auth)
PUT    /zones/{zone}                              → ZonesController@update (auth)
DELETE /zones/{zone}                              → ZonesController@destroy (auth)
```

## Users Routes
```
GET    /users/reservations                        → UsersController@usersReservations (auth)
GET    /users/reservationsByTour                  → UsersController@usersReservationsByTours (auth)
GET    /users/reservations/{user}                 → UsersController@userReservations (auth)
GET    /users                                     → UsersController@index (auth)
GET    /users/create                              → UsersController@create (auth)
GET    /users/{user}                              → UsersController@show (auth)
POST   /users                                     → UsersController@store (auth)
GET    /users/{user}/edit                         → UsersController@edit (auth)
PUT    /users/{user}                              → UsersController@update (auth)
DELETE /users/{user}                              → UsersController@destroy (auth)
GET    /users/{user}/add                          → UsersController@addCommission (auth)
POST   /users/{user}/store/commission             → UsersController@storeCommission (auth)
GET    /users/edit/commissions/{user}/{commission}→ UsersController@editCommission (auth)
PUT    /users/commission/update/{commission}      → UsersController@updateCommission (auth)
```

## Search Routes
```
GET    /search                                    → SearchController@search (auth)
POST   /search                                    → SearchController@makeSearch (auth)
POST   /search/approve                            → SearchController@makeSearchApprove (auth)
GET    /search/approve                            → SearchController@searchApprove (auth)
```

## Sales Routes
```
GET    /sales                                     → SalesController@index (auth)
GET    /sales/users                               → SalesController@users (auth)
GET    /sales/hotels                              → SalesController@hotels (auth)
GET    /sales/dates                               → SalesController@dates (auth)
GET    /sales/confirmed                           → SalesController@confirmed (auth)
GET    /sales/day                                 → ToursPDFController@printSalesDay (auth)
GET    /sales/report/day                          → ToursPDFController@showSalesDay (auth)
```

## PDF Routes
```
GET    /printable/zones                           → ToursPDFController@printZones (auth)
GET    /printable/tours                           → ToursPDFController@printTours (auth)
GET    /printable/departures                      → ToursPDFController@printDepartures (auth)
GET    /printable/hotels/departures               → ToursPDFController@printHotelsDepartures (auth)
GET    /printable/hotels/tours                    → ToursPDFController@printHotelsTours (auth)
GET    /printable/reservation/{reservation}       → ToursPDFController@printReservation (auth)
GET    /pdf/tour/result                           → ToursPDFController@printTours2 (auth)
```

## Logs Routes
```
ANY    /logs                                      → LogsController@index (auth)
```

## External Integration Routes
```
GET    /orders                                    → TotalPassController@orders
GET    /order                                     → TotalPassController@order
GET    /order_search                              → TotalPassController@search
```

## Projects Routes (Secondary Feature)
```
GET    /projects/create                           → ProjectsController@create
GET    /projects                                  → ProjectsController@index
GET    /projects/{project}                        → ProjectsController@show
GET    /projects/{project}/edit                   → ProjectsController@edit
POST   /projects                                  → ProjectsController@store
PATCH  /projects/{project}                        → ProjectsController@update
DELETE /projects/{project}                        → ProjectsController@destroy
PATCH  /tasks/{task}                              → ProjectTasksController@update
POST   /projects/{project}/task                   → ProjectTasksController@store
```

## JSON Endpoints (AJAX)
```
GET    /tour/show/departures?tour_id={id}         → Returns departures for tour
GET    /tour/show/{tour}                          → Returns tour with departures
POST   /tours/prices                              → Returns tour pricing
```

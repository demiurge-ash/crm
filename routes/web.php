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

Route::middleware('auth', 'worker', 'active')->group(function () {

    Route::get('/', 'HomeController@index')->name('home');

    Route::get('order/show/{id}', 'OrderController@show')->name('order-show');

    Route::post('designer/file', 'VisualOrderController@designerFile');

    Route::get('orders', 'OrderController@list')->name('orders');
    Route::post('orders/ajax', 'OrderController@ajax');
    Route::post('orders', 'OrderController@list');

    Route::get('/chat/messages', 'MessageController@get');
    Route::post('/chat/messages', 'MessageController@send');

    Route::middleware('manager')->group(function () {
        Route::get('order', 'OrderController@index')->name('order');
        Route::get('order/{view}', 'OrderController@index')->name('order-view');
        Route::get('order/edit/{id}', 'OrderController@edit')->name('order-edit');

        Route::get('buildings', 'BuildingController@index');
        Route::get('buildings/{id}', 'BuildingController@pavilions');

        Route::post('order/visual', 'VisualOrderController@store');
        Route::post('order/radio', 'RadioOrderController@store');
        Route::post('order/photo', 'PhotoOrderController@store');
        Route::post('order/promo', 'PromoOrderController@store');
    });

    Route::middleware('boss')->group(function () {

        Route::get('order/delete/{id}', 'OrderController@delete')->name('order-delete');

        Route::get('clients', 'ClientController@index')->name('clients');
        Route::get('clients/{id}', 'ClientController@show');
        Route::post('clients/ajax', 'ClientController@ajax');

        Route::get('tracking/absent', 'TimeController@index')->name('events');
        Route::get('tracking/absent/{year}/{month}', 'TimeController@show')->name('events-selected');
        Route::post('tracking/absent/store', 'TimeController@store')->name('event-create');

        Route::get('tracking/worktime', 'WorkTimeController@index')->name('worktime');
        Route::post('tracking/worktime', 'WorkTimeController@selectDays');
        Route::post('tracking/worktime/store', 'WorkTimeController@store')->name('worktime-store');
        Route::get('tracking/worktime/select-week', 'WorkTimeController@select');
        Route::post('tracking/worktime/update-week', 'WorkTimeController@showWeek');
        Route::post('tracking/worktime/upload', 'WorkTimeController@upload');
        Route::get('tracking/worktime/{beginDate}/{endDate}', 'WorkTimeController@show');
        Route::get('tracking/worktime/{beginDate}/{endDate}/{user}', 'WorkTimeController@showUser');

        Route::get('tracking/schedule', 'TimeScheduleController@index')->name('timeschedule');
        Route::post('tracking/schedule/ajax', 'TimeScheduleController@ajax');
        Route::get('tracking/schedule/edit/{id}', 'TimeScheduleController@edit');
        Route::get('tracking/schedule/create', 'TimeScheduleController@create')->name('timeschedule-create');
        Route::post('tracking/schedule/store', 'TimeScheduleController@store')->name('timeschedule-store');
        Route::post('tracking/schedule/update', 'TimeScheduleController@update')->name('timeschedule-update');
    });

});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();
Route::get('register', 'HomeController@index');


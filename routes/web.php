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

Route::get('/', 'HomeController@home');

Auth::routes();

Route::get('tickets/new', 'TicketsController@create');
Route::post('tickets/new', 'TicketsController@store');
Route::get('tickets', 'TicketsController@userTickets')->middleware('notadmin');
Route::get('tickets/{ticket_id}', 'TicketsController@show');
Route::post('comment', 'CommentsController@postComment');

Route::group(['prefix' => 'admin', 'middleware' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/', 'DashboardController@index');
    Route::get('tickets/{status?}', 'TicketsController@tickets');
    Route::get('categories', 'CategoryController@show');
    Route::post('categories', 'CategoryController@add');
    Route::get('administrators', 'AdminsController@show');
    Route::post('administrators', 'AdminsController@add');
    Route::delete('administrators/{user_id}', 'AdminsController@delete');
    Route::delete('category/{category_id}', 'CategoryController@delete');
    Route::post('change_status/{ticket_id}', 'TicketsController@changeStatus');
});

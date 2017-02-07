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
Route::get('home', 'HomeController@dashboard')->middleware('auth');

Auth::routes();

Route::get('new_ticket', 'TicketsController@create');
Route::post('new_ticket', 'TicketsController@store');
Route::get('tickets', 'TicketsController@userTickets')->middleware('notadmin');
Route::get('tickets/{ticket_id}', 'TicketsController@show');
Route::post('comment', 'CommentsController@postComment');

Route::group(['prefix' => 'admin', 'middleware' => 'admin', 'namespace' => 'Admin'], function() {
    Route::get('/', 'TicketsController@home');
    Route::get('tickets', 'TicketsController@tickets');
    Route::get('categories', 'CategoryController@show');
    Route::post('categories', 'CategoryController@add');
    Route::delete('category/{category_id}', 'CategoryController@delete');
    Route::post('change_status/{ticket_id}', 'TicketsController@changeStatus');
});

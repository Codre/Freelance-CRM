<?php

use Illuminate\Support\Facades\Auth;
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

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'Overview@index')->name('overview');
    Route::resources([
        'staffs'   => 'Staffs\Staffs',
        'clients'  => 'Clients\Clients'
    ]);
    Route::resource('projects.members', 'Projects\ProjectMembers')->except(['show']);
    Route::resource('projects', 'Projects\Projects')->except(['create']);
});

Auth::routes(['register' => false]);

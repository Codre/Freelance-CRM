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
        'staffs'  => 'Staffs\Staffs',
        'clients' => 'Clients\Clients',
    ]);
    Route::resource('projects.members', 'Projects\ProjectMembers')->except(['show']);
    Route::resource('projects.tasks', 'Projects\ProjectTasks')->except(['index']);
    Route::resource('projects', 'Projects\Projects')->except(['create', 'edit', 'update']);
    Route::resource('projects.tasks.comments', 'Projects\TaskComment')->only(['store']);
    Route::resource('projects.tasks.files', 'Projects\TaskFiles')->only(['show', 'store', 'destroy']);

    Route::resource('projects.finances', 'Projects\ProjectFinanceController')
        ->only(['create', 'store']);
    Route::resource('projects.tasks.finances', 'Projects\ProjectFinanceController')
        ->only(['create', 'store']);

    Route::post('projects/{project}}/tasks/{task}/run', 'Projects\ProjectTasks@run')
        ->name('projects.tasks.run');
    Route::post('projects/{project}}/tasks/{task}/ready', 'Projects\ProjectTasks@ready')
        ->name('projects.tasks.ready');
    Route::post('projects/{project}}/tasks/{task}/finishing', 'Projects\ProjectTasks@finishing')
        ->name('projects.tasks.finishing');


    /** Ajax Routes */
    Route::prefix('ajax')->name('ajax.')->group(function () {
        Route::resource('projects', 'Ajax\Projects\Project')->only('update', 'edit');
        Route::resource('projects.tasks.times', 'Ajax\Projects\TaskTimes')->only(['update']);
    });
});

Auth::routes(['register' => false]);

Route::get('client/invite/', 'Clients\Invite@index')->name('client.invite');
Route::post('client/invite/', 'Clients\Invite@store')->name('client.invite.store');
Route::get('info/offer/', 'Info@offer')->name('info.offer');
Route::get('info/rules/', 'Info@rules')->name('info.rules');
Route::get('info/privacy/', 'Info@privacy')->name('info.privacy');

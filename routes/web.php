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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'ProjectController@index')->name('home');

    Route::resource('projects', 'ProjectController');
    Route::get('/export-excel', 'ProjectController@exportExcel')->name('export.project.excel');
    Route::get('/export-csv', 'ProjectController@exportCsv')->name('export.project.csv');
    Route::get('/import', 'ProjectController@importForm')->name('import.project.form');
    Route::post('/import-file', 'ProjectController@import')->name('import.project.file');

    Route::post('/search-type', 'ProjectController@searchProjectInType')->name('search.project.type');
    Route::post('/search-title', 'ProjectController@searchProjectInTitle')->name('search.project.title');
    Route::post('/search-organization', 'ProjectController@searchProjectInOrganization')->name('search.project.organization');

});


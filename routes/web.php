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

Route::get('/', function () {
    return redirect('login');
});

// Route::get('bcrypt', function () {
//     return bcrypt('ppt1un3s4');
// });

Auth::routes();

Route::group(['middleware' => 'role:admin_jurusan'], function () {
  Route::get('/home', 'HomeController@index')->name('home');

  Route::get('jurusan', 'OutputController@jurusan')->name('jurusan');
  Route::resource('output', 'OutputController');
  Route::get('detil_output/{rba}', 'OutputController@detil')->name('detil_output');

  Route::get('monitoring', 'MonitoringController@index')->name('monitoring.index');

  Route::get('eksport', 'OutputController@download1')->name('download1');
});

Route::group(['middleware' => 'role:admin'], function () {
  Route::resource('master_rba', 'MasterRbaController');
  Route::post('uploadexcel', ['as' => 'uploadexcel', 'uses' => 'MasterRbaController@uploadexcel']);

  Route::resource('user', 'UsersController');
});

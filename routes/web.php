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
	return view('auth.login');
});


Route::get('login', function () {
	return view('auth.login');
});

Route::get("lang/{locale}", function ($locale) {
	Session::put("locale", $locale);
	return redirect()->back();
})->name("lang");

Auth::routes();


Route::group(['middleware' => 'auth'], function () {
	// password reset
	Route::get('reset', 'UserController@formPasswordReset')->name('passwordReset');
	Route::put('passwordUpdate', 'UserController@passwordUpdate')->name('passwordUpdate');
	// users, roles, presmissions
	Route::resource('user', 'UserController');
	Route::resource('rol', 'RolController');
	Route::resource('permission', 'PermissionController');
	Route::resource('report', 'ReportController')->middleware('has.role:super');
	Route::resource('turn', 'TurnController')->middleware('has.role:super');
	Route::resource('typeTurn', 'TypeTurnController')->middleware('has.role:super');
	Route::resource('planificador', 'PlannerController')->middleware('has.role:super');
	// home
	Route::get('/home', 'HomeController@index')->name('home');

	Route::post('loginUser', 'HomeController@indexByUser')->name('loginUser');
	// modules

	Route::resource('grupo','GrupoController');
	Route::resource('posicion','PositionController');

	Route::get('grupo/edit/{id}', 'GrupoController@edit')->name('grupo.edit');
	Route::get('grupo/delete/{id}', 'GrupoController@destroy')->name('grupo.delete');
	Route::get('searchJefes/{id}', 'GrupoController@searchJefes')->name('searchJefes');
	Route::get('searchUsers/{id}', 'GrupoController@searchUsers')->name('searchUsers');
	Route::get('getAllGroups', 'GrupoController@getAllGroups')->name('getAllGroups');
	Route::get('getAllJefes', 'GrupoController@getAllJefes')->name('getAllJefes');

	Route::post('user/update/{id}', 'UserController@update')->name('user.update');
	Route::post('asistencia/store', 'AsistenciaController@store')->name('asistencia.store');
	Route::post('asistencia/update/{id}', 'AsistenciaController@update')->name('asistencia.update');
    Route::get('asistencia/show/{id}', 'AsistenciaController@show')->name('asistencia.show');

	Route::get('planificador/create/{id}', 'PlannerController@create')->name('planificador.create');
	Route::post('planificador/update/{id}', 'PlannerController@update')->name('planificador.update');
	Route::get('assignment', 'PlannerController@assignment')->name('planificador.assignment');
	Route::post('assignment/store', 'PlannerController@assignmentStore')->name('assignment.store');
    Route::get('assignment/edit/{id}', 'PlannerController@assignmentEdit')->name('assignment.edit');
    Route::post('assignment/update/{id}', 'PlannerController@assignmentUpdate')->name('assignment.update');
    Route::delete('assignment/destroy/{id}', 'PlannerController@assignmentDestroy')->name('assignment.destroy');


});


Route::match(['get', 'post'], '/botman', 'BotManController@handle');

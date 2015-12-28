<?php

use Illuminate\Foundation\Inspiring;
use App\Project;
use App\Client;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome', ['quote' => Inspiring::quote()]);
});

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');


Route::get('dashboard', ['middleware' => 'auth', function()
{
    return view('approval.dashboard');
}]);


Route::resource('clients', 'ClientController');

Route::get('projects/{id}', function($id){
        $project = Project::find($id);
		return view('approval.projectDetails', [
          'project' => $project
        ]);
});


Route::get('projects', function(){
		return view('approval.projects', [
			'projects' => Project::all(),
			'clients'  => Client::all()
      ]);
});

Route::get('dropzone', ['middleware' => 'auth', function()
{
    return view('dropzone');
}]);

Route::get('dropzone', 'UploadController@index');

Route::post('dropzone/uploadFiles', 'UploadController@uploadFiles');


Route::group(['prefix' => 'admin'], function()
{
    Route::get('/', ['middleware' => 'admin', function(){
        dd('Admin Index Page');
    }]);
});

Route::group(['prefix' => 'api'], function()
{
  Route::post('projects/{projectID}/assets/{id}/notes', 'NoteController@store');
	Route::get('projects/{projectID}/assets/{id}/notes', 'NoteController@show');
  Route::get('projects/{projectID}/assets/{id}', 'AssetController@show');
	Route::resource('projects/{projectID}/assets', 'AssetController');
	Route::resource('projects', 'ProjectController');

});

Route::get('/users', function(){
    return (new App\User)->withRoles();
});

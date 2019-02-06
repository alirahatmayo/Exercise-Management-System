<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|


Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

	Route::get('/', function () {
    return view('welcome');
});

    Route::post('/register', [
    	'uses'=>'UserController@PostRegister',
    	'as'=>'register'
    	]);


    Route::get('/admin', [
  'uses' => 'UserController@getAdmin',
  'as' => 'admin'
   ]);

    Route::get('/coach', [
  'uses' => 'CoachController@getCoach',
  'as' => 'coach'
   ]);

   Route::get('/player', [
  'uses' => 'PlayerController@getPlayer',
  'as' => 'player'
   ]);

   Route::get('/management', [
  'uses' => 'UserController@getManagement',
  'as' => 'management'
   ]);





// -----------These all are the routes of Admin.blade.php----------------------//


Route::get('Admin/addNewUser', [
//  'middleware'=>'role.restrict',
 // 'roles'=>['admin'],
  'uses' => 'AdminController@getAddNewUser',
  'as' => 'addNewUser'
   ]);
Route::post('/addNewUser', [
  'uses' => 'AdminController@PostAddNewUser',
  'as' => 'NewUser'
   ]);

Route::get('/editUser', [
  'uses' => 'AdminController@getEditUser',
  'as' => 'editUser'
   ]);
Route::get('/editUserManagement', [
  'uses' => 'AdminController@getEditUserM',
  'as' => 'editUserM'
   ]);
Route::get('/editUserPlayer', [
  'uses' => 'AdminController@getEditUserP',
  'as' => 'editUserP'
   ]);
Route::get('/editUserCoach', [
  'uses' => 'AdminController@getEditUserC',
  'as' => 'editUserC'
   ]);

Route::get('/editUserAdmin', [
  'uses' => 'AdminController@getEditUserA',
  'as' => 'editUserA'
   ]);
Route::get('/editPopUp', [
  'uses' => 'AdminController@getEditPopUp',
  'as' => 'editPopUp'
   ]);

Route::get('/DeleteUser/{id}', [
  'uses' => 'AdminController@delete',
  'as' => 'delete'
   ]);

Route::get('/EditUser/{id}', [
  'uses' => 'AdminController@edit',
  'as' => 'edit'
   ]);

Route::post('/Update', [
  'uses' => 'AdminController@update',
  'as' => 'update'
   ]);

Route::get('/Admin/stats', [
  'uses' => 'AdminController@getChart',
  'as' => 'getChart'
   ]);


   //--------------------------End Admin Routes---------------------------------//





//------------------Coach Routes-------------------------------//




   Route::get('Coach/AllPlayers', [
  'middleware'=>'role.restrict',
  'roles'=>['coach'],
  'uses' => 'CoachController@getAllPlayers',
  'as' => 'PlayerTable'
   ]);

      Route::get('Coach/editProfile/player-id={player_id}', [
 // 'middleware'=>'role.restrict',
 // 'roles'=>['coach'],
  'uses' => 'CoachController@getEditExercise',
  'as' => 'editExercise'

   ]);

  Route::get('Coach/addingExercise/for{player_id}', [
 // 'middleware'=>'role.restrict',
 // 'roles'=>['coach'],
  'uses' => 'CoachController@getAddExercise',
  'as' => 'addExercise'

  ]);

  Route::post('Coach/profile', [
 // 'middleware'=>'role.restrict',
 // 'roles'=>['coach'],
  'uses' => 'CoachController@postExercise',
  'as' => 'postExercise'

  ]);
    Route::get('Coach/addingExercise/Compare-player-{player_id}-with', [
 // 'middleware'=>'role.restrict',
 // 'roles'=>['coach'],
  'uses' => 'CoachController@comparePlayer',
  'as' => 'comparePlayer'

  ]);

   Route::post('Coach/Compare-{player_id}-with-another-player', [
 // 'middleware'=>'role.restrict',
 // 'roles'=>['coach'],
  'uses' => 'CoachController@compareResult',
  'as' => 'compareResult'

  ]);


//-----------------End Coach Routes----------------------//


//---------------Post Comment------------------------//
   Route::post('', [
 // 'middleware'=>'role.restrict',
 // 'roles'=>['coach'],
  'uses' => 'CommentController@postComment',
  'as' => 'postComment'

  ]);




    Route::get('Management/dashboard', [
 // 'middleware'=>'role.restrict',
 // 'roles'=>['coach'],
  'uses' => 'ManagementController@dashboard',
  'as' => 'managementDashboard'

  ]);


});
    
Route::group(['middleware' => 'web'], function() {
    Route::auth();

    Route::get('/home', 'HomeController@index');
});

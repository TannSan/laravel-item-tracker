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
use Illuminate\Http\Request;

/*
// Debug SQL
\Event::listen('Illuminate\Database\Events\QueryExecuted', function( $query ) {
    echo'<pre>';
    var_dump($query->sql);
    var_dump($query->bindings);
    var_dump($query->time);
    echo'</pre>';
});
*/

Route::get('/', function () {
    return redirect('/parse');
});

Route::group(['middleware' => ['role:Admin|Manager']], function () {
   Route::get('/start', function () {
       $parses = \App\Parse::all()->sort(
       function ($a, $b) {
           // sort by column1 first, then 2, and so on
           return strcmp($a->member_name, $b->member_name)
               ?: strcmp($a->advanced_class, $b->advanced_class)
               ?: strcmp($a->specialization, $b->specialization)
               ?: strcmp($a->parse_dps, $b->parse_dps);
       });

      if (session('deleted_count') !== null)
         {
            if(session('deleted_count') == 0)
               session(['deleted_count' => 1]);
            else
               {
                  session()->forget('deleted_count');
                  session()->forget('success');
               }
         }

       return view('start', compact("parses"));
   });

   Route::post('/start', function (Request $request) {
       switch($request->input('startbutton'))
         {
            case 'create':
               session()->forget('parse_id');
               break;
            case 'create_from_previous':
                $data = $request->validate([
                    'create_from_previous_parse_id' => 'required|integer|min:1'
                ]);
               session(['parse_id' => $request->input('create_from_previous_parse_id')]);
               break;
            case 'edit':
                $data = $request->validate([
                    'previous_parse_id' => 'required|integer|min:1'
                ]);
               $parse_id = $request->input('previous_parse_id');
               session()->forget('parse_id');
               return redirect('/parse/'.$parse_id.'/edit');
               break;
            case 'delete':
               session()->forget('parse_id');
               return redirect('/parse/'.$request->input('delete_parse_id'));
               break;
         }

      return redirect('/parse/create');
   });
});
/*
Route::group(['middleware' => 'cachepage'], function ()
   {
      Route::get('parse/iframe-sideblock', 'ParseController@iframesideblock');
      Route::get('parse/iframe-scoreboards', 'ParseController@iframeboards');
   });
  */
      Route::get('parse/iframe-sideblock', 'ParseController@iframesideblock');
      Route::get('parse/iframe-scoreboards', 'ParseController@iframeboards');
Route::resource('parse', 'ParseController');

// Manually added the Auth routes so could disable guest registration...
// Copied lines from Auth function in \vendor\laravel\framework\src\Illuminate\Routing
// Auth::routes();

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
// This secondary logout is to catch naughty people that try to use the /logout link directly
// If this was not here then they would see the Laravel "Not Allowed" error page
// The proper Laravel auth logout is handled via POST since 5.4 (handled by the route before these comments)
Route::get('/logout', 'Auth\LoginController@logout')->name('logout' );

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::resource('users', 'UserController');
Route::resource('roles', 'RoleController');
Route::resource('permissions', 'PermissionController');
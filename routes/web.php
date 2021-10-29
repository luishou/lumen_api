<?php

/*
 * This file is part of the Jiannei/lumen-api-starter.
 *
 * (c) Jiannei <longjian.huang@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Jiannei\Response\Laravel\Support\Facades\Response;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

Route::get('/', function () {
    return app()->version();
});

Route::get('author', function () {
    $response = Http::withOptions(['timeout' => 3])->get('https://api.github.com/users/Jiannei');
    $response->throw();

    return Response::success($response->json());
});

// 测试路由
Route::group(['prefix' => 'test'], function () {
    Route::get('configurations', 'ExampleController@configurations');
    Route::get('logs', ['uses' => 'ExampleController@logs', 'middleware' => 'throttle:5,1']);
    Route::put('roles', 'ExampleController@syncRoles');
    Route::put('permissions', 'ExampleController@syncPermissions');

    Route::get('posts', 'PostsController@index');
});

// 用户管理
Route::post('users', 'UsersController@store');
Route::get('users/{id}', 'UsersController@show');
Route::get('users', 'UsersController@index');
Route::get('users/pagination/simple', 'UsersController@simple');
Route::get('users/pagination/cursor', 'UsersController@cursor');

// 授权管理
Route::post('authorization', 'AuthorizationController@store');
Route::delete('authorization', 'AuthorizationController@destroy');
Route::put('authorization', 'AuthorizationController@update');
Route::get('authorization', 'AuthorizationController@show');

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('throttle:10,1,test000')->get('/throttled-10-requests-per-1-min-test000', function () {
  return [
    'code' => 200,
    'message' => "OK"
  ];
});

Route::middleware('custom.throttle:10,10')->get('/throttled-10-requests-per-10-seconds', function (Request $request) {
  return [
    'code' => 200,
    'message' => "OK",
  ];
});

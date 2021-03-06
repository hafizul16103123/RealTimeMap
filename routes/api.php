<?php

use Illuminate\Http\Request;
use App\Events\SendLocationEvent;

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
Route::post('/map', function (Request $request) {

    $lat = $request->lat;
    $long = $request->long;
    $position = ['lat' => $lat, 'long' => $long];
    event(new SendLocationEvent($position));
    return response()->json(['status' => 'success', 'data' => $position]);
});

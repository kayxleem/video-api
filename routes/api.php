<?php

use App\Http\Controllers\VideoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/',[VideoController::class,'index']);
Route::post('/',[VideoController::class,'store']);
Route::get('/{id}',[VideoController::class,'show']);
//Route::delete('/{id}',[VideoController::class,'destroy']);
//Route::patch('/{id}',[VideoController::class,'update']);
//Route::put('/{id}',[VideoController::class,'update']);

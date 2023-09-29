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

Route::get('/',[VideoController::class,'index'])->name('get');
Route::post('/',[VideoController::class,'store']);
Route::get('/{id}',[VideoController::class,'show']);
Route::prefix('v1')->group(function(){
    Route::get('/', [VideoController::class,'index'])->name('v1.index');
    Route::post('/', [VideoController::class,'store'])->name('v1.store');
    //Route::post('/auth/user/forgot-password', [ResetPasswordController::class, 'forgotPassword'])->name('user.forgotPassword');
    //Route::post('/organization/staff/signup', [OrganizationController::class, 'createOrganizationUser']);
});


<?php

use App\Http\Controllers\Api\FormsController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([], function () {
    Route::get('form', [FormsController::class, "index"])->name('forms.index');
    Route::post('form', [FormsController::class, "create"])->name('forms.create');
    Route::get('form/{id}', [FormsController::class, "show"])->name('forms.show')->whereNumber('id');
    Route::put('form/{id}', [FormsController::class, "edit"])->name('forms.edit')->whereNumber('id');
    Route::delete('form/{id}', [FormsController::class, "delete"])->name('forms.delete')->whereNumber('id');
});

<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\InspectionOfficerController;
use App\Http\Controllers\VerficationOfficerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HawkerController;

Route::options('{any}', function (Request $request) {
    return response()->json(['status' => 'ok'], 200, [
        'Access-Control-Allow-Origin' => 'https://hawker-licenes.netlify.app',
        'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
        'Access-Control-Allow-Headers' => '*'
    ]);
})->where('any', '.*');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/', UserController::class . '@login');
Route::post('register', UserController::class . '@register');
Route::put('reset-password', UserController::class . '@restPassword');

Route::prefix('hawker')->group(function () {
    Route::get('/{hawkerID}', HawkerController::class . '@checkForLicense');
    Route::get('get-hawker-id/{userID}', HawkerController::class . '@getHawkerID');
    Route::post('submit-application', HawkerController::class . '@submitApplication');
    Route::get('applications-history/{hawkerID}', HawkerController::class . '@trackApplications');
})->name('hawker');

Route::prefix('verfication-officer')->group(function () {
    Route::get('', VerficationOfficerController::class . '@viewApplications');
    Route::get('review-application/{applicationID}', VerficationOfficerController::class . '@reviewApplication');
    Route::put('approve-application/{applicationID}', VerficationOfficerController::class . '@approveApplication');
    Route::put('reject-application/{applicationID}', VerficationOfficerController::class . '@rejectApplication');
    Route::get('download-document/{path}', DocumentController::class . '@downloadDocument');
})->name('verfication-officer');

Route::prefix('inspection-officer')->group(function () {
    Route::get('/{userID}', InspectionOfficerController::class . '@viewApplications');
    Route::post('sechdual-inspection', InspectionOfficerController::class . '@sechdualInspection');
    Route::post('submit-inspection-report', InspectionOfficerController::class . '@submitInspectionReport');
})->name('inspection-officer');

Route::prefix('admin')->group(function () {
    Route::get('', AdminController::class . '@viewUsers');
    Route::post('add-user', UserController::class . '@register');
    Route::delete('remove-user', AdminController::class . '@removeUser');
    Route::get('applications', AdminController::class . '@viewApplications');
    Route::get('download-inspection-report/{applicationID}', AdminController::class . '@getInspectionReport');
    Route::post('issue-licesnse', AdminController::class . '@issueLicesnse');
    Route::put('reject-application', AdminController::class . '@rejectApplication');
});

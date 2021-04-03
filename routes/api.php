<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CameraController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;

use App\Http\Controllers\ApplicationController;

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

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', [LoginController::class, 'logout']);

    Route::get('user', [UserController::class, 'current']);

    Route::patch('settings/profile', [ProfileController::class, 'update']);
    Route::patch('settings/password', [PasswordController::class, 'update']);

    // camera
    Route::get('application/{app_id}/cameras', [CameraController::class, 'index']);
    Route::post('application/{app_id}/camera', [CameraController::class, 'store']);
    Route::put('application/{app_id}/camera/{camera_id}', [CameraController::class, 'update']);
    Route::get('application/{app_id}/camera/{camera_id}', [CameraController::class, 'show']);
    Route::delete('application/{app_id}/camera/{camera_id}', [CameraController::class, 'destroy']);
    Route::get('application/{app_id}/camera/{camera_id}/images', [CameraController::class, 'images']);
    Route::get('application/{app_id}/camera/{camera_id}/images/last', [CameraController::class, 'lastImage']);

    // applications
    Route::get('application', [ApplicationController::class, 'index']);
    Route::post('application', [ApplicationController::class, 'store']);
    Route::get('application/{id}', [ApplicationController::class, 'show']);
    Route::put('application/{id}', [ApplicationController::class, 'update']);
    Route::delete('application/{id}', [ApplicationController::class, 'destroy']);

    // images
    Route::get('application/{app_id}/camera/{camera_id}/images/{image_id}', [ImageController::class, 'show']);
    Route::put('application/{app_id}/camera/{camera_id}/images/{image_id}', [ImageController::class, 'update']);
    Route::delete('application/{app_id}/camera/{camera_id}/images/{image_id}', [ImageController::class, 'destroy']);

    // get image
    Route::get('/images/{folder}/{image}', [ImageController::class, 'getImage']);
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('register', [RegisterController::class, 'register']);

    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('password/reset', [ResetPasswordController::class, 'reset']);

    Route::post('email/verify/{user}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [VerificationController::class, 'resend']);

    Route::post('oauth/{driver}', [OAuthController::class, 'redirect']);
    Route::get('oauth/{driver}/callback', [OAuthController::class, 'handleCallback'])->name('oauth.callback');

    Route::post('application/{app_id}/camera/{camera_id}/images', [ImageController::class, 'store']);

});

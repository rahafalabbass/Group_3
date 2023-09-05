<?php

use App\Http\Controllers\AdvertisementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\collage\collageController;
use App\Http\Controllers\material\materialController;
use App\Http\Controllers\questions\QuestionController;
use App\Http\Controllers\complaint\complaintController;
use App\Http\Controllers\favourite\FavouriteController;
use App\Http\Controllers\profileController;
use App\Models\Advertisement;

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
Route::get('/majorfor',[collageController::class,'majorfor']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/allmajor',[collageController::class,'allmajor']);
Route::post('/register',[AuthController::class,'register'])->name('register');
Route::post('/logout',[AuthController::class,'logout']);
Route::post('/login',[AuthController::class,'login']);

Route::group([
      'middleware' => ['auth:sanctum']
  ],function (){

    Route::post('/update-profile',[profileController::class,'update_profile']);
    Route::get('/materials',[materialController::class,'show'])->middleware('check_collage');
    Route::get('/slide-adv',[AdvertisementController::class,'show']);
    Route::post('/Add-complaint',[complaintController::class,'addComplaint']);
 Route::get('/all-cycles',[QuestionController::class,'all_cycles']);
 Route::get('/all-cycles-questions',[QuestionController::class,'all_cycle_questions']);
 Route::get('/book-questions',[QuestionController::class,'book_questions']);
 Route::get('/collage-cycles',[QuestionController::class,'collage_cycles']);
 Route::get('/bank-questions',[QuestionController::class,'bank_questions']);
 Route::post('/question-corrector',[QuestionController::class,'Question_corrector']);
 Route::post('favourite/',[FavouriteController::class,'add_question']);

  });

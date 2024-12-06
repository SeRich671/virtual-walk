<?php

use App\Http\Controllers\Api\PhotoController;
use Illuminate\Support\Facades\Route;

Route::get('/photos/{photo}', PhotoController::class);

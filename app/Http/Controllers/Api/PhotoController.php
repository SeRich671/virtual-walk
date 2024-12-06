<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\JsonResponse;

class PhotoController extends Controller
{
    public function __invoke(Photo $photo): JsonResponse
    {
        return response()->json($photo->load('movements'));
    }
}

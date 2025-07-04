<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\JsonResponse;

class GenreController extends Controller
{
    public function index(): JsonResponse
    {
        $genres = Genre::active()->orderBy('display_name')->get();
        
        return response()->json([
            'success' => true,
            'data' => $genres
        ]);
    }
}
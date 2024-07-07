<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index(Request $request)
    {
        $language = $request->query('language', 'en');

        $genres = Genre::select('id', DB::raw("`{$language}_name` as name"))->get();
        
        return $genres;
    }
}
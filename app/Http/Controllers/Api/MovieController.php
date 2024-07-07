<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $language = $request->query('language', 'en');

        $movies = Movie::with(['infos' => function ($query) use ($language) {
            $query->where('language', $language)->with('genres');
        }])->get();

        $result = $movies->map(function ($movie) use ($language) {
            $info = $movie->infos->first();

            $genres = $info->genres->map(function ($genre) use ($language) {
                $propertyName = $language.'_name';
                return [
                    'id' => $genre->id,
                    'name' => $genre->$propertyName,
                ];
            });

            return [
                'id' => $movie->id,
                'movie_id' => $info->movie_id,
                'title' => $info->title,
                'overview' => $info->overview,
                'genres' => $genres,
            ];
        });

        return response()->json($result);
    }
}
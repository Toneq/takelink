<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Movie;
use App\Models\MovieInfo;
use App\Models\Serie;
use App\Models\Genre;

class FetchTMDBData extends Command
{
    protected $signature = 'fetch:tmdb';
    protected $description = 'Fetch data from TMDB API and store in database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $client = new Client();
        $apiKey = env('TMDB_API_KEY');
        
        $this->fetchGenres($client, $apiKey);
        $this->fetchMovies($client, $apiKey);
        $this->fetchSeries($client, $apiKey);
    }

    private function fetchGenres($client, $apiKey)
    {
        $languages = ['en', 'pl', 'de'];

        foreach ($languages as $language) {
            $response = $client->get("https://api.themoviedb.org/3/genre/movie/list", [
                'query' => [
                    'api_key' => $apiKey,
                    'language' => $language,
                ],
            ]);
    
            $data = json_decode($response->getBody(), true);
    
            if (isset($data['genres'])) {
                foreach ($data['genres'] as $genre) {
                    $this->createGenres($genre, $language);
                }
            }
        }
    }

    private function fetchMovies($client, $apiKey)
    {
        $languages = ['en', 'pl', 'de'];
        $response = $client->get("https://api.themoviedb.org/3/movie/popular", [
            'query' => [
                'api_key' => $apiKey,
                'language' => 'en',
                'page' => 1,
            ],
        ]);

        $movies = json_decode($response->getBody(), true)['results'];

        foreach (array_slice($movies, 0, 50) as $movieData) {
            $movie = Movie::updateOrCreate(
                ['id' => $movieData['id']],
                ['title' => $movieData['title'], 'overview' => $movieData['overview'], 'language' => 'en', 'genre_id' => $movieData['genre_ids'][0] ?? null]
            );

            foreach ($languages as $language) {
                $response = $client->get("https://api.themoviedb.org/3/movie/{$movieData['id']}", [
                    'query' => [
                        'api_key' => $apiKey,
                        'language' => $language,
                    ],
                ]);

                $movieInfoData = json_decode($response->getBody(), true);
                $movieInfo = MovieInfo::updateOrCreate(
                    ['movie_id' => $movie->id, 'language' => $language],
                    ['title' => $movieInfoData['title'], 'overview' => $movieInfoData['overview']]
                );

                // Zapisywanie powiązań z gatunkami
                $movieInfo->genres()->sync($movieData['genre_ids']);
            }
        }
    }

    private function fetchSeries($client, $apiKey)
    {
        $response = $client->get("https://api.themoviedb.org/3/tv/popular", [
            'query' => [
                'api_key' => $apiKey,
                'language' => 'en',
                'page' => 1,
            ],
        ]);

        $series = json_decode($response->getBody(), true)['results'];

        foreach (array_slice($series, 0, 10) as $serieData) {
            Serie::updateOrCreate(
                ['id' => $serieData['id']],
                ['title' => $serieData['name'], 'overview' => $serieData['overview'], 'language' => 'en']
            );
        }
    }

    private function createGenres($genre, $language){
        if (is_null($language)) {
            return "Nieprawidłowy język: NULL";
        }
        
        $languages = ['en', 'pl', 'de'];
    
        if (!in_array($language, $languages)) {
            return "Błędny język!";
        }
    
        $existingGenre = Genre::where('id', $genre['id'])->first();

        if (!$existingGenre) {
            Genre::create([
                'id' => $genre['id'],
                'pl_name' => $genre['name'],
                'de_name' => $genre['name'],
                'en_name' => $genre['name'],
            ]);
        } else {
            $existingGenre->update([
                $language.'_name' => $genre['name'],
            ]);
            $existingGenre->save();
        }
    }
}

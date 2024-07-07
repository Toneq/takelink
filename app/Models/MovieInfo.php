<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieInfo extends Model
{
    use HasFactory;

    protected $fillable = ['movie_id', 'language', 'title', 'overview'];

    protected $table = 'movies_info';

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'movie_info_genres');
    }
}

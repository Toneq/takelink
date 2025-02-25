<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['id'];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function infos()
    {
        return $this->hasMany(MovieInfo::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'movie_info_genres', 'movie_info_id', 'genre_id', 'id', 'id');
    }
}

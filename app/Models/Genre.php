<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'pl_name', 'de_name', 'en_name'];

    protected $attributes = [
        'pl_name' => '',
        'de_name' => '',
        'en_name' => '',
    ];

    public function movieInfos()
    {
        return $this->belongsToMany(MovieInfo::class, 'movie_info_genres');
    }
}

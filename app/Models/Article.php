<?php

namespace App\Models;

use App\Search\Articles\Searchable;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Searchable;

    protected $casts =[
        'tags' => 'json',
    ];
}

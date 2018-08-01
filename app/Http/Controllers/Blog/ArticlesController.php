<?php

namespace App\Http\Controllers\Blog;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticlesController extends Controller
{
    public function index()
    {
      $articles = Article::paginate(10);
      $articles->total();
      return view('articles.index', compact('articles'));
    }
}

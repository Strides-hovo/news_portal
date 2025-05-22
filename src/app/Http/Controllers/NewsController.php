<?php

namespace App\Http\Controllers;

use App\Http\Repositories\NewsRepository;
use App\Models\News;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Routing\Controller;

class NewsController extends Controller
{

    public function __construct(private NewsRepository $newsRepository)
    {
        $this->middleware('auth');
    }


    public function search(Request $request)
    {
        $news = $this->newsRepository->search($request->validate(['search' => 'string|max:255']));
        return Inertia::render('News')->with('news', $news);
    }

}

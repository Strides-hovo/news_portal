<?php

namespace App\Http\Controllers;

use App\Http\Repositories\NewsRepository;
use App\Models\News;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Routing\Controller;
use Inertia\Response;

class NewsController extends Controller
{

    public function __construct(private NewsRepository $newsRepository)
    {
        $this->middleware('auth');
    }


    public function search(Request $request): Response
    {
        $news = $this->newsRepository->search($request->validate(['search' => 'string|max:255']));
        return Inertia::render('News')->with('news', $news);
    }

}

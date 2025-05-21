<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Routing\Controller;

class NewsController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search');
        $news = News::where('content', 'like', '%' . $search . '%')->orWhere('preview', 'like', '%' . $search . '%')->paginate(12);

        return Inertia::render('News')->with('news', $news);
    }

}

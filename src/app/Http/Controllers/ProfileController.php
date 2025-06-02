<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function dashboard(): Response
    {
        return Inertia::render('Dashboard');
    }


    public function users(): Response
    {
        $users = User::all();
        return Inertia::render('Users', compact('users'))->with('users', $users);
    }


    public function news(): Response
    {
        $news = News::paginate(12);
        return Inertia::render('News')->with('news', $news);
    }

    public function show(News $id): Response
    {
        $title = Str::title($id->preview);
        $like = Str::words($id->preview, 2,null);
        $id->title = $title;

        $similar = News::where('id','!=', $id->id)
            ->whereRaw(
            "MATCH(content, preview) AGAINST (? IN NATURAL LANGUAGE MODE)",
        [$like])
            ->limit(4)
            ->get()
            ->each(fn($i) => $i->title = Str::title($i->preview) );

        return Inertia::render('NewsItem')->with(['news'=> $id, 'similar' => $similar, 'like' => $like]);
    }
}

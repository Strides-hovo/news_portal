<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function dashboard()
    {
        return Inertia::render('Dashboard');
    }


    public function users()
    {
        $users = User::all();
        return Inertia::render('Users', compact('users'))->with('users', $users);
    }


    public function news()
    {
        $news = News::paginate(12);

        return Inertia::render('News')->with('news', $news);
    }



}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(Request $request) {
        //
        // $posts = Auth::user()->posts()->latest()->paginate(6);

        $searchTerm = $request->input('search');
        
        // Query posts: If search term is provided, filter by title or content
        $posts = Auth::user()->posts()
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where('title', 'like', '%' . $searchTerm . '%')
                      ->orWhere('body', 'like', '%' . $searchTerm . '%');
            })
            ->latest()
            ->paginate(6);

        return view('users.dashboard', ['user' => Auth::user(), 'posts' => $posts]);
    }
}

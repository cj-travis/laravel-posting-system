<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(Request $request) {

        // input value
        $searchTerm = $request->input('search');
        
        // query the result if input is not empty filter by title or content
        $posts = Auth::user()->posts()
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where('title', 'like', '%' . $searchTerm . '%')
                      ->orWhere('body', 'like', '%' . $searchTerm . '%');
            })
            ->where('user_id', Auth::user()->id)
            ->latest()
            ->paginate(6);

        // redirect to dashboard
        return view('users.dashboard', ['user' => Auth::user(), 'posts' => $posts]);
    }
}

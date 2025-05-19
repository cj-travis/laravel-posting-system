<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
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

    public function adminDashboard(Request $request) {

        $searchTerm = $request->input('search'); // value from search input field
        $table = $request->input('table', 'users'); // value from the table dropdown 

        $result = null;
    
        if ($table == 'users') {
            // $result = User::withCount('posts')->orderBy('id', 'asc')->get();

            $result = User::when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('id', 'like', '%' . $searchTerm . '%')
                    ->orWhere('username', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%')
                    ->orWhere('created_at', 'like', '%' . $searchTerm . '%')
                    ->orWhere('role', 'like', '%' . $searchTerm . '%')
                    ->orWhere('status', 'like', '%' . $searchTerm . '%');
        })->withCount('posts')->orderBy('id', 'asc')->get();

        }
        else {
            $result = Post::when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('id', 'like', '%' . $searchTerm . '%')
                    ->orWhere('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('body', 'like', '%' . $searchTerm . '%')
                    ->orWhere('user_id', 'like', '%' . $searchTerm . '%')
                    ->orWhere('created_at', 'like', '%' . $searchTerm . '%')
                    ->orWhere('status', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('user', function ($q) use ($searchTerm) {
                        $q->where('username', 'like', '%' . $searchTerm . '%');
                    });
        })->orderBy('id', 'asc')->get();
            // $result = Post::orderBy('id', 'asc')->get();
        }

    //    dd($result);
        return view('admin.dashboard', ['result' => $result]);

    }
}

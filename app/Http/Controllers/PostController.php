<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $posts = Post::orderBy('likes', 'desc')->paginate(6);

        // dd($posts);

        return view('public.index', ['posts' => $posts] );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        // Validate
        $fields = $request->validate([
            'title' => ['required', 'max:255'],
            'body' => ['required'],
            'image' => ['nullable', 'file', 'max:1000', 'mimes:webp,png,jpg,jpeg'],
        ]);

        // store image if exists
        $path = null;
        if ($request->hasFile('image'))
        {
            $path = Storage::disk('public')->put('posts_images', $request->image);
        }

        $fields['image'] = $path;

        $post = Auth::user()->posts()->create($fields);

        // Redirect to dashboard
        return back()->with('success', 'Post was created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $postComments = $post->comments()->latest()->paginate(10);

        // dd($postComments);

        return view('posts.show', ['comments' => $postComments, 'post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // posts authorization
        Gate::authorize('modify', $post);

        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('modify', $post);

    
        // Validate
        $fields = $request->validate([
            'title' => ['required', 'max:255'],
            'body' => ['required'],
            'image' => ['nullable', 'file', 'max:1000', 'mimes:webp,png,jpg,jpeg'],
        ]);


        // store image if exists
        $path = $post->image ?? null;
        if ($request->hasFile('image'))
        {
            if ($post->image)
            {
                Storage::disk('public')->delete($post->image);
            }
            $path = Storage::disk('public')->put('posts_images', $request->image);
        }

        // Update a post
        // Post::create(['user_id' => Auth::id(), ...$fields]);
        $post->update([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $path
        ]);

        // Redirect to dashboard
        return redirect()->route('dashboard')->with('success', 'Post was updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('modify', $post);

        // delete image if exists
        if ($post->image)
        {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();
        return back()->with('deleted', 'Post was deleted');
    }


    public function posts(Request $request)
    {
        $searchTerm = $request->input('search');
        $sort = $request->input('sort', 'new');
    
        $posts = Post::when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('body', 'like', '%' . $searchTerm . '%');
        })
        ->when($sort, function ($query) use ($sort) {
            if ($sort === 'old') {
                $query->oldest();
            } elseif ($sort === 'like') {
                $query->orderBy('likes', 'desc');
            } else {
                $query->latest();
            }
        })
        ->paginate(6);

        return view('posts.posts', ['posts' => $posts] );
    }
}

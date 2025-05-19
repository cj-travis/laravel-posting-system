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
        // get the most 6 likes posts where its or its user is not blocked
        $posts = Post::where('status', '!=', 'blocked')
            ->whereHas('user', function ($query) {
                $query->where('status', '!=', 'blocked');
            })
            ->orderBy('likes', 'desc')
            ->paginate(6);

        // redirect
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

        // set the image path
        $fields['image'] = $path;

        // create post
        $post = Auth::user()->posts()->create($fields);

        // Redirect to dashboard
        return back()->with('success', 'Post was created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // display the comments of the posts where users are not blocked
        $postComments = $post->comments()->whereHas('user', function ($query) {
                $query->where('status', '!=', 'blocked');
            })->latest()->paginate(10);

        // redirect to the view along with the post object and its comments
        return view('posts.show', ['comments' => $postComments, 'post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // check whether the post is modifiable by the user
        Gate::authorize('modify', $post);

        // redirect the user if the user is authorized by the policy
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // check whether the post is modifiable by the user
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

        $post->delete(); // delete the post

        // redirect
        return back()->with('deleted', 'Post was deleted');
    }

    /**
     * Show the posts that were queried
     */
    public function posts(Request $request)
    {
        $searchTerm = $request->input('search'); // value from search input field
        $sort = $request->input('sort', 'new'); // value from the filter dropdown 
    
        // filter the posts if search input field is not empty
        $posts = Post::when($searchTerm, function ($query) use ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                ->orWhere('body', 'like', '%' . $searchTerm . '%')
                ->orWhereHas('user', function ($q2) use ($searchTerm) {
                    $q2->where('username', 'like', '%' . $searchTerm . '%');
                });
            });
        })
        ->where('status', '!=', 'blocked')
        ->whereHas('user', function ($query) {
            $query->where('status', '!=', 'blocked');
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
        ->with('user')
        ->paginate(6);

        // return the current view
        return view('posts.posts', ['posts' => $posts] );
    }

    /**
     * Update post status.
     */
    public function updatePostStatus(Post $post)
    {
        // check logged in user role
        if (Auth::user()->role !== 'admin') {
            // Redirect to dashboard
            return redirect()->route('posts')->with('failed', 'Unauthorized access');
        }

        // new status
        $newStatus = 'blocked';

        // update status
        if ($post->status == 'blocked') {
            $newStatus = 'show';
        }

        $post->status = $newStatus;
        $post->save();

        // Redirect to dashboard
        return back()->with('success', 'Updated post ' . $post->id . ' to ' . $newStatus);

    }
}

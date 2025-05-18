<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Http\Requests\StoreLikeRequest;
use App\Http\Requests\UpdateLikeRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // Validate
        $fields = $request->validate([
            'post_id' => ['required', 'exists:posts,id'],
        ]);

        // set user id as authenticated user id
        $fields['user_id'] = Auth::user()->id;

        // create like data
        Auth::user()->likes()->create($fields);

        // Increment the likes column on the Post model
        $post = Post::find($fields['post_id']); 
        $post->increment('likes');

        // Return the current view with a success message
        return back()->with('success', 'You liked a post!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Like $like)
    {
        // check for authorization from the like policy
        Gate::authorize('modify', $like);

        // decrement the likes column on the Post model
        $post = Post::find($like->post_id); 
        $post->decrement('likes');

        $like->delete(); // delete the like

        // redirect
        return back()->with('deleted', 'Like was deleted');
    }
}

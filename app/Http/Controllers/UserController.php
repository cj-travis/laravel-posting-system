<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = Auth::user();

       return view('users.show', ['user' => $user]);
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
        
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // user authorization
        Gate::authorize('modify', $user);

        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validate
        $fields = $request->validate([
            'username' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(auth()->user()->id)],
            'image' => ['nullable', 'file', 'max:1000', 'mimes:webp,png,jpg,jpeg'],
        ]);


        // store image if exists
        $path = $user->profile_picture ?? null;
        if ($request->hasFile('image'))
        {
            if ($user->profile_picture)
            {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $path = Storage::disk('public')->put('profile_pictures', $request->image);
        }

        // Update a post
        // Post::create(['user_id' => Auth::id(), ...$fields]);
        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'profile_picture' => $path
        ]);

        // Redirect to dashboard
        return redirect()->route('profile')->with('success', 'Profile was updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
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
        
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // show the posts of the user 6 at a time
        $userPosts = $user->posts()->where('status', '!=', 'blocked')
            ->whereHas('user', function ($query) {
                $query->where('status', '!=', 'blocked');
            })->latest()->paginate(6);

        // redirect users to the view with the user's posts and the user object
        return view('users.show', ['posts' => $userPosts, 'user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // user authorization
        Gate::authorize('modify', $user);

        // redirect to the edit post form
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
        return redirect()->route('user.show', $user)->with('success', 'Profile was updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Request $request)
    {
         // user authorization
        Gate::authorize('modify', $user);

        // Validate
        $request->validate([
            'password' => ['required'],
            'delete_account' => ['required']
        ]);

        // Check password
        if (!Hash::check($request->password, $user->password)) {

            // Return an error if the password is incorrect
            return redirect()->route('user.show', $user)->withErrors(['password' => 'incorrect password']);
        }

        // Check password
        if ($request->delete_account !== 'delete') {

            // Return an error if the password is incorrect
            return redirect()->route('user.show', $user)->withErrors(['delete_account' => 'Please ensure its typed correctly']);
        }

        // delete profile picture if exists
        if ($user->profile_picture)
        {
            Storage::disk('public')->delete($user->profile_picture);
        }

        // delete all pictures of user's posts
        foreach ($user->posts as $post) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
        }

        // delete the user
        $user->delete();

        // redirect to goodbye page
        return redirect()->route('goodbye')->with('success', 'Account deleted successfully');
    }

    /**
     * Update user role.
     */
    public function updateRole(User $user)
    {
        // check logged in user role
        if (Auth::user()->role !== 'admin') {
            // Redirect to dashboard
            return redirect()->route('posts')->with('failed', 'Unauthorized access');
        }

        // new role
        $newRole = 'user';

        // update role if updated user role is not himself
        if ($user->id !== Auth::user()->id) {
            if ($user->role == 'user') {
                $newRole = 'admin';
            }

            // update role
            $user->role = $newRole;
            $user->save();

            // Redirect to dashboard
            return redirect()->route('admin-dashboard', $user)->with('success', 'Updated user ' . $user->id . ' to ' . $newRole);
        }

        // Redirect to dashboard with error
        return redirect()->route('admin-dashboard', $user)->with('failed', 'You cannot update your own role');
    }

    /**
     * Update user status.
     */
    public function updateUserStatus(User $user)
    {
        // check logged in user role
        if (Auth::user()->role !== 'admin') {
            // Redirect to dashboard
            return redirect()->route('posts')->with('failed', 'Unauthorized access');
        }

        // new status
        $newStatus = 'blocked';

        // update status if updated user is not himself
        if ($user->id !== Auth::user()->id) {
            if ($user->status == 'blocked') {
                $newStatus = 'active';
            }

            // update status
            $user->status = $newStatus;
            $user->save();

            // Redirect to dashboard
            return back()->with('success', 'Updated user ' . $user->id . ' to ' . $newStatus);
        }

        // Redirect to dashboard with error
        return back()->with('failed', 'You cannot update your own status');
    }
}

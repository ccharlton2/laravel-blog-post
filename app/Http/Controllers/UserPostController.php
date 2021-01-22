<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class UserPostController extends Controller
{
    public function index(User $user)
    {
        // eager load posts and likes

        // $posts = $user->posts()->with(['user, likes'])->paginate(10);
        $posts = Post::with(['user','likes'])->where('user_id', $user->id)->paginate(10);
        // dd($user);
        return view('users.posts.index', [
            'user' => $user,
            'posts' => $posts
        ]);
    }
}

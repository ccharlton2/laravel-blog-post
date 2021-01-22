<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct() {
        // authenticate only store and destroy methods
        $this->middleware(['auth'])->only(['store', 'destroy']);
    }

    public function index()
    {
        // all as a Collection (not ideal if you have hundreds of posts)
        // $posts = Post::get();

        // lazy loading
        // $posts = Post::paginate(10);

        // eager loading
        $posts = Post::latest()->with(['user', 'likes'])->paginate(10);
        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);

        // Post::create([
        //     'user_id' => auth()->id(),
        //     'body' => $request->body
        // ]);

        $request->user()->posts()->create($request->only('body'));

        // returns the user to the previous page
        return back();
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete'. $post);

        $post->delete();

        return back();
    }
}

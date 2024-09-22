<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;

class PostController extends Controller
{
    // Fetch all posts with their associated user and comments
    public function index()
    {
        // Eager-load user for both posts and comments
        $posts = Post::with(['user', 'comments.user'])->latest()->get();
        return response()->json($posts);
    }

    // Store a new post
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $post = Post::create([
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        // Return post along with user info
        return response()->json($post->load('user'), 201);
    }

    // Like a post or remove like (unlike)
    public function like(Post $post)
{
    // Check if the user has already liked the post
    $existingLike = Like::where('user_id', auth()->id())
                        ->where('post_id', $post->id)
                        ->first();

    if ($existingLike) {
        // If the like already exists, remove it (unlike)
        $existingLike->delete();

        // Ensure like_count doesn't go below zero
        if ($post->like_count > 0) {
            $post->like_count--; 
        }
        $post->save();

        return response()->json(['message' => 'Post unliked successfully', 'likes_count' => $post->like_count]);
    }

    // If no existing like, create a new one
    $like = new Like();
    $like->user_id = auth()->id();
    $like->post_id = $post->id;
    $like->save();

    // Increment the like count
    $post->like_count++; 
    $post->save();

    return response()->json(['message' => 'Post liked successfully', 'likes_count' => $post->like_count]);
}

    
    // Add a comment to a post
    public function addComment(Request $request, Post $post)
    {
        $request->validate([
            'comment' => 'required',
        ]);

        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        // Return the comment with the associated user data
        return response()->json($comment->load('user'), 201);
    }
}

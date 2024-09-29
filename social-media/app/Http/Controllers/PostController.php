<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Fetch all posts with their associated user and comments
   // Fetch all posts with the user who created them
public function index()
{
    $posts = Post::with('user')->get(); // Eager-load the user
    return response()->json($posts);
}

// Store a new post with user_id
public function store(Request $request)
{
    $post = Post::create([
        'content' => $request->content,
        'user_id' => auth()->id(), // Ensure the logged-in user is linked
    ]);

    return response()->json($post->load('user')); // Return post with user data
}



    // Update an existing post (only by the owner)
    public function update(Request $request, $postId)
    {
        // Validate the request data
        $request->validate([
            'content' => 'required|string|max:255', // Adjust validation rules as necessary
        ]);

        // Find the post by ID
        $post = Post::findOrFail($postId);

        // Update the post content
        $post->content = $request->input('content');
        $post->save();

        // Return a response
        return response()->json(['message' => 'Post updated successfully', 'post' => $post], 200);
    }


    // Like a post or remove like (unlike)
    public function like(Post $post)
    {
        $existingLike = Like::where('user_id', auth()->id())
                            ->where('post_id', $post->id)
                            ->first();

        if ($existingLike) {
            $existingLike->delete();
            if ($post->like_count > 0) {
                $post->like_count--; 
            }
            $post->save();
            return response()->json(['message' => 'Post unliked successfully', 'likes_count' => $post->like_count]);
        }

        $like = new Like();
        $like->user_id = auth()->id();
        $like->post_id = $post->id;
        $like->save();

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

        return response()->json($comment->load('user'), 201);
    }

    // Edit an existing post (only by the owner)
    public function edit(Request $request, Post $post)
    {
        // Ensure only the post owner can edit the post
        if ($post->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'content' => 'required',
        ]);

        $post->content = $request->input('content');
        $post->save();

        return response()->json($post);
    }
}

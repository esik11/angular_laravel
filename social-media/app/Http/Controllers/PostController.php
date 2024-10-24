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
   // Fetch all posts with the user who created them
   public function index()
   {
       $user = Auth::user();
       // Eager load the user and comments (and the user who made the comment)
       $posts = Post::with(['user', 'comments.user'])->get();
   
       // Append a "user_has_liked" field to each post based on the logged-in user
       $posts->each(function ($post) use ($user) {
           $post->user_has_liked = $post->likes()->where('user_id', $user->id)->exists();
       });
   
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

    // Check if the user has already liked the post
    if ($existingLike) {
        // User already liked the post, so remove the like (unlike)
        $existingLike->delete();
        $post->like_count = max(0, $post->like_count - 1); // Prevent negative like count
        $post->save();

        return response()->json(['message' => 'Post unliked successfully', 'liked' => false, 'likes_count' => $post->like_count]);
    }

    // User has not liked the post yet, so add a like
    $like = new Like();
    $like->user_id = auth()->id();
    $like->post_id = $post->id;
    $like->save();

    $post->like_count++;
    $post->save();

    return response()->json(['message' => 'Post liked successfully', 'liked' => true, 'likes_count' => $post->like_count]);
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
        if($post->user_id !== auth()->id()) {
            $post->user->notify(new CommentNotification($comment));
        }
    
        return response()->json(['message' => 'Comment added successfully']);
    
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
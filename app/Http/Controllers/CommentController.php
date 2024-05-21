<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request)
    {
        // get post 
        $post = Post::where("id", $request->post_id)->first();
        // if (!$post) {
        //     return redirect()->back()->with("error", "No Post!");
        // }

        $post->comments()->create([
            ...$request->validated(),
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('posts.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        $comment->update($request->validated());
        return redirect()->back()->with('success', 'Comment updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->user()->id) {
            return redirect()->back()->with('error', 'Comment does not belongs to you!');
        }

        // else 
        $comment->delete();
        return redirect()->back()->with('success', 'Comment deleted successfully!');
    }
}

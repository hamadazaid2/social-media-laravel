<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReactionRequest;
use App\Models\Post;
use App\Models\Reaction;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    public function likeOrUnlike(Request $request)
    {
        // check post existence 
        $post = Post::findOrFail($request->post_id);
        $reaction = Reaction::where("user_id", auth()->id())
            ->where("post_id", $request->post_id)->first();

        if ($reaction) {
            // unLike post 
            $reaction->delete();
        } else {
            Reaction::create([
                'user_id' => auth()->user()->id,
                'post_id' => $post->id,
            ]);
        }
        return redirect()->route('posts.index');
    }

}

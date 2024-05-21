<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\CategoryLookup;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('posts.index', [
            'posts' => $this->getPostsQuery()->paginate(10)
        ]);
    }

    public function myPosts()
    {
        return view('posts.my-posts', [
            'posts' => $this->getPostsQuery(auth()->user()->id)->paginate(10)
        ]);
    }

    private function getPostsQuery($userId = null)
    {
        $query = Post::latest()
            ->with([
                'user',
                'comments' => function ($query) {
                    $query->latest()->take(3);
                },
                'comments.user'
            ])
            ->withCount('reactions');

        if ($userId) {
            $query->where('user_id', $userId);
        }

        return $query;
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(
            'posts.create',
            ['categories' => CategoryLookup::all()]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $request->user()->posts()->create($request->validated());
        return redirect()->route('posts.index')->with('success', 'Post just published!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', ['post' => $post, 'categories' => CategoryLookup::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $this->checkUserAccess($post);
        $post->update([
            ...$request->validated(),
            'category_lookup_id' => $request->validated()['category_id'] ?? null
        ]);
        return redirect()->route('posts.index')
            ->with('success', 'Post updated succefully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->checkUserAccess($post);
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
    }

    protected function checkUserAccess(Post $post)
    {
        if (auth()->user()->id !== $post->user_id && auth()->user()->role !== 'ADMIN') {
            return redirect()->route('posts.index')->with('error', 'Unauthorized!');
        }
    }
}

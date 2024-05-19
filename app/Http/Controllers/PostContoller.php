<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\CategoryLookup;
use App\Models\Post;
use Illuminate\Http\Request;

class PostContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('posts.index', ['posts' => Post::latest()->with('user')->get()]);
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

<?php

namespace App\Http\Controllers;

use App\Http\Requests\FollowerRequest;
use App\Models\Follower;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { {
            $userId = auth()->user()->id;

            // Get followers and following users
            $followers = Follower::where('follower_user_id', $userId)->with('following_user')->get();
            $following = Follower::where('following_user_id', $userId)->with('follower_user')->get();

            return view('followers.index', compact('followers', 'following'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FollowerRequest $request)
    {
        // 
        if ($request->follower_user_id === auth()->user()->id) {
            return redirect()->back()->with('error', 'You can\'t follow your self');
        }
        // check if already followed 

        $isAlreadyFollowed = auth()->user()->followers()
            ->where('follower_user_id', $request->follower_user_id)->exists();


        if ($isAlreadyFollowed)
            return redirect()->back()->with('error', 'You already followed this user !');

        // else 
        // return $request->validated();
        Follower::create(
            [
                'following_user_id' => auth()->user()->id,
                ...$request->validated()
            ]
        );

        return redirect()->back();
    }

    public function destroy(FollowerRequest $request)
    {
        // checking 
        $follower = Follower::where('follower_user_id', $request->follower_user_id)
            ->where('following_user_id', auth()->user()->id)->first();
        if (!$follower) {
            return redirect()->back()->with('error', 'You are not following this user');
        }

        $follower->delete();
        return redirect()->back();
    }
}

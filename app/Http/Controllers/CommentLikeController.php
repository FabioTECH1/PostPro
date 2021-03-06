<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Comment_like;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use App\Models\User;


class CommentLikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //liking a comment
    public function store(Post $post, Comment $comment, Request $request)
    {
        $comment->comment_likes()->create([
            'user_id' => $request->user()->id,
        ]);
        // if (!$post->likes()->onlyTrashed()->where('user_id', $request->user()->id)->count()) {
        //     Mail::to($post->user)->send(new PostLiked(auth()->user(), $post));
        // }
        return back();
    }
    // unliking a comment
    public function destroy(Comment $comment, Request $request)
    {
        Comment_like::where('comment_id', $comment->id)->where('user_id', $request->user()->id)->delete();
        return back();
    }
}
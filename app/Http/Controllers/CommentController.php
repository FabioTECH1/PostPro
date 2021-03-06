<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Post $post, Request $request)
    {
        $post->comments()->create([
            'comment' => Request('comment'),
            'user_id' => $request->user()->id,
            'commenter' => auth()->user()->name,
        ]);
        // // if (!$post->likes()->onlyTrashed()->where('user_id', $request->user()->id)->count()) {
        // //     Mail::to($post->user)->send(new PostLiked(auth()->user(), $post));
        // // }
        return back();
    }
    public function destroy($id, Request $request)
    {
        $infos = Comment::where('id', $id)->get();
        foreach ($infos as $info) {
            //prevents unauthorized user hacking and deleting a post
            if ($info->user_id != auth()->user()->id) {
                return response(null, 409);
            } else
                Comment::where('id', $id)->delete();
            return back();
        }
    }
}
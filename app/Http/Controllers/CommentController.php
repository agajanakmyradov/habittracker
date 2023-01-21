<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentStoreRequest;
use App\Models\Comment;
use Auth;

class CommentController extends Controller
{
    
    public function store(CommentStoreRequest $request, $id)
    {   
        $comment = new Comment;
        $comment->tracker_id = $id;
        $comment->text = $request->input('text');
        $comment->save();

        return back();
    }

    public function delete($id)
    {
        Comment::find($id)->delete();

        return back();
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);
        $comment->text = $request->input('text');
        $comment->save();

        return back();
    }
}

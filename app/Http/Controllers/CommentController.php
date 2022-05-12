<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string:max100',
            'text' => 'required|string',
            'recipient_id' => 'required|int',
        ]);

        Comment::create($validated + ['user_id' => auth()->id()]);

        return redirect()->back();
    }

    public function delete(int $id)
    {
        $comment = Comment::where('id', $id)
            ->where(function ($query) {
               $query
                   ->where('recipient_id', auth()->id())
                   ->orWhere('user_id', auth()->id());
            })->firstOrFail();

        $comment->delete();

        return redirect()->back();
    }

    public function load(Request $request)
    {
        $skip = 5;

        $validated = $request->validate([
            'recipient_id' => 'required|int',
        ]);

        $countAll = Comment::with('user')
            ->where('recipient_id', $validated['recipient_id'])
            ->count();

        $comments = Comment::with('user')
            ->where('recipient_id', $validated['recipient_id'])
            ->skip($skip)
            ->take($countAll - $skip)
            ->get();
        return response()->json(['comments' => $comments]);
    }
}

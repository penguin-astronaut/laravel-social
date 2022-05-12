<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
}

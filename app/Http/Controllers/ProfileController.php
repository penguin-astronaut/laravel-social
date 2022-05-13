<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;


class ProfileController extends Controller
{
    public function board(int $userId)
    {
        $user = User::findOrFail($userId);
        $comments = Comment::with(['user', 'parent'])
            ->where('recipient_id', $userId)
            ->take(5)
            ->get();

        return view('home', ['comments' => $comments, 'owner' => $user]);
    }
}

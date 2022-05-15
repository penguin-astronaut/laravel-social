<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;


class ProfileController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('users', ['users' => $users]);
    }

    public function board(int $userId)
    {
        $user = User::with('hasLibraryAccess')->findOrFail($userId);
        $comments = Comment::with(['user', 'parent'])
            ->where('recipient_id', $userId)
            ->take(5)
            ->get();

        $isActiveAccess = $user->hasLibraryAccess->first(fn($val) => $val->id === auth()->id());

        return view('home', ['comments' => $comments, 'owner' => $user, 'isActiveAccess' => $isActiveAccess]);
    }
}

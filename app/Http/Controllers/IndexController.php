<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $comments = Comment::with('user')->where('recipient_id', auth()->id())->take(5)->get();

        return view('home', ['owner' => auth()->user(), 'comments' => $comments]);
    }
}

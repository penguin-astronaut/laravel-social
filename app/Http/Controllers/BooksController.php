<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BooksController extends Controller
{
    public function index()
    {
        $books = Books::where('user_id', auth()->id())->get();
        return view('books.index', ['books' => $books]);
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string:max100',
            'text' => 'required|string',
        ]);

        $validated += [
            'user_id' => auth()->id(),
            'shared' => $request->get('shared') ? 1 : 0
        ];

        Books::create($validated);

        return redirect()->route('books.index');
    }

    public function show(Request $request)
    {
        return view('books.show', ['book' => $request->get('book')]);
    }

    public function edit(Request $request)
    {
        return view('books.edit', ['book' => $request->get('book')]);
    }

    public function update(Request $request)
    {
        $book = $request->get('book');

        $validated = $request->validate([
            'title' => 'required|string:max100',
            'text' => 'required|string',
        ]);
        $validated += [
            'user_id' => auth()->id(),
            'shared' => $request->get('shared') ? 1 : 0
        ];

        $book->update($validated);

        return redirect()->route('books.index');
    }

    public function destroyAll(Request $request)
    {
        $request->get('book')->delete();

        return redirect()->route('books.index');
    }

    public function shared(Request $request)
    {
        $request->get('book')->shared = true;
        $request->get('book')->save();

        return redirect()->back();
    }

    public function unshared(Request $request)
    {
        $request->get('book')->shared = false;
        $request->get('book')->save();

        return redirect()->back();
    }

    public function sharedAll(int $userId)
    {
        $user = auth()->user();
        User::findOrFail($userId);
        $user->readers()->attach($userId);

        return redirect()->back();
    }

    public function unsharedAll(int $userId)
    {
        $user = auth()->user();

        User::findOrFail($userId);
        $user->readers()->detach($userId);

        return redirect()->back();
    }
}

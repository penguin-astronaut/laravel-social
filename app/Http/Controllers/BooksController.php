<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function index()
    {
        $books = Books::all();
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

    public function destroy(Request $request)
    {
        $request->get('book')->delete();

        return redirect()->route('books.index');
    }
}

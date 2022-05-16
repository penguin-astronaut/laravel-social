<?php

namespace App\Http\Middleware;

use App\Models\Books;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookAccess
{
    /**
     * Check access for book
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $book = Books::findOrFail($request->route('book'));

        if (!$book->shared && !auth()->id()) {
            return abort(404);
        }

        if (!$book->shared && $book->user_id !== auth()->id()) {
            $hasAccess = DB::table('books_access')
                ->where('owner_id', $book->user_id)
                ->where('reader_id', auth()->id())
                ->first();
            if (!$hasAccess) {
                return abort(404);
            }
        }

        $request->merge(['book' => $book]);

        return $next($request);
    }
}
